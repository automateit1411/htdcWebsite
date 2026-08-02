<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teacher_Application_{{ $application->teacherName }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .container { padding: 20px; }
        .header-table { width: 100%; border-bottom: 2px solid #14532d; margin-bottom: 20px; background-color: #f0fdf4; padding: 10px; }
        .logo { width: 80px; height: 100px; }
        .college-name { font-size: 20px; font-weight: bold; color: #14532d; text-transform: uppercase; margin: 0; }
        .college-info { font-size: 10px; color: #166534; margin: 2px 0; }
        .form-title { font-size: 16px; font-weight: bold; margin-top: 5px; }
        .code-box { margin-top: 5px; background-color: #fff; border: 1px solid #14532d; padding: 2px 8px; display: inline-block; font-family: monospace; font-weight: bold; font-size: 12px; }
        
        .student-photo { width: 100px; height: 120px; border: 2px solid #14532d; }
        
        .info-section { margin-bottom: 15px; }
        .section-title { background-color: #15803d; color: #fff; padding: 4px 8px; font-weight: bold; font-size: 11px; text-transform: uppercase; margin-bottom: 5px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; border: 1px solid #ddd; }
        .data-table td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .label { color: #666; font-size: 10px; width: 30%; }
        .value { font-weight: bold; font-size: 11px; }
        
        .signature-table { width: 100%; margin-top: 50px; }
        .signature-line { border-top: 1px solid #000; width: 150px; text-align: center; padding-top: 5px; font-size: 10px; font-weight: bold; }
        
        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td style="width: 100px; text-align: center;">
                    <img src="{{ public_path('images/logo.svg') }}" class="logo">
                </td>
                <td style="text-align: center;">
                    <h1 class="college-name">Hazera-Taju Degree College</h1>
                    <p class="college-info">B Sc chattar, Chandgaon, Chattogram</p>
                    <p class="form-title">Teacher Recruitment Application</p>
                    <div class="code-box">CODE: {{ $application->applicationCode }}</div>
                </td>
                <td style="width: 110px; text-align: right;">
                    @if($application->profileScan)
                        <img src="{{ public_path(parse_url($application->profileScan, PHP_URL_PATH)) }}" class="student-photo">
                    @else
                        <div class="student-photo" style="background-color: #f3f4f6; text-align: center; line-height: 120px; font-size: 10px; color: #999;">No Photo</div>
                    @endif
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td style="width: 49%; border: 1px solid #ddd; padding: 10px; background-color: #f9fafb;">
                    <span style="font-size: 9px; color: #666; display: block; text-transform: uppercase; font-weight: bold;">Designation Applied</span>
                    <span style="font-size: 12px; font-weight: bold;">{{ $application->designation }}</span>
                </td>
                <td style="width: 2%;"></td>
                <td style="width: 49%; border: 1px solid #ddd; padding: 10px; background-color: #f9fafb;">
                    <span style="font-size: 9px; color: #666; display: block; text-transform: uppercase; font-weight: bold;">Subject</span>
                    <span style="font-size: 12px; font-weight: bold;">{{ $application->subject }}</span>
                </td>
            </tr>
        </table>

        <div class="info-section">
            <div class="section-title">1. Basic Information</div>
            <table class="data-table">
                <tr>
                    <td class="label">Name (English)</td>
                    <td class="value">{{ $application->teacherName }}</td>
                    <td class="label">Name (Bangla)</td>
                    <td class="value">{{ $application->teacherNameBangla }}</td>
                </tr>
                <tr>
                    <td class="label">Mobile Number</td>
                    <td class="value">{{ $application->mobile }}</td>
                    <td class="label">Email</td>
                    <td class="value">{{ $application->email }}</td>
                </tr>
                <tr>
                    <td class="label">Date of Birth</td>
                    <td class="value">{{ $application->dob }}</td>
                    <td class="label">NID</td>
                    <td class="value">{{ $application->nid }}</td>
                </tr>
                <tr>
                    <td class="label">Appointment Type</td>
                    <td class="value">{{ $application->appointmentType }}</td>
                    <td class="label">Index No</td>
                    <td class="value">{{ $application->indexNo }}</td>
                </tr>
            </table>
        </div>

        <div class="info-section">
            <div class="section-title">2. Education Summary</div>
            <table class="data-table">
                <tr style="background-color: #f9fafb;">
                    <td class="value" style="font-size: 10px;">Exam</td>
                    <td class="value" style="font-size: 10px;">Board/University</td>
                    <td class="value" style="font-size: 10px;">Year</td>
                    <td class="value" style="font-size: 10px;">Result</td>
                </tr>
                <tr>
                    <td class="label">SSC</td>
                    <td class="value">{{ $application->sscBoard }}</td>
                    <td class="value">{{ $application->sscYear }}</td>
                    <td class="value">{{ $application->sscResult }}</td>
                </tr>
                <tr>
                    <td class="label">HSC</td>
                    <td class="value">{{ $application->hsceBoard }}</td>
                    <td class="value">{{ $application->hscYear }}</td>
                    <td class="value">{{ $application->hscResult }}</td>
                </tr>
                @if($application->graduationSubject)
                <tr>
                    <td class="label">Graduation</td>
                    <td class="value">{{ $application->graduationSubject }}</td>
                    <td class="value">{{ $application->graduationYear }}</td>
                    <td class="value">{{ $application->graduationResult }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="info-section">
            <div class="section-title">3. Recruitment & Address</div>
            <table class="data-table">
                <tr>
                    <td class="label">Present Address</td>
                    <td class="value">{{ $application->presentAddress }}, {{ $application->upazilaThana }}, {{ $application->zillaPostOffice }}</td>
                </tr>
                <tr>
                    <td class="label">Previous Institution</td>
                    <td class="value">{{ $application->previousInstitution }}</td>
                </tr>
            </table>
        </div>

        <table class="signature-table">
            <tr>
                <td><div class="signature-line">Applicant's Signature</div></td>
                <td style="text-align: right;"><div class="signature-line" style="margin-left: auto;">Principal's Signature</div></td>
            </tr>
        </table>

        <div class="footer">
            Generated on {{ date('d M Y H:i:s') }} | This is a computer generated application form.
        </div>
    </div>
</body>
</html>
