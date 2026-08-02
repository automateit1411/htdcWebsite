@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center w-full overflow-x-auto bg-gray-50 min-h-screen py-8">
    <!-- PDF Download Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <div class="mb-4 flex gap-4 no-print">
        <button 
            class="px-6 py-2 bg-green-700 text-white rounded font-medium shadow hover:bg-green-800 transition-colors"
            onclick="downloadPdf()"
        >
            Download PDF
        </button>
        <a 
            href="/"
            class="px-6 py-2 bg-gray-600 text-white rounded font-medium shadow hover:bg-gray-700 transition-colors"
        >
            Back to Home
        </a>
    </div>

    <div id="preview-content" class="bg-white shadow-lg min-w-[750px] w-[750px] p-8 relative mx-auto text-black border">
        <div class="text-center border-b-2 border-green-800 pb-4 mb-4">
            <h1 class="text-2xl font-bold uppercase text-green-900">Hazera-Taju Degree College</h1>
            <p class="text-sm font-bold text-green-800">Teacher Recruitment Application</p>
            <p class="text-xs text-gray-600">Chandgaon, Chattogram</p>
            <div class="mt-2 inline-block bg-white px-3 py-1 rounded border border-green-800 text-xs font-mono font-bold">
                CODE: {{ $application->applicationCode }}
            </div>
        </div>

        <table class="min-w-full border border-gray-200 text-sm">
            <tbody>
                <tr class="border-t">
                    <th class="text-left px-3 py-2 bg-gray-50 w-1/3">Name (English)</th>
                    <td class="px-3 py-2 font-bold">{{ $application->teacherName }}</td>
                    <td rowspan="6" class="w-32 border-l p-1 align-top text-center">
                        @if($application->profileScan)
                            <img src="{{ $application->profileScan }}" class="w-28 h-32 object-cover mx-auto border" />
                        @else
                            <div class="w-28 h-32 bg-gray-100 flex items-center justify-center text-xs text-gray-400 mx-auto border">No Photo</div>
                        @endif
                    </td>
                </tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Name (Bangla)</th><td class="px-3 py-2">{{ $application->teacherNameBangla }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Designation</th><td class="px-3 py-2">{{ $application->designation }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Appointment Type</th><td class="px-3 py-2">{{ $application->appointmentType }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Mobile Number</th><td class="px-3 py-2">{{ $application->mobile }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Email Address</th><td class="px-3 py-2">{{ $application->email }}</td></tr>
                
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Father's Name</th><td colspan="2" class="px-3 py-2">{{ $application->fatherName }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Mother's Name</th><td colspan="2" class="px-3 py-2">{{ $application->motherName }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Address</th><td colspan="2" class="px-3 py-2">{{ $application->presentAddress }}, {{ $application->upazilaThana }}, {{ $application->zillaPostOffice }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">NID Number</th><td colspan="2" class="px-3 py-2">{{ $application->nid }}</td></tr>
                
                <tr class="border-t bg-green-50"><th colspan="3" class="px-3 py-2 text-center font-bold text-green-900 uppercase tracking-wider text-xs">Academic & Professional Info</th></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">SSC Board / Year</th><td colspan="2" class="px-3 py-2">{{ $application->sscBoard }} / {{ $application->sscYear }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">SSC Result</th><td colspan="2" class="px-3 py-2">{{ $application->sscResult }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Graduation Subject</th><td colspan="2" class="px-3 py-2">{{ $application->graduationSubject }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Graduation Result</th><td colspan="2" class="px-3 py-2">{{ $application->graduationResult }}</td></tr>
                <tr class="border-t"><th class="text-left px-3 py-2 bg-gray-50">Recruitment Subject</th><td colspan="2" class="px-3 py-2 font-bold text-green-800">{{ $application->subject }}</td></tr>
            </tbody>
        </table>

        <div class="mt-16 flex justify-between px-4 pb-8">
            <div class="text-center">
                <div class="w-40 border-t border-black mx-auto mb-1"></div>
                <p class="text-xs font-bold uppercase">Applicant's Signature</p>
                <p class="text-[10px] text-gray-500">Date: {{ $application->created_at->format('d M Y') }}</p>
            </div>
            <div class="text-center">
                <div class="w-40 border-t border-black mx-auto mb-1"></div>
                <p class="text-xs font-bold uppercase">Principal's Signature</p>
            </div>
        </div>

        <div class="mt-8 text-center text-[10px] text-gray-400 border-t pt-2">
            This is a computer generated application form for Hazera-Taju Degree College.
        </div>
    </div>
</div>

<script>
function downloadPdf() {
    const element = document.getElementById('preview-content');
    const { jsPDF } = window.jspdf;
    
    html2canvas(element, { scale: 3, useCORS: true, logging: false }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'pt', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        
        pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, Math.min(imgHeight, pageHeight));
        pdf.save(`Teacher_Application_{{ str_replace(' ', '_', $application->teacherName) }}.pdf`);
    });
}
</script>

<style>
@media print {
    .no-print { display: none !important; }
}
</style>
@endsection
