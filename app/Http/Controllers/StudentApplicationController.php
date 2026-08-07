<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Jobs\ProcessApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ExternalApiService;
use Illuminate\Support\Facades\Log;

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
        // Strong server-side validation
        $validated = $request->validate([
            'sNameEnglish' => 'required|string|max:255',
            'sNameBangla' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'session' => 'required|string|max:255',
            'group' => 'required|string|max:255',
            'sMobileNo' => 'required|string|max:20',
            'bloodGroup' => 'nullable|string|max:20',
            'religion' => 'nullable|string|max:50',
            'gender' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'bitId' => 'nullable|numeric',
            'nid' => 'nullable|numeric',
            'nationality' => 'nullable|string|max:50',
            'maritalStatus' => 'nullable|string|max:20',
            'sPicture' => 'nullable|image|max:2048',
            // Father
            'fName' => 'nullable|string|max:255',
            'fNid' => 'nullable|numeric',
            'fQualification' => 'nullable|string|max:255',
            'fOccupation' => 'nullable|string|max:255',
            'fMonthlyIncome' => 'nullable|numeric',
            'fMobileNo' => 'nullable|string|max:20',
            // Mother
            'mName' => 'nullable|string|max:255',
            'mNid' => 'nullable|numeric',
            'mQualification' => 'nullable|string|max:255',
            'mOccupation' => 'nullable|string|max:255',
            'mMonthlyIncome' => 'nullable|numeric',
            'mMobileNo' => 'nullable|string|max:20',
            // Guardian
            'gName' => 'nullable|string|max:255',
            'gNid' => 'nullable|numeric',
            'gRelation' => 'nullable|string|max:100',
            'gMobileNo' => 'nullable|string|max:20',
            'gEmail' => 'nullable|email|max:255',
            'gAddress' => 'nullable|string',
            // Reference
            'refName' => 'nullable|string|max:255',
            'refNid' => 'nullable|numeric',
            'refRelation' => 'nullable|string|max:100',
            'refMobileNo' => 'nullable|string|max:20',
            'refEmail' => 'nullable|email|max:255',
            'refAddress' => 'nullable|string',
            // Permanent Address
            'permanentAddressVil' => 'nullable|string|max:255',
            'permanentAddressPO' => 'nullable|string|max:255',
            'permanentAddressPS' => 'nullable|string|max:255',
            'permanentAddressDist' => 'nullable|string|max:255',
            // Present Address
            'presentAddressVil' => 'nullable|string|max:255',
            'presentAddressPO' => 'nullable|string|max:255',
            'presentAddressPS' => 'nullable|string|max:255',
            'presentAddressDist' => 'nullable|string|max:255',
            // SSC
            'examName1' => 'nullable|string|max:255',
            'rollNo1' => 'nullable|string|max:50',
            'regNo1' => 'nullable|string|max:50',
            'sessionExam1' => 'nullable|string|max:50',
            'gpa1' => 'nullable|numeric',
            'passingYear1' => 'nullable|string|max:10',
            'Board1' => 'nullable|string|max:50',
            // HSC
            'examName2' => 'nullable|string|max:255',
            'rollNo2' => 'nullable|string|max:50',
            'regNo2' => 'nullable|string|max:50',
            'sessionExam2' => 'nullable|string|max:50',
            'gpa2' => 'nullable|numeric',
            'passingYear2' => 'nullable|string|max:10',
            'Board2' => 'nullable|string|max:50',
            // Subjects
            'compulsory1' => 'nullable|string|max:255',
            'compulsory2' => 'nullable|string|max:255',
            'compulsory3' => 'nullable|string|max:255',
            'elective1' => 'nullable|string|max:255',
            'elective2' => 'nullable|string|max:255',
            'elective3' => 'nullable|string|max:255',
            'optional' => 'nullable|string|max:255',
            // Extra
            'hobby' => 'nullable|string|max:255',
            'extracurriculam' => 'nullable|string|max:255',
        ]);

        // Check for duplicate application (mobile + program + session)
        $duplicate = Application::where('sMobileNo', $validated['sMobileNo'])
            ->where('program', $validated['program'])
            ->where('session', $validated['session'])
            ->first();

        if ($duplicate) {
            $message = 'You have already applied for this program in this session. Your PIN: ' . $duplicate->pinCode;
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'pinCode' => $duplicate->pinCode,
                    'application_id' => $duplicate->id,
                ], 409);
            }
            
            return redirect()->route('applications.show', $duplicate->id)
                ->with('info', $message);
        }

        // Handle file upload - save to temp, job will move to permanent storage
        $fileData = [];
        if ($request->hasFile('sPicture')) {
            $file = $request->file('sPicture');
            $tempPath = $file->store('temp/applications');
            $fileData = [
                'tempPath' => storage_path('app/' . $tempPath),
                'originalName' => $file->getClientOriginalName(),
                'mimeType' => $file->getMimeType(),
            ];
        }

        // Dispatch to queue (non-blocking, server responds immediately)
        ProcessApplication::dispatch($validated, $fileData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully! Processing...',
                'queued' => true,
            ]);
        }

        return redirect()->route('apply')
            ->with('success', 'Application submitted successfully! It will be processed shortly.');
    }

    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    public function download(Application $application)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('applications.pdf', compact('application'));
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
