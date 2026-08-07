<?php

namespace App\Console\Commands;

use App\Jobs\ProcessApplication;
use App\Models\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TestQueueProcess extends Command
{
    protected $signature = 'test:queue-process';
    protected $description = 'Process all pending queue jobs and measure performance';

    public function handle()
    {
        $pendingJobs = DB::table('jobs')->count();
        $this->info("Pending jobs in queue: {$pendingJobs}");
        $this->newLine();

        if ($pendingJobs === 0) {
            $this->error("No jobs to process. Run test:application-load first.");
            return Command::FAILURE;
        }

        // Measure full processing time using time command
        $this->info("Processing all {$pendingJobs} jobs...");
        $startTime = microtime(true);
        
        // Use PHP exec to run queue:work in background and measure
        // Process in batch of 50 using artisan queue:work --max-jobs=50
        $totalProcessed = 0;
        
        while (DB::table('jobs')->count() > 0) {
            $remaining = DB::table('jobs')->count();
            $this->line("  Processing batch... ({$remaining} remaining)");
            
            // Run queue:work with --max-jobs=50 to process in batches
            $output = [];
            $exitCode = 0;
            exec('cd ' . base_path() . ' && php artisan queue:work --max-jobs=50 --timeout=30 --tries=3 2>&1', $output, $exitCode);
            
            $apps = Application::where('sNameEnglish', 'LIKE', 'Test Student%')->count();
            $totalProcessed = $apps;
            $remainingAfter = DB::table('jobs')->count();
            
            $this->line("  Batch done. Apps: {$apps} | Remaining: {$remainingAfter}");
            
            if ($remainingAfter >= $remaining) {
                // No progress, break to avoid infinite loop
                $this->warn("  No progress made, breaking...");
                break;
            }
        }
        
        $totalTime = round((microtime(true) - $startTime) * 1000, 2);
        $avgTime = $totalProcessed > 0 ? round($totalTime / $totalProcessed, 2) : 0;
        
        $this->newLine();
        $this->info("========================================");
        $this->info("  QUEUE PROCESSING RESULTS");
        $this->info("========================================");
        $this->info("Jobs processed: {$totalProcessed}");
        $this->info("Total time: {$totalTime}ms");
        $this->info("Avg per job: {$avgTime}ms");
        $this->info("Throughput: " . round($totalProcessed / ($totalTime / 1000), 2) . " jobs/sec");
        $this->info("Total applications in DB: " . Application::where('sNameEnglish', 'LIKE', 'Test Student%')->count());
        $this->info("Remaining jobs: " . DB::table('jobs')->count());
        $this->info("========================================");

        return Command::SUCCESS;
    }
}
