<?php

namespace App\Http\Controllers;

use App\Models\TeacherApplication;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TeacherApplicationController extends Controller
{
    public function create()
    {
        return view('teacher-applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacherName' => 'required|string|max:255',
            'teacherNameBangla' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'fatherName' => 'nullable|string|max:255',
            'motherName' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:50',
            'bloodGroup' => 'nullable|string|max:10',
            'dob' => 'nullable|string|max:20',
            'nid' => 'nullable|numeric',
            'presentAddress' => 'nullable|string',
            'upazilaThana' => 'nullable|string|max:255',
            'zillaPostOffice' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'nidScan' => 'nullable|file|max:5120',
            // SSC
            'sscExamType' => 'nullable|string|max:100',
            'sscBoard' => 'nullable|string|max:100',
            'sscYear' => 'nullable|string|max:10',
            'sscResult' => 'nullable|string|max:50',
            'sscRegistrationNo' => 'nullable|string|max:100',
            'sscMarksheetScan' => 'nullable|file|max:5120',
            // HSC
            'hscExamType' => 'nullable|string|max:100',
            'hsceBoard' => 'nullable|string|max:100',
            'hscYear' => 'nullable|string|max:10',
            'hscResult' => 'nullable|string|max:50',
            'hscRegistrationNo' => 'nullable|string|max:100',
            'hscMarksheetScan' => 'nullable|file|max:5120',
            // Graduation
            'graduationExamType' => 'nullable|string|max:100',
            'graduationSubject' => 'nullable|string|max:255',
            'graduationResult' => 'nullable|string|max:50',
            'graduationYear' => 'nullable|string|max:10',
            'graduationMarksheetScan' => 'nullable|file|max:5120',
            // Masters
            'mastersExamType' => 'nullable|string|max:100',
            'mastersResult' => 'nullable|string|max:50',
            'mastersYear' => 'nullable|string|max:10',
            'mastersCertificateScan' => 'nullable|file|max:5120',
            // Professional
            'bedResult' => 'nullable|string|max:50',
            'medResult' => 'nullable|string|max:50',
            'bedCertificateScan' => 'nullable|file|max:5120',
            // Others
            'othersExam' => 'nullable|string|max:255',
            'othersExamResult' => 'nullable|string|max:50',
            'othersExamDocument' => 'nullable|file|max:5120',
            // Experience
            'institutionType' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:255',
            'sscSubjectTeacher' => 'nullable|string|max:10',
            'hscSubjectTeacher' => 'nullable|string|max:10',
            'previousInstitution' => 'nullable|string|max:255',
            'previousDesignation' => 'nullable|string|max:255',
            'previousJoinDate' => 'nullable|date',
            'previousRelieveDate' => 'nullable|date',
            'experienceCertificateScan' => 'nullable|file|max:5120',
        ]);

        // Exclude file fields from direct insert
        $data = $request->except([
            'photo', 'nidScan',
            'sscMarksheetScan',
            'hscMarksheetScan',
            'graduationMarksheetScan',
            'mastersCertificateScan', 'bedCertificateScan',
            'othersExamDocument', 'experienceCertificateScan',
        ]);

        // Helper function for file uploads
        $uploadFile = function($fieldName, $folder) use ($request) {
            if ($request->hasFile($fieldName)) {
                $path = $request->file($fieldName)->store('public/' . $folder);
                return Storage::url($path);
            }
            return null;
        };

        // Upload all files
        $data['profileScan'] = $uploadFile('photo', 'teachers/photos');
        $data['nidScan'] = $uploadFile('nidScan', 'teachers/docs');
        $data['sscMarksheetScan'] = $uploadFile('sscMarksheetScan', 'teachers/edu');
        $data['hscMarksheetScan'] = $uploadFile('hscMarksheetScan', 'teachers/edu');
        $data['graduationMarksheetScan'] = $uploadFile('graduationMarksheetScan', 'teachers/edu');
        $data['mastersCertificateScan'] = $uploadFile('mastersCertificateScan', 'teachers/edu');
        $data['bedCertificateScan'] = $uploadFile('bedCertificateScan', 'teachers/edu');
        $data['othersExamDocument'] = $uploadFile('othersExamDocument', 'teachers/edu');
        $data['experienceCertificateScan'] = $uploadFile('experienceCertificateScan', 'teachers/exp');

        // Generate unique application code
        $data['applicationCode'] = 'T-' . strtoupper(Str::random(8));

        $application = TeacherApplication::create($data);

        return redirect()->route('teacher-applications.show', $application->id);
    }

    public function show(TeacherApplication $application)
    {
        return view('teacher-applications.show', compact('application'));
    }

    public function download(TeacherApplication $application)
    {
        $pdf = Pdf::loadView('teacher-applications.pdf', compact('application'));
        return $pdf->download('teacher-application-' . $application->id . '.pdf');
    }
}
