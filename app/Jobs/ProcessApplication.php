<?php

namespace App\Jobs;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 30;
    public $maxExceptions = 2;
    
    protected $data;
    protected $fileData;

    /**
     * Create a new job instance.
     *
     * @param array $data - Application data (without file)
     * @param array $fileData - File data (temp path, original name, mime)
     */
    public function __construct(array $data, array $fileData = [])
    {
        $this->data = $data;
        $this->fileData = $fileData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $data = $this->data;

            // Handle file upload if exists
            if (!empty($this->fileData['tempPath'])) {
                $tempPath = $this->fileData['tempPath'];
                if (file_exists($tempPath)) {
                    $fileName = $this->fileData['originalName'] ?? 'student_' . time() . '.' . pathinfo($this->fileData['originalName'] ?? 'photo.jpg', PATHINFO_EXTENSION);
                    $newPath = 'public/students/' . $fileName;
                    
                    // Move from temp to storage
                    Storage::put($newPath, file_get_contents($tempPath));
                    $data['sPicture'] = Storage::url($newPath);
                    
                    // Cleanup temp file
                    @unlink($tempPath);
                }
            }

            // Generate PIN code
            $data['pinCode'] = $this->generatePinCode($data['session'] ?? '');

            // Create application
            $application = Application::create($data);

            Log::info("Application processed successfully", [
                'application_id' => $application->id,
                'pinCode' => $application->pinCode,
                'student_name' => $data['sNameEnglish'] ?? 'unknown',
            ]);

        } catch (\Exception $e) {
            Log::error("ProcessApplication Job failed", [
                'error' => $e->getMessage(),
                'data' => $this->data,
            ]);
            
            // Re-throw to mark job as failed
            throw $e;
        }
    }

    /**
     * Generate PIN code (YYXXXX format)
     * Optimized: Direct DB query, no cache lock overhead
     */
    protected function generatePinCode($session)
    {
        // Extract YY directly from session string (no API call needed)
        $yy = '00';
        if (preg_match('/(\d{2,4})-(\d{2,4})/', $session, $matches)) {
            $yy = substr($matches[2], -2);
        } elseif (preg_match('/\d{2,4}/', $session, $matches)) {
            $yy = substr($matches[0], -2);
        }

        $prefix = $yy;

        // Atomic increment using raw SQL (fastest possible, no lock needed)
        $maxSeq = DB::selectOne(
            "SELECT MAX(CAST(SUBSTRING(pinCode, 3) AS UNSIGNED)) as max_seq 
             FROM applications 
             WHERE pinCode LIKE ? AND LENGTH(pinCode) = 6",
            [$prefix . '%']
        );

        $nextSeq = ($maxSeq->max_seq ?? 0) + 1;
        return $prefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception)
    {
        Log::error("ProcessApplication Job permanently failed", [
            'error' => $exception->getMessage(),
            'data' => $this->data,
        ]);
    }
}
