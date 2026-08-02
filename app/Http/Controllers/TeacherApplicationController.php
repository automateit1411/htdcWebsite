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
            'teacherName' => 'required|string',
            'mobile' => 'required',
        ]);

        $data = $request->except(['photo', 'nidScan', 'sscMarksheetScan', 'hscMarksheetScan', 'graduationMarksheetScan', 'mastersCertificateScan', 'bedCertificateScan', 'experienceCertificateScan']);

        // Helper function for file uploads
        $uploadFile = function($fieldName, $folder) use ($request) {
            if ($request->hasFile($fieldName)) {
                $path = $request->file($fieldName)->store('public/' . $folder);
                return Storage::url($path);
            }
            return null;
        };

        $data['profileScan'] = $uploadFile('photo', 'teachers/photos');
        $data['nidScan'] = $uploadFile('nidScan', 'teachers/docs');
        $data['sscMarksheetScan'] = $uploadFile('sscMarksheetScan', 'teachers/edu');
        $data['hscMarksheetScan'] = $uploadFile('hscMarksheetScan', 'teachers/edu');
        $data['graduationMarksheetScan'] = $uploadFile('graduationMarksheetScan', 'teachers/edu');
        $data['mastersCertificateScan'] = $uploadFile('mastersCertificateScan', 'teachers/edu');
        $data['bedCertificateScan'] = $uploadFile('bedCertificateScan', 'teachers/edu');
        $data['experienceCertificateScan'] = $uploadFile('experienceCertificateScan', 'teachers/exp');

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
