<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ExternalApiService;

class StudentApplicationController extends Controller
{
    protected $apiService;

    public function __construct(ExternalApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function create()
    {
        $options = [
            'programs' => $this->apiService->getPrograms() ?: [],
            'admissionSessions' => $this->apiService->getAdmissionSessions() ?: [],
            'allSessions' => $this->apiService->getAllSessions() ?: [],
            'groups' => [],
            'occupations' => $this->apiService->getOccupations() ?: [],
            'qualifications' => $this->apiService->getQualifications() ?: [],
            'districts' => $this->apiService->getDistricts() ?: [],
            'boards' => $this->apiService->getBoards() ?: [],
            'constants' => $this->apiService->getConstants() ?: [],
            'apiBaseUrl' => rtrim(config('services.external_api.base_url'), '/'),
        ];

        return view('applications.create', compact('options'));
    }

    public function store(Request $request)
    {
        // Validation (simplified for brevity)
        $validated = $request->validate([
            'sNameEnglish' => 'required|string|max:255',
            'sNameBangla' => 'required|string|max:255',
            'program' => 'required',
            'session' => 'required',
            'group' => 'required',
            'sMobileNo' => 'required|string|max:20',
            'bitId' => 'nullable|numeric',
            'nid' => 'nullable|numeric',
            'fMobileNo' => 'nullable|string|max:20',
            'fNid' => 'nullable|numeric',
            'fMonthlyIncome' => 'nullable|numeric',
            'mMobileNo' => 'nullable|string|max:20',
            'mNid' => 'nullable|numeric',
            'mMonthlyIncome' => 'nullable|numeric',
            'gMobileNo' => 'nullable|string|max:20',
            'gNid' => 'nullable|numeric',
            'refMobileNo' => 'nullable|string|max:20',
            'refNid' => 'nullable|numeric',
            'gpa1' => 'nullable|numeric',
            'gpa2' => 'nullable|numeric',
        ]);

        $data = $request->all();

        // Handle File Uploads (sPicture)
        if ($request->hasFile('sPicture')) {
            $path = $request->file('sPicture')->store('public/students');
            $data['sPicture'] = Storage::url($path);
        }

        // Generate a PIN code (YYXXXX format)
        // 1. Get Session Name if session is an ID
        $sessionName = $request->input('session');
        $sessions = $this->apiService->getAdmissionSessions() ?: [];
        foreach ($sessions as $s) {
            if (is_object($s) && $s->id == $sessionName) {
                $sessionName = $s->session;
                break;
            } elseif (is_array($s) && $s['id'] == $sessionName) {
                $sessionName = $s['session'];
                break;
            }
        }

        // 2. Extract YY (last two digits of the second year, e.g., "2024-2025" -> 25)
        $yy = '00';
        if (preg_match('/(\d{2,4})-(\d{2,4})/', $sessionName, $matches)) {
            $yy = substr($matches[2], -2);
        } elseif (preg_match('/\d{2,4}/', $sessionName, $matches)) {
             $yy = substr($matches[0], -2);
        }

        // 3. Find next sequence
        $prefix = $yy;
        $lastApplication = Application::where('pinCode', 'like', $prefix . '%')
            ->whereRaw('LENGTH(pinCode) = 6')
            ->orderBy('pinCode', 'desc')
            ->first();

        if ($lastApplication) {
            $lastSeq = (int) substr($lastApplication->pinCode, 2);
            $nextSeq = str_pad($lastSeq + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextSeq = '0001';
        }

        $data['pinCode'] = $prefix . $nextSeq;

        $application = Application::create($data);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'application_id' => $application->id,
                'pinCode' => $application->pinCode
            ]);
        }

        return redirect()->route('applications.show', $application->id);
    }

    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    public function download(Application $application)
    {
        $pdf = Pdf::loadView('applications.pdf', compact('application'));
        return $pdf->download('application-' . $application->id . '.pdf');
    }

    public function proxyGroups($programId)
    {
        $groups = $this->apiService->getGroups($programId);
        return response()->json($groups);
    }

    public function proxySubjects($programId, $groupId)
    {
        $subjects = $this->apiService->getHscCourses($programId, $groupId);
        return response()->json($subjects);
    }
}
