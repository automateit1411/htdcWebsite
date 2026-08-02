<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application_{{ $application->sNameEnglish }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #1f2937; line-height: 1.5; background-color: #fff; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        
        /* Header Section */
        .header-section { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #065f46; padding-bottom: 15px; margin-bottom: 20px; background-color: #f0fdf4; padding: 15px; }
        .logo { width: 80px; height: 90px; }
        .college-info { text-align: center; flex: 1; padding: 0 20px; }
        .college-name { font-size: 18px; font-weight: bold; color: #065f46; text-transform: uppercase; margin-bottom: 5px; }
        .college-address { font-size: 10px; color: #047857; margin-bottom: 8px; }
        .form-title { font-size: 14px; font-weight: bold; margin-bottom: 5px; color: #1f2937; }
        .session-text { font-size: 12px; font-weight: bold; color: #15803d; margin-bottom: 5px; }
        .pin-box { background: #fff; border: 1px solid #065f46; padding: 3px 10px; display: inline-block; font-family: 'Courier New', monospace; font-weight: bold; font-size: 11px; }
        .student-photo { width: 85px; height: 105px; border: 2px solid #065f46; object-fit: cover; }
        
        /* Program & Group Boxes */
        .info-boxes { display: flex; gap: 15px; margin-bottom: 15px; }
        .info-box { flex: 1; border: 1px solid #d1d5db; padding: 10px; background-color: #f9fafb; }
        .box-label { font-size: 9px; color: #6b7280; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 5px; }
        .box-value { font-size: 12px; font-weight: bold; color: #1f2937; }
        
        /* PIN, Date, Roll Section */
        .meta-bar { background-color: #f3f4f6; padding: 8px; margin-bottom: 15px; border: 1px solid #d1d5db; font-weight: bold; font-size: 10px; }
        .meta-table { width: 100%; border: none; }
        .meta-table td { width: 33%; }
        .meta-value { border: 1px solid #9ca3af; padding: 3px 8px; background: #fff; display: inline-block; min-width: 100px; }
        
        /* Section Titles */
        .section-title { background-color: #15803d; color: #fff; padding: 5px 10px; font-weight: bold; font-size: 11px; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px; }
        
        /* Data Grid */
        .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; border: 1px solid #e5e7eb; padding: 10px; margin-bottom: 15px; }
        .data-row { display: flex; justify-content: space-between; border-bottom: 1px solid #f3f4f6; padding-bottom: 4px; font-size: 10px; }
        .data-row:last-child { border-bottom: none; }
        .label { color: #4b5563; font-weight: normal; }
        .value { font-weight: bold; color: #1f2937; }
        .full-width { grid-column: 1 / -1; }
        
        /* Address Section */
        .address-grid { display: grid; grid-template-columns: 1fr; gap: 8px; border: 1px solid #e5e7eb; padding: 10px; margin-bottom: 15px; }
        .address-row { display: flex; gap: 10px; border-bottom: 1px solid #f3f4f6; padding-bottom: 6px; font-size: 10px; }
        .address-row:last-child { border-bottom: none; }
        .address-label { font-weight: bold; color: #4b5563; min-width: 80px; }
        .address-text { font-weight: bold; color: #1f2937; flex: 1; }
        
        /* Educational Info */
        .edu-box { border: 1px solid #d1d5db; padding: 10px; background-color: #f9fafb; font-size: 10px; margin-bottom: 10px; }
        .edu-line { margin-bottom: 5px; }
        .edu-line:last-child { margin-bottom: 0; }
        
        /* Subject Info */
        .subject-box { border: 1px solid #e5e7eb; padding: 10px; background-color: #fff; font-size: 10px; }
        
        /* Signature Section */
        .signature-section { margin-top: 40px; display: flex; justify-content: space-between; padding: 0 10px; }
        .signature-line { border-top: 1px solid #000; width: 140px; text-align: center; padding-top: 5px; font-size: 10px; font-weight: bold; }
        
        /* Footer */
        .footer { position: fixed; bottom: 15px; left: 0; right: 0; text-align: center; font-size: 9px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <img src="{{ public_path('images/logo.svg') }}" class="logo" alt="Logo">
            <div class="college-info">
                <h1 class="college-name">Hazera-Taju Degree College</h1>
                <p class="college-address">B Sc chattar, Chandgaon, Chattogram</p>
                <p class="form-title">Application Form for Admission</p>
                <p class="session-text">Session: {{ $application->session }}</p>
                <div class="pin-box">PIN: {{ $application->pinCode }}</div>
            </div>
            @if($application->sPicture)
                <img src="{{ public_path(parse_url($application->sPicture, PHP_URL_PATH)) }}" class="student-photo" alt="Student Photo">
            @else
                <div class="student-photo" style="background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 9px; color: #9ca3af; text-align: center;">No Photo</div>
            @endif
        </div>

        <!-- Program & Group -->
        <div class="info-boxes">
            <div class="info-box">
                <span class="box-label">Program</span>
                <span class="box-value">{{ $application->program }}</span>
            </div>
            <div class="info-box">
                <span class="box-label">Group</span>
                <span class="box-value">{{ $application->group }}</span>
            </div>
        </div>

        <!-- Meta Bar -->
        <div class="meta-bar">
            <table class="meta-table">
                <tr>
                    <td>PIN CODE: <span class="meta-value">{{ $application->pinCode }}</span></td>
                    <td style="text-align: center;">Admission Date: <span class="meta-value">{{ $application->created_at->format('d/m/Y') }}</span></td>
                    <td style="text-align: right;">Class Roll: <span class="meta-value">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                </tr>
            </table>
        </div>

        <!-- Student Information -->
        <div class="section-title">1. Student's Information</div>
        <div class="data-grid">
            <div class="data-row"><span class="label">Name (English):</span><span class="value">{{ $application->sNameEnglish }}</span></div>
            <div class="data-row"><span class="label">Name (Bangla):</span><span class="value">{{ $application->sNameBangla }}</span></div>
            <div class="data-row"><span class="label">Gender:</span><span class="value">{{ $application->gender }}</span></div>
            <div class="data-row"><span class="label">Religion:</span><span class="value">{{ $application->religion }}</span></div>
            <div class="data-row"><span class="label">Date of Birth:</span><span class="value">{{ $application->dob ? \Carbon\Carbon::parse($application->dob)->format('d M Y') : '' }}</span></div>
            <div class="data-row"><span class="label">Mobile Number:</span><span class="value">{{ $application->sMobileNo }}</span></div>
            <div class="data-row"><span class="label">National ID (NID):</span><span class="value">{{ $application->nid }}</span></div>
            <div class="data-row"><span class="label">Birth Registration:</span><span class="value">{{ $application->bitId }}</span></div>
        </div>

        <!-- Parents Information -->
        <div class="section-title">2. Parents Information</div>
        <div class="data-grid">
            <div class="data-row full-width"><span class="label">Father's Name:</span><span class="value">{{ strtoupper($application->fName) }}</span></div>
            <div class="data-row"><span class="label">Father's NID:</span><span class="value">{{ $application->fNid }}</span></div>
            <div class="data-row"><span class="label">Father's Mobile:</span><span class="value">{{ $application->fMobileNo }}</span></div>
            <div class="data-row full-width"><span class="label">Mother's Name:</span><span class="value">{{ strtoupper($application->mName) }}</span></div>
            <div class="data-row"><span class="label">Mother's NID:</span><span class="value">{{ $application->mNid }}</span></div>
            <div class="data-row"><span class="label">Mother's Mobile:</span><span class="value">{{ $application->mMobileNo }}</span></div>
        </div>

        <!-- Address Information -->
        <div class="section-title">3. Address Information</div>
        <div class="address-grid">
            <div class="address-row">
                <span class="address-label">Present:</span>
                <span class="address-text">{{ $application->presentAddressVil }}, {{ $application->presentAddressPO }}, {{ $application->presentAddressPS }}, {{ $application->presentAddressDist }}</span>
            </div>
            <div class="address-row">
                <span class="address-label">Permanent:</span>
                <span class="address-text">{{ $application->permanentAddressVil }}, {{ $application->permanentAddressPO }}, {{ $application->permanentAddressPS }}, {{ $application->permanentAddressDist }}</span>
            </div>
        </div>

        <!-- Guardian Information -->
        <div class="section-title">4. Guardian's Information</div>
        <div class="data-grid">
            <div class="data-row"><span class="label">Name:</span><span class="value">{{ strtoupper($application->gName) }}</span></div>
            <div class="data-row"><span class="label">Relation:</span><span class="value">{{ $application->gRelation }}</span></div>
            <div class="data-row"><span class="label">Mobile:</span><span class="value">{{ $application->gMobileNo }}</span></div>
            <div class="data-row"><span class="label">NID:</span><span class="value">{{ $application->gNid }}</span></div>
        </div>

        <!-- Educational Information -->
        <div class="section-title">5. Educational Information</div>
        <div class="edu-box">
            <div class="edu-line">
                <strong>Exam name:</strong> SSC 
                <strong>Roll No:</strong> {{ $application->rollNo1 }} 
                <strong>Reg. No:</strong> {{ $application->regNo1 }} 
                <strong>Session:</strong> {{ $application->sessionExam1 }} 
                <strong>GPA:</strong> {{ $application->gpa1 }} 
                <strong>Passing Year:</strong> {{ $application->passingYear1 }} 
                <strong>Board:</strong> {{ $application->Board1 }}
            </div>
            @if($application->program !== 'HSC')
            <div class="edu-line">
                <strong>Exam name:</strong> HSC 
                <strong>Roll No:</strong> {{ $application->rollNo2 }} 
                <strong>Reg. No:</strong> {{ $application->regNo2 }} 
                <strong>Session:</strong> {{ $application->sessionExam2 }} 
                <strong>GPA:</strong> {{ $application->gpa2 }} 
                <strong>Passing Year:</strong> {{ $application->passingYear2 }} 
                <strong>Board:</strong> {{ $application->Board2 }}
            </div>
            @endif
        </div>

        <!-- Subject Information (for HSC only) -->
        @if($application->program === 'HSC')
        <div class="section-title">6. Subject Information</div>
        <div class="subject-box">
            <strong>Compulsory:</strong> (1) {{ $application->compulsory1 }}, (2) {{ $application->compulsory2 }}, (3) {{ $application->compulsory3 }}<br>
            <strong>Elective:</strong> (1) {{ $application->elective1 }}, (2) {{ $application->elective2 }}, (3) {{ $application->elective3 }}<br>
            <strong>Optional:</strong> {{ $application->optional }}
        </div>
        @endif

        <!-- Reference Information (if provided) -->
        @if($application->refName)
        <div class="section-title">7. Reference's Information</div>
        <div class="data-grid">
            <div class="data-row"><span class="label">Name:</span><span class="value">{{ strtoupper($application->refName) }}</span></div>
            <div class="data-row"><span class="label">Relation:</span><span class="value">{{ $application->refRelation }}</span></div>
            <div class="data-row"><span class="label">Mobile:</span><span class="value">{{ $application->refMobileNo }}</span></div>
            <div class="data-row"><span class="label">NID:</span><span class="value">{{ $application->refNid }}</span></div>
        </div>
        @endif

        <!-- Signatures -->
        <div class="signature-section">
            <div class="signature-line">Guardian's Signature</div>
            <div class="signature-line">Applicant's Signature</div>
            <div class="signature-line">Principal's Signature</div>
        </div>

        <div class="footer">
            Generated on {{ date('d M Y H:i:s') }} | This is a computer generated application form.
        </div>
    </div>
</body>
</html>
