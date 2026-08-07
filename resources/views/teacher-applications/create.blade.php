@extends('layouts.app')

@section('title', 'Teacher Application - Hazera-Taju Degree College')

@section('content')
<div class="mx-auto max-w-5xl" x-data="teacherMultiStepForm()">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <div class="rounded-lg shadow border border-gray-200 bg-white">
        <div class="px-4 py-2 bg-[#0d3a37] text-white font-semibold text-center flex items-center justify-center uppercase tracking-wide">
            <img src="{{ asset('icons/teacherform.svg') }}" alt="Teacher Application" class="inline-block w-8 h-8 mr-2 p-1" />
            Teacher Recruitment Application
        </div>
        
        <form id="teacher-application-form" action="{{ route('teacher-applications.store') }}" method="POST" enctype="multipart/form-data" class="p-0">
            @csrf
            
            <!-- Progress Bar -->
            <div class="px-6 pt-6">
                <div class="flex justify-between mb-2">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="text-[10px] md:text-xs font-bold uppercase" :class="currentStep >= (index + 1) ? 'text-[rgb(20,89,84)]' : 'text-gray-400'" x-text="step"></div>
                    </template>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[rgb(20,89,84)] h-full transition-all duration-500" :style="`width: ${(currentStep / steps.length) * 100}%`"></div>
                </div>
            </div>

            <div class="p-6">
                <!-- Errors -->
                <div x-show="showErrors && Object.keys(errors).length > 0" class="mb-4 rounded border border-red-300 bg-red-50 text-red-700 px-3 py-2 text-sm" x-cloak>
                    <div class="font-bold uppercase text-xs mb-1">Please correct the following:</div>
                    <ul class="list-disc list-inside">
                        <template x-for="(error, key) in errors" :key="key">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Step 1: Personal Info + Photo -->
                <div x-show="currentStep === 1" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-[rgb(20,89,84)] px-2 py-1">Step 1: Personal Information</div>
                    <div class="border border-[rgb(20,89,84)] p-6 pt-8">
                        <!-- Photo + Name Row -->
                        <div class="flex flex-col md:flex-row gap-6 mb-6">
                            <!-- Profile Photo -->
                            <div class="flex-shrink-0">
                                <label class="text-xs font-bold text-gray-600 uppercase block mb-2">Profile Photo <span class="text-red-600">*</span></label>
                                <div class="flex items-center space-x-4">
                                    <img :src="formData.photoPreview" class="w-28 h-32 object-cover border-2 border-[rgb(20,89,84)] rounded shadow-sm" />
                                    <div>
                                        <input type="file" name="photo" accept="image/*" @change="handleFileChange($event, 'photo')" class="text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37] hover:file:bg-[#0d3a37]/20" />
                                        <p class="text-[10px] text-gray-400 mt-1">JPG/PNG, Max 2MB</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Names -->
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase">Teacher Name (English) <span class="text-red-600">*</span></label>
                                    <input name="teacherName" class="mt-1 w-full border rounded px-3 py-2 text-sm" :class="errors.teacherName ? 'border-red-500' : 'border-gray-300'" x-model="formData.teacherName" />
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase">Teacher Name (Bangla)</label>
                                    <input name="teacherNameBangla" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm bn-font" x-model="formData.teacherNameBangla" />
                                </div>
                            </div>
                        </div>

                        <!-- Contact + Family Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Mobile Number <span class="text-red-600">*</span></label>
                                <input name="mobile" class="mt-1 w-full border rounded px-3 py-2 text-sm" :class="errors.mobile ? 'border-red-500' : 'border-gray-300'" x-model="formData.mobile" placeholder="01XXXXXXXXX" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Email</label>
                                <input type="email" name="email" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.email" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Father's Name</label>
                                <input name="fatherName" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.fatherName" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Mother's Name</label>
                                <input name="motherName" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.motherName" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Religion</label>
                                <select name="religion" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.religion">
                                    <option value="">Select</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Blood Group</label>
                                <select name="bloodGroup" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.bloodGroup">
                                    <option value="">Select</option>
                                    <template x-for="bg in bloodGroups" :key="bg">
                                        <option :value="bg" x-text="bg"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Date of Birth</label>
                                <input type="date" name="dob" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.dob" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">National ID (NID)</label>
                                <input type="number" name="nid" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.nid" />
                            </div>
                        </div>

                        <!-- NID Scan -->
                        <div class="mt-4 border-t pt-4">
                            <label class="text-xs font-bold text-gray-600 uppercase">NID Scan (PDF/Image)</label>
                            <input type="file" name="nidScan" accept=".pdf,image/*" @change="handleFileChange($event, 'nidScan')" class="mt-1 block w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37] hover:file:bg-[#0d3a37]/20" />
                        </div>
                    </div>
                </div>

                <!-- Step 2: Address -->
                <div x-show="currentStep === 2" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-[rgb(20,89,84)] px-2 py-1">Step 2: Address</div>
                    <div class="border border-[rgb(20,89,84)] p-6 pt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-gray-600 uppercase">Present Address</label>
                                <input name="presentAddress" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.presentAddress" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Upazila/Thana</label>
                                <input name="upazilaThana" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.upazilaThana" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">District/Post Office</label>
                                <input name="zillaPostOffice" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.zillaPostOffice" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: SSC/HSC Education -->
                <div x-show="currentStep === 3" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-[rgb(20,89,84)] px-2 py-1">Step 3: SSC / HSC Education</div>
                    <div class="space-y-6 border border-[rgb(20,89,84)] p-6 pt-8">
                        <!-- SSC -->
                        <div class="border p-4 rounded bg-gray-50 relative">
                            <div class="absolute -top-3 left-3 bg-[rgb(20,89,84)] text-white px-2 py-0.5 text-[10px] font-bold uppercase rounded">SSC / Equivalent</div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Exam Type</label>
                                    <input name="sscExamType" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-gray-100" x-model="formData.sscExamType" readonly />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Board</label>
                                    <select name="sscBoard" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscBoard">
                                        <option value="">Select</option>
                                        <template x-for="b in boards" :key="b">
                                            <option :value="b" x-text="b"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Year</label>
                                    <select name="sscYear" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscYear">
                                        <option value="">Select</option>
                                        <template x-for="y in teacherYears" :key="y">
                                            <option :value="y" x-text="y"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Result/GPA</label>
                                    <input name="sscResult" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscResult" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Registration No</label>
                                    <input name="sscRegistrationNo" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscRegistrationNo" />
                                </div>
                                <div></div>
                                <!-- SSC Document - Single upload with clear label -->
                                <div class="md:col-span-3">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Documents (PDF) <span class="text-red-500">*</span></label>
                                    <p class="text-[9px] text-gray-400 mb-1">Upload SSC Marksheet / Certificate / Tabulation Sheet (Combined PDF)</p>
                                    <input type="file" name="sscMarksheetScan" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- HSC -->
                        <div class="border p-4 rounded bg-gray-50 relative">
                            <div class="absolute -top-3 left-3 bg-[rgb(20,89,84)] text-white px-2 py-0.5 text-[10px] font-bold uppercase rounded">HSC / Equivalent</div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Exam Type</label>
                                    <input name="hscExamType" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-gray-100" x-model="formData.hscExamType" readonly />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Board</label>
                                    <select name="hsceBoard" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hsceBoard">
                                        <option value="">Select</option>
                                        <template x-for="b in boards" :key="b">
                                            <option :value="b" x-text="b"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Year</label>
                                    <select name="hscYear" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hscYear">
                                        <option value="">Select</option>
                                        <template x-for="y in teacherYears" :key="y">
                                            <option :value="y" x-text="y"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Result/GPA</label>
                                    <input name="hscResult" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hscResult" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Registration No</label>
                                    <input name="hscRegistrationNo" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hscRegistrationNo" />
                                </div>
                                <div></div>
                                <!-- HSC Document - Single upload with clear label -->
                                <div class="md:col-span-3">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Documents (PDF) <span class="text-red-500">*</span></label>
                                    <p class="text-[9px] text-gray-400 mb-1">Upload HSC Marksheet / Certificate / Tabulation Sheet (Combined PDF)</p>
                                    <input type="file" name="hscMarksheetScan" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Higher Education -->
                <div x-show="currentStep === 4" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-[rgb(20,89,84)] px-2 py-1">Step 4: Higher Education</div>
                    <div class="space-y-6 border border-[rgb(20,89,84)] p-6 pt-8 text-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <!-- Graduation -->
                            <div class="border-b pb-4">
                                <h4 class="text-[10px] font-black uppercase text-[#0d3a37]/80 mb-2">Graduation (Honours/Degree)</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="graduationExamType" x-model="formData.graduationExamType" placeholder="Exam Type" class="border p-1.5 rounded" />
                                    <input type="text" name="graduationSubject" x-model="formData.graduationSubject" placeholder="Subject" class="border p-1.5 rounded" />
                                    <input type="text" name="graduationResult" x-model="formData.graduationResult" placeholder="Result" class="border p-1.5 rounded" />
                                    <select name="graduationYear" x-model="formData.graduationYear" class="border p-1.5 rounded text-xs">
                                        <option value="">Year</option>
                                        <template x-for="y in teacherYears" :key="y"><option :value="y" x-text="y"></option></template>
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Documents (PDF) <span class="text-red-500">*</span></label>
                                    <p class="text-[9px] text-gray-400 mb-1">Upload Marksheet / Certificate / Tabulation Sheet (Combined PDF)</p>
                                    <input type="file" name="graduationMarksheetScan" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                            <!-- Masters -->
                            <div class="border-b pb-4">
                                <h4 class="text-[10px] font-black uppercase text-[#0d3a37]/80 mb-2">Masters</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="mastersExamType" x-model="formData.mastersExamType" placeholder="Exam Type" class="border p-1.5 rounded" />
                                    <input type="text" name="mastersResult" x-model="formData.mastersResult" placeholder="Result" class="border p-1.5 rounded" />
                                    <select name="mastersYear" x-model="formData.mastersYear" class="border p-1.5 rounded text-xs">
                                        <option value="">Year</option>
                                        <template x-for="y in teacherYears" :key="y"><option :value="y" x-text="y"></option></template>
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Documents (PDF)</label>
                                    <p class="text-[9px] text-gray-400 mb-1">Upload Marksheet / Certificate / Tabulation Sheet (Combined PDF)</p>
                                    <input type="file" name="mastersCertificateScan" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                            <!-- Professional -->
                            <div class="border-b pb-4">
                                <h4 class="text-[10px] font-black uppercase text-[#0d3a37]/80 mb-2">Professional (B.Ed/M.Ed)</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="bedResult" x-model="formData.bedResult" placeholder="B.Ed Result" class="border p-1.5 rounded" />
                                    <input type="text" name="medResult" x-model="formData.medResult" placeholder="M.Ed Result" class="border p-1.5 rounded" />
                                </div>
                                <div class="mt-2">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Documents (PDF)</label>
                                    <p class="text-[9px] text-gray-400 mb-1">Upload B.Ed / M.Ed Certificate (Combined PDF)</p>
                                    <input type="file" name="bedCertificateScan" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                            <!-- Others -->
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-[#0d3a37]/80 mb-2">Other Qualification</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="othersExam" x-model="formData.othersExam" placeholder="Exam Name" class="border p-1.5 rounded" />
                                    <input type="text" name="othersExamResult" x-model="formData.othersExamResult" placeholder="Result" class="border p-1.5 rounded" />
                                </div>
                                <div class="mt-2">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Documents (PDF)</label>
                                    <p class="text-[9px] text-gray-400 mb-1">Upload Certificate / Document (Combined PDF)</p>
                                    <input type="file" name="othersExamDocument" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Experience -->
                <div x-show="currentStep === 5" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-[rgb(20,89,84)] px-2 py-1">Step 5: Experience</div>
                    <div class="space-y-6 border border-[rgb(20,89,84)] p-6 pt-8 text-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Institution Type</label>
                                <select name="institutionType" class="mt-1 w-full border border-gray-300 rounded px-3 py-2" x-model="formData.institutionType">
                                    <option value="">Select</option>
                                    <option value="School">School</option>
                                    <option value="College">College</option>
                                    <option value="Madrasah">Madrasah</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">Subject (Recruitment)</label>
                                <input name="subject" class="mt-1 w-full border border-gray-300 rounded px-3 py-2" x-model="formData.subject" />
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">SSC Subject Teacher?</label>
                                <select name="sscSubjectTeacher" class="mt-1 w-full border border-gray-300 rounded px-3 py-2" x-model="formData.sscSubjectTeacher">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase text-gray-500">HSC Subject Teacher?</label>
                                <select name="hscSubjectTeacher" class="mt-1 w-full border border-gray-300 rounded px-3 py-2" x-model="formData.hscSubjectTeacher">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 border-t pt-4">
                                <label class="text-[10px] font-black uppercase text-[#0d3a37]/80">Previous Institution Details</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <input type="text" name="previousInstitution" x-model="formData.previousInstitution" placeholder="Previous Institution Name" class="border border-gray-300 p-2 rounded" />
                                    <input type="text" name="previousDesignation" x-model="formData.previousDesignation" placeholder="Designation" class="border border-gray-300 p-2 rounded" />
                                    <div>
                                        <label class="text-[8px] uppercase font-bold text-gray-400">Join Date</label>
                                        <input type="date" name="previousJoinDate" x-model="formData.previousJoinDate" class="w-full border border-gray-300 p-1.5 rounded text-xs" />
                                    </div>
                                    <div>
                                        <label class="text-[8px] uppercase font-bold text-gray-400">Relieve Date</label>
                                        <input type="date" name="previousRelieveDate" x-model="formData.previousRelieveDate" class="w-full border border-gray-300 p-1.5 rounded text-xs" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Experience Certificate (PDF)</label>
                                    <input type="file" name="experienceCertificateScan" accept=".pdf" class="mt-1 block w-full text-[10px] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-[#0d3a37]/10 file:text-[#0d3a37]" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 6: Preview & Download -->
                <div x-show="currentStep === 6" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-[rgb(20,89,84)] px-2 py-1">Step 6: Final Preview</div>
                    <div class="border border-[rgb(20,89,84)] p-6 pt-8 overflow-x-auto">
                        <div id="preview-content" class="bg-white p-6 min-w-[750px] mx-auto border shadow-sm">
                            
                            <!-- Header -->
                            <div class="flex items-center justify-between border-b-2 border-[#0d3a37] pb-4 mb-4 bg-[#0d3a37]/5 p-4 rounded">
                                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-20 h-24" />
                                <div class="text-center flex-1">
                                    <h1 class="text-2xl font-bold text-[#0d3a37] uppercase tracking-wide">Hazera-Taju Degree College</h1>
                                    <p class="text-sm text-[#0d3a37]/80 font-medium">B.Sc Chattar, Chandgaon, Chattogram</p>
                                    <div class="mt-2 inline-block bg-[#0d3a37] text-white px-6 py-1 rounded text-sm font-bold uppercase tracking-widest">Teacher Recruitment Application</div>
                                </div>
                                <img :src="formData.photoPreview" class="w-24 h-28 object-cover border-2 border-[#0d3a37] shadow-lg rounded" />
                            </div>

                            <!-- Personal Information -->
                            <table class="min-w-full border border-gray-300 text-[11px] mb-4">
                                <thead>
                                    <tr class="bg-[#0d3a37] text-white">
                                        <th colspan="3" class="px-3 py-1.5 text-center font-bold uppercase tracking-widest text-[10px]">Personal Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 w-1/4 uppercase text-gray-600 font-bold">Name (English)</th>
                                        <td class="px-3 py-1.5 font-bold" x-text="formData.teacherName"></td>
                                        <td rowspan="7" class="w-28 border-l p-2 align-top text-center">
                                            <img :src="formData.photoPreview" class="w-20 h-24 object-cover border mx-auto rounded" />
                                            <p class="text-[8px] text-gray-400 mt-1 italic">Photo</p>
                                        </td>
                                    </tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Name (Bangla)</th><td class="px-3 py-1.5 bn-font" x-text="formData.teacherNameBangla"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Mobile</th><td class="px-3 py-1.5 font-bold" x-text="formData.mobile"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Email</th><td class="px-3 py-1.5" x-text="formData.email"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Father's Name</th><td class="px-3 py-1.5" x-text="formData.fatherName"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Mother's Name</th><td class="px-3 py-1.5" x-text="formData.motherName"></td></tr>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Religion / Blood / DOB</th>
                                        <td class="px-3 py-1.5">
                                            <span x-text="formData.religion"></span> / 
                                            <span x-text="formData.bloodGroup"></span> / 
                                            <span x-text="formData.dob"></span>
                                        </td>
                                    </tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">National ID (NID)</th><td class="px-3 py-1.5" x-text="formData.nid"></td><td class="border-l"></td></tr>
                                </tbody>
                            </table>

                            <!-- Address -->
                            <table class="min-w-full border border-gray-300 text-[11px] mb-4">
                                <thead>
                                    <tr class="bg-[#0d3a37] text-white">
                                        <th colspan="3" class="px-3 py-1.5 text-center font-bold uppercase tracking-widest text-[10px]">Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 w-1/4 uppercase text-gray-600 font-bold">Present Address</th>
                                        <td class="px-3 py-1.5" x-text="formData.presentAddress"></td>
                                        <td class="border-l w-28"></td>
                                    </tr>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Upazila/Thana & District</th>
                                        <td class="px-3 py-1.5"><span x-text="formData.upazilaThana"></span>, <span x-text="formData.zillaPostOffice"></span></td>
                                        <td class="border-l"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Education - SSC/HSC -->
                            <table class="min-w-full border border-gray-300 text-[11px] mb-4">
                                <thead>
                                    <tr class="bg-[#0d3a37] text-white">
                                        <th colspan="6" class="px-3 py-1.5 text-center font-bold uppercase tracking-widest text-[10px]">Education (SSC / HSC)</th>
                                    </tr>
                                    <tr class="bg-gray-100 text-[9px] uppercase font-bold text-gray-600">
                                        <th class="px-2 py-1 border text-left">Exam</th>
                                        <th class="px-2 py-1 border text-left">Board</th>
                                        <th class="px-2 py-1 border text-left">Year</th>
                                        <th class="px-2 py-1 border text-left">Result</th>
                                        <th class="px-2 py-1 border text-left" colspan="2">Registration No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t">
                                        <td class="px-2 py-1 border font-bold">SSC</td>
                                        <td class="px-2 py-1 border" x-text="formData.sscBoard"></td>
                                        <td class="px-2 py-1 border" x-text="formData.sscYear"></td>
                                        <td class="px-2 py-1 border" x-text="formData.sscResult"></td>
                                        <td class="px-2 py-1 border" colspan="2" x-text="formData.sscRegistrationNo"></td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="px-2 py-1 border font-bold">HSC</td>
                                        <td class="px-2 py-1 border" x-text="formData.hsceBoard"></td>
                                        <td class="px-2 py-1 border" x-text="formData.hscYear"></td>
                                        <td class="px-2 py-1 border" x-text="formData.hscResult"></td>
                                        <td class="px-2 py-1 border" colspan="2" x-text="formData.hscRegistrationNo"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Higher Education -->
                            <table class="min-w-full border border-gray-300 text-[11px] mb-4">
                                <thead>
                                    <tr class="bg-[#0d3a37] text-white">
                                        <th colspan="5" class="px-3 py-1.5 text-center font-bold uppercase tracking-widest text-[10px]">Higher Education</th>
                                    </tr>
                                    <tr class="bg-gray-100 text-[9px] uppercase font-bold text-gray-600">
                                        <th class="px-2 py-1 border text-left">Level</th>
                                        <th class="px-2 py-1 border text-left">Exam Type / Subject</th>
                                        <th class="px-2 py-1 border text-left">Result</th>
                                        <th class="px-2 py-1 border text-left">Year</th>
                                        <th class="px-2 py-1 border text-left">Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t">
                                        <td class="px-2 py-1 border font-bold">Graduation</td>
                                        <td class="px-2 py-1 border"><span x-text="formData.graduationExamType"></span> - <span x-text="formData.graduationSubject"></span></td>
                                        <td class="px-2 py-1 border" x-text="formData.graduationResult"></td>
                                        <td class="px-2 py-1 border" x-text="formData.graduationYear"></td>
                                        <td class="px-2 py-1 border text-[#0d3a37]">PDF Attached</td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="px-2 py-1 border font-bold">Masters</td>
                                        <td class="px-2 py-1 border" x-text="formData.mastersExamType"></td>
                                        <td class="px-2 py-1 border" x-text="formData.mastersResult"></td>
                                        <td class="px-2 py-1 border" x-text="formData.mastersYear"></td>
                                        <td class="px-2 py-1 border text-[#0d3a37]">PDF Attached</td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="px-2 py-1 border font-bold">B.Ed / M.Ed</td>
                                        <td class="px-2 py-1 border">Professional Degree</td>
                                        <td class="px-2 py-1 border"><span x-text="formData.bedResult"></span> / <span x-text="formData.medResult"></span></td>
                                        <td class="px-2 py-1 border">-</td>
                                        <td class="px-2 py-1 border text-[#0d3a37]">PDF Attached</td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="px-2 py-1 border font-bold">Others</td>
                                        <td class="px-2 py-1 border" x-text="formData.othersExam"></td>
                                        <td class="px-2 py-1 border" x-text="formData.othersExamResult"></td>
                                        <td class="px-2 py-1 border">-</td>
                                        <td class="px-2 py-1 border text-[#0d3a37]">PDF Attached</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Experience -->
                            <table class="min-w-full border border-gray-300 text-[11px] mb-4">
                                <thead>
                                    <tr class="bg-[#0d3a37] text-white">
                                        <th colspan="4" class="px-3 py-1.5 text-center font-bold uppercase tracking-widest text-[10px]">Experience & Recruitment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 w-1/4 uppercase text-gray-600 font-bold">Institution Type</th>
                                        <td class="px-3 py-1.5" x-text="formData.institutionType"></td>
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Recruitment Subject</th>
                                        <td class="px-3 py-1.5 font-bold text-[#0d3a37]" x-text="formData.subject"></td>
                                    </tr>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">SSC Subject Teacher</th>
                                        <td class="px-3 py-1.5" x-text="formData.sscSubjectTeacher"></td>
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">HSC Subject Teacher</th>
                                        <td class="px-3 py-1.5" x-text="formData.hscSubjectTeacher"></td>
                                    </tr>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Previous Institution</th>
                                        <td class="px-3 py-1.5" x-text="formData.previousInstitution"></td>
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Designation</th>
                                        <td class="px-3 py-1.5" x-text="formData.previousDesignation"></td>
                                    </tr>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Join Date</th>
                                        <td class="px-3 py-1.5" x-text="formData.previousJoinDate"></td>
                                        <th class="text-left px-3 py-1.5 bg-gray-100 uppercase text-gray-600 font-bold">Relieve Date</th>
                                        <td class="px-3 py-1.5" x-text="formData.previousRelieveDate || 'N/A (Current)'"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Declaration -->
                            <div class="border border-gray-300 p-4 mb-4 bg-gray-50 rounded">
                                <h4 class="text-[10px] font-bold uppercase text-[#0d3a37] mb-2">Declaration</h4>
                                <p class="text-[10px] text-gray-600 leading-relaxed">
                                    I hereby declare that all the information provided above is true and correct to the best of my knowledge. 
                                    I understand that any false information may lead to disqualification of my application.
                                </p>
                            </div>

                            <!-- Signatures -->
                            <div class="mt-12 flex justify-between px-10 pb-4">
                                <div class="text-center">
                                    <div class="w-36 border-t-2 border-gray-800 mb-1"></div>
                                    <p class="text-[9px] font-bold uppercase text-gray-600">Applicant's Signature</p>
                                    <p class="text-[8px] text-gray-400" x-text="formData.teacherName"></p>
                                </div>
                                <div class="text-center">
                                    <div class="w-36 border-t-2 border-gray-800 mb-1"></div>
                                    <p class="text-[9px] font-bold uppercase text-gray-600">Principal's Signature</p>
                                    <p class="text-[8px] text-gray-400">Hazera-Taju Degree College</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="mt-4 pt-2 border-t border-gray-200 text-center">
                                <p class="text-[8px] text-gray-400">Generated by Hazera-Taju Degree College Online Application System</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                            <button type="button" class="px-8 py-3 bg-white border-2 border-[#0d3a37] text-[#0d3a37] rounded-lg shadow hover:bg-[#0d3a37] hover:text-white flex items-center justify-center gap-2 font-bold text-sm transition" @click="window.print()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                PRINT
                            </button>
                            <button type="button" class="px-8 py-3 bg-[#0d3a37] text-white rounded-lg shadow-lg hover:bg-[rgb(20,89,84)] flex items-center justify-center gap-2 font-bold text-sm transform transition hover:scale-105" @click="downloadPdf()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                DOWNLOAD PDF
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Navigation Buttons -->
            <div class="px-6 py-4 flex gap-2 justify-between border-t border-gray-200 bg-gray-50 rounded-b-lg no-print">
                <div>
                    <button type="button" x-show="currentStep > 1" class="px-6 py-2 rounded border border-gray-300 text-[#0d3a37] bg-white hover:bg-[#0d3a37] hover:text-white font-bold text-xs uppercase" @click="prevStep()">Previous</button>
                </div>
                <div class="ml-auto flex gap-2">
                    <button type="button" x-show="currentStep < steps.length" class="px-10 py-2 rounded bg-indigo-600 text-white shadow-md hover:bg-indigo-700 font-bold text-xs uppercase transition transform hover:scale-105" @click="nextStep()">Next Step</button>
                    <button type="submit" x-show="currentStep === steps.length" class="px-10 py-2 rounded bg-[#0d3a37] text-white shadow-md hover:bg-[rgb(20,89,84)] font-bold text-xs uppercase transition transform hover:scale-105" :disabled="submitting" x-text="submitting ? 'Submitting...' : 'Confirm & Final Submit'"></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function teacherMultiStepForm() {
    return {
        currentStep: 1,
        showErrors: false,
        errors: {},
        submitting: false,
        formData: {
            teacherName: '', teacherNameBangla: '', mobile: '', email: '',
            fatherName: '', motherName: '', religion: '', bloodGroup: '', dob: '', nid: '',
            presentAddress: '', upazilaThana: '', zillaPostOffice: '',
            photoPreview: 'https://placehold.co/150x150',
            // SSC - auto-filled exam type
            sscExamType: 'SSC', sscBoard: '', sscYear: '', sscResult: '', sscRegistrationNo: '',
            // HSC - auto-filled exam type
            hscExamType: 'HSC', hsceBoard: '', hscYear: '', hscResult: '', hscRegistrationNo: '',
            // Higher Education
            graduationExamType: '', graduationSubject: '', graduationResult: '', graduationYear: '',
            mastersExamType: '', mastersResult: '', mastersYear: '',
            bedResult: '', medResult: '', othersExam: '', othersExamResult: '',
            // Experience
            institutionType: '', subject: '', department: '', program: '',
            sscSubjectTeacher: '', hscSubjectTeacher: '',
            previousInstitution: '', previousDesignation: '', previousJoinDate: '', previousRelieveDate: ''
        },
        steps: ['Personal', 'Address', 'SSC/HSC', 'Higher Ed', 'Experience', 'Preview'],
        bloodGroups: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
        boards: ['Barishal','Chittagong','Comilla','Dhaka','Jessore','Mymensingh','Rajshahi','Sylhet','Dinajpur','Madrasah','BOU','Technical'],
        teacherYears: Array.from({length: 45}, (_, i) => String(1980 + i)),
        
        handleFileChange(e, field) {
            const f = e.target.files[0];
            if (!f) return;
            const reader = new FileReader();
            reader.onload = () => {
                if (field === 'photo') this.formData.photoPreview = reader.result;
            };
            reader.readAsDataURL(f);
        },
        validateCurrentStep() {
            this.errors = {};
            if (this.currentStep === 1) {
                if (!this.formData.teacherName) this.errors.teacherName = 'Name is required';
                if (!this.formData.mobile) this.errors.mobile = 'Mobile number is required';
            }
            return Object.keys(this.errors).length === 0;
        },
        nextStep() {
            if (this.validateCurrentStep()) {
                this.currentStep++;
                this.showErrors = false;
                window.scrollTo({top: 0, behavior: 'smooth'});
            } else {
                this.showErrors = true;
                window.scrollTo({top: 0, behavior: 'smooth'});
            }
        },
        prevStep() {
            this.currentStep--;
            this.showErrors = false;
            window.scrollTo({top: 0, behavior: 'smooth'});
        },
        async downloadPdf() {
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
                pdf.save(`Teacher_Application_${this.formData.teacherName.replace(/\s+/g, '_')}.pdf`);
            });
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
@media print { 
    .no-print { display: none !important; }
    body { font-size: 10px; }
    #preview-content { border: none !important; box-shadow: none !important; padding: 0 !important; }
    table { page-break-inside: avoid; }
}
</style>
@endsection
