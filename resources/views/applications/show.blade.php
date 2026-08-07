@extends('layouts.app')

@section('title', 'Application Details - Hazera-Taju Degree College')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <!-- PDF Download Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
        <div id="preview-content" class="bg-white p-4 min-w-[750px] mx-auto border shadow-sm">
            <div class="flex items-center justify-between border-b-2 border-[#0d3a37] pb-4 mb-4 bg-[#0d3a37]/5 p-4">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-20 h-24" />
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-[#0d3a37] uppercase">Hazera-Taju Degree College</h1>
                    <p class="text-sm text-[#0d3a37]/80 font-medium">B Sc chattar, Chandgaon, Chattogram</p>
                    <p class="text-lg font-bold mt-1">Application Form for Admission</p>
                    <p class="font-bold text-[#0d3a37]">Session: <span>{{ $application->session }}</span></p>
                    <div class="mt-1 inline-block bg-white px-2 py-0.5 rounded border border-[#0d3a37] text-xs font-mono font-bold">
                        PIN: {{ $application->pinCode }}
                    </div>
                </div>
                @if($application->sPicture)
                <img src="{{ $application->sPicture }}" class="w-20 h-24 object-cover border-2 border-[#0d3a37] shadow" />
                @else
                <div class="w-20 h-24 border-2 border-[#0d3a37] bg-gray-100 flex items-center justify-center text-[8px] text-center p-1">No Photo</div>
                @endif
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="border p-2 bg-gray-50"><span class="font-bold text-xs uppercase text-gray-600 block">Program</span><span class="text-sm font-semibold">{{ $application->program }}</span></div>
                <div class="border p-2 bg-gray-50"><span class="font-bold text-xs uppercase text-gray-600 block">Group</span><span class="text-sm font-semibold">{{ $application->group }}</span></div>
            </div>

            <div class="space-y-4">
                <section>
                    <h3 class="bg-[#0d3a37] text-white px-2 py-1 text-sm font-bold mb-2 uppercase tracking-wider">1. Student Information</h3>
                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm border p-3">
                        <div class="flex justify-between border-b pb-1"><span>Name (English):</span><span class="font-bold">{{ $application->sNameEnglish }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Name (Bangla):</span><span class="font-bold">{{ $application->sNameBangla }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Gender:</span><span class="font-bold">{{ $application->gender }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Religion:</span><span class="font-bold">{{ $application->religion }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>DOB:</span><span class="font-bold">{{ $application->dob ? \Carbon\Carbon::parse($application->dob)->format('d M Y') : '' }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Mobile:</span><span class="font-bold">{{ $application->sMobileNo }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>NID:</span><span class="font-bold">{{ $application->nid }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Birth Reg:</span><span class="font-bold">{{ $application->bitId }}</span></div>
                    </div>
                </section>

                <section>
                    <h3 class="bg-[#0d3a37] text-white px-2 py-1 text-sm font-bold mb-2 uppercase tracking-wider">2. Parents Information</h3>
                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm border p-3">
                        <div class="flex justify-between border-b pb-1"><span>Father's Name:</span><span class="font-bold">{{ $application->fName }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Mother's Name:</span><span class="font-bold">{{ $application->mName }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Father's Mobile:</span><span class="font-bold">{{ $application->fMobileNo }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Mother's Mobile:</span><span class="font-bold">{{ $application->mMobileNo }}</span></div>
                    </div>
                </section>

                <section>
                    <h3 class="bg-[#0d3a37] text-white px-2 py-1 text-sm font-bold mb-2 uppercase tracking-wider">3. Address Information</h3>
                    <div class="grid grid-cols-1 gap-y-2 text-sm border p-3">
                        <div class="flex items-start gap-2 border-b pb-1"><span>Present:</span><span class="font-bold">{{ $application->presentAddressVil }}, {{ $application->presentAddressPO }}, {{ $application->presentAddressPS }}, {{ $application->presentAddressDist }}</span></div>
                        <div class="flex items-start gap-2 border-b pb-1"><span>Permanent:</span><span class="font-bold">{{ $application->permanentAddressVil }}, {{ $application->permanentAddressPO }}, {{ $application->permanentAddressPS }}, {{ $application->permanentAddressDist }}</span></div>
                    </div>
                </section>

                @if($application->program === 'HSC')
                <section>
                    <h3 class="bg-[#0d3a37] text-white px-2 py-1 text-sm font-bold mb-2 uppercase tracking-wider">4. Subject Selection</h3>
                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm border p-3">
                        <div class="flex justify-between border-b pb-1"><span>Compulsory 1:</span><span class="font-bold">{{ $application->compulsory1 }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Compulsory 2:</span><span class="font-bold">{{ $application->compulsory2 }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Compulsory 3:</span><span class="font-bold">{{ $application->compulsory3 }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Elective 1:</span><span class="font-bold">{{ $application->elective1 }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Elective 2:</span><span class="font-bold">{{ $application->elective2 }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Elective 3:</span><span class="font-bold">{{ $application->elective3 }}</span></div>
                        <div class="flex justify-between border-b pb-1"><span>Optional:</span><span class="font-bold">{{ $application->optional }}</span></div>
                    </div>
                </section>
                @endif
            </div>

            <div class="mt-12 flex justify-between px-4 pb-8">
                <div class="text-center border-t border-black w-40 pt-1 text-xs font-bold">Guardian's Signature</div>
                <div class="text-center border-t border-black w-40 pt-1 text-xs font-bold">Applicant's Signature</div>
                <div class="text-center border-t border-black w-40 pt-1 text-xs font-bold">Principal's Signature</div>
            </div>
        </div>
        
        <div class="mt-8 flex justify-center gap-4 no-print" x-data="{ downloadPdf() { 
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
                pdf.save(`Application_{{ $application->sNameEnglish }}.pdf`);
            });
        }}">
            <a href="/" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-bold transition">Back to Home</a>
            <button class="px-8 py-2 bg-[#0d3a37] text-white rounded-lg shadow hover:bg-[#0d3a37] flex items-center gap-2 font-bold transition" @click="downloadPdf()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Download PDF
            </button>
        </div>
    </div>
</div>
@endsection
