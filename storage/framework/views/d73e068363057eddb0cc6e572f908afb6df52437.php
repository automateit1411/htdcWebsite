

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-5xl" x-data="teacherMultiStepForm()">
    <!-- PDF Download Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <div class="rounded-lg shadow border border-gray-200 bg-white">
        <div class="px-4 py-2 bg-[#14532d] text-white font-semibold text-center flex items-center justify-center uppercase tracking-wide">
            <img src="<?php echo e(asset('icons/teacherform.svg')); ?>" alt="Teacher Application" class="inline-block w-8 h-8 mr-2 p-1" />
            Teacher Recruitment Application
        </div>
        
        <form id="teacher-application-form" action="<?php echo e(route('teacher-applications.store')); ?>" method="POST" enctype="multipart/form-data" class="p-0">
            <?php echo csrf_field(); ?>
            
            <!-- Progress Bar -->
            <div class="px-6 pt-6">
                <div class="flex justify-between mb-2">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="text-[10px] md:text-xs font-bold uppercase" :class="currentStep >= (index + 1) ? 'text-green-700' : 'text-gray-400'" x-text="step"></div>
                    </template>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-green-700 h-full transition-all duration-500" :style="`width: ${(currentStep / steps.length) * 100}%`"></div>
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

                <!-- Step 1: Basic Info -->
                <div x-show="currentStep === 1" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 1: Basic Information</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">  
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Teacher Name (English) <span class="text-red-600">*</span></label>
                            <input name="teacherName" class="mt-1 w-full border rounded px-3 py-2 text-sm" :class="errors.teacherName ? 'border-red-500' : 'border-gray-300'" x-model="formData.teacherName" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Teacher Name (Bangla)</label>
                            <input name="teacherNameBangla" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.teacherNameBangla" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Designation</label>
                            <input name="designation" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.designation" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Index Number</label>
                            <input name="indexNo" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.indexNo" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">EIN</label>
                            <input name="ein" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.ein" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Mobile Number <span class="text-red-600">*</span></label>
                            <input name="mobile" class="mt-1 w-full border rounded px-3 py-2 text-sm" :class="errors.mobile ? 'border-red-500' : 'border-gray-300'" x-model="formData.mobile" placeholder="01XXXXXXXXX" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Email</label>
                            <input type="email" name="email" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.email" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Appointment Type</label>
                            <select name="appointmentType" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.appointmentType">
                                <option value="">Select</option>
                                <option value="Permanent">Permanent</option>
                                <option value="Temporary">Temporary</option>
                                <option value="Part-time">Part-time</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Personal Details -->
                <div x-show="currentStep === 2" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 2: Personal Details</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
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
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Bank Name</label>
                            <input name="bankName" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.bankName" />
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-600 uppercase">Bank Account No</label>
                            <input type="number" name="bankAccountNo" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.bankAccountNo" />
                        </div>
                    </div>
                </div>

                <!-- Step 3: Address & Photo -->
                <div x-show="currentStep === 3" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 3: Address & Photo</div>
                    <div class="border border-green-700 p-6 pt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-gray-600 uppercase">Present Address</label>
                                <input name="presentAddress" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.presentAddress" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Upazila/Thana</label>
                                <input name="upazilaThana" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.upazilaThana" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-600 uppercase">Zilla/Post Office</label>
                                <input name="zillaPostOffice" class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-sm" x-model="formData.zillaPostOffice" />
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <h3 class="text-xs font-bold uppercase text-green-800 mb-3 tracking-widest">Upload Documents</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase">Profile Photo <span class="text-red-600">*</span></label>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <img :src="formData.photoPreview" class="w-24 h-24 object-cover border-2 border-green-700 rounded shadow-sm" />
                                        <input type="file" name="photo" accept="image/*" @change="handleFileChange($event, 'photo')" class="text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                                    </div>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase">NID Scan (PDF/Image)</label>
                                    <input type="file" name="nidScan" @change="handleFileChange($event, 'nidScan')" class="mt-1 block w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Education (SSC/HSC) -->
                <div x-show="currentStep === 4" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 4: Education (SSC/HSC)</div>
                    <div class="space-y-6 border border-green-700 p-6 pt-8">
                        <!-- SSC -->
                        <div class="border p-4 rounded bg-gray-50 relative">
                            <div class="absolute -top-3 left-3 bg-green-700 text-white px-2 py-0.5 text-[10px] font-bold uppercase rounded">SSC / Equivalent</div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Exam Type</label>
                                    <input name="sscExamType" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscExamType" />
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
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Result</label>
                                    <input name="sscResult" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscResult" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Reg No</label>
                                    <input name="sscRegistrationNo" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.sscRegistrationNo" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Marksheet (PDF)</label>
                                    <input type="file" name="sscMarksheetScan" class="mt-1 block w-full text-[10px]" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- HSC -->
                        <div class="border p-4 rounded bg-gray-50 relative">
                            <div class="absolute -top-3 left-3 bg-green-700 text-white px-2 py-0.5 text-[10px] font-bold uppercase rounded">HSC / Equivalent</div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Exam Type</label>
                                    <input name="hscExamType" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hscExamType" />
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
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Result</label>
                                    <input name="hscResult" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hscResult" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Reg No</label>
                                    <input name="hscRegistrationNo" class="mt-1 w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white" x-model="formData.hscRegistrationNo" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase text-gray-500">Marksheet (PDF)</label>
                                    <input type="file" name="hscMarksheetScan" class="mt-1 block w-full text-[10px]" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Higher Education -->
                <div x-show="currentStep === 5" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 5: Higher Education</div>
                    <div class="space-y-6 border border-green-700 p-6 pt-8 text-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <!-- Graduation -->
                            <div class="border-b pb-4">
                                <h4 class="text-[10px] font-black uppercase text-green-800 mb-2">Graduation (Honours/Degree)</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="graduationExamType" x-model="formData.graduationExamType" placeholder="Exam Type" class="border p-1.5 rounded" />
                                    <input type="text" name="graduationSubject" x-model="formData.graduationSubject" placeholder="Subject" class="border p-1.5 rounded" />
                                    <input type="text" name="graduationResult" x-model="formData.graduationResult" placeholder="Result" class="border p-1.5 rounded" />
                                    <select name="graduationYear" x-model="formData.graduationYear" class="border p-1.5 rounded text-xs">
                                        <option value="">Year</option>
                                        <template x-for="y in teacherYears" :key="y"><option :value="y" x-text="y"></option></template>
                                    </select>
                                </div>
                            </div>
                            <!-- Masters -->
                            <div class="border-b pb-4">
                                <h4 class="text-[10px] font-black uppercase text-green-800 mb-2">Masters</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="mastersExamType" x-model="formData.mastersExamType" placeholder="Exam Type" class="border p-1.5 rounded" />
                                    <input type="text" name="mastersResult" x-model="formData.mastersResult" placeholder="Result" class="border p-1.5 rounded" />
                                    <select name="mastersYear" x-model="formData.mastersYear" class="border p-1.5 rounded text-xs">
                                        <option value="">Year</option>
                                        <template x-for="y in teacherYears" :key="y"><option :value="y" x-text="y"></option></template>
                                    </select>
                                </div>
                            </div>
                            <!-- Professional -->
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-green-800 mb-2">Professional (B.Ed/M.Ed)</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="bedResult" x-model="formData.bedResult" placeholder="B.Ed Result" class="border p-1.5 rounded" />
                                    <input type="text" name="medResult" x-model="formData.medResult" placeholder="M.Ed Result" class="border p-1.5 rounded" />
                                </div>
                            </div>
                            <!-- Others -->
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-green-800 mb-2">Others Qualification</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="othersExam" x-model="formData.othersExam" placeholder="Exam Name" class="border p-1.5 rounded" />
                                    <input type="text" name="othersExamResult" x-model="formData.othersExamResult" placeholder="Result" class="border p-1.5 rounded" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 6: Experience -->
                <div x-show="currentStep === 6" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 6: Experience Information</div>
                    <div class="space-y-6 border border-green-700 p-6 pt-8 text-sm">
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
                                <label class="text-[10px] font-black uppercase text-green-800">Previous Institution Details</label>
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 7: Preview & Download -->
                <div x-show="currentStep === 7" class="relative mt-3" x-cloak>
                    <div class="absolute top-[-12px] left-4 text-[10px] font-bold uppercase text-gray-100 bg-green-700 px-2 py-1">Step 7: Final Preview</div>
                    <div class="border border-green-700 p-6 pt-8 overflow-x-auto">
                        <div id="preview-content" class="bg-white p-4 min-w-[750px] mx-auto border shadow-sm">
                            <div class="flex items-center justify-between border-b-2 border-green-800 pb-4 mb-4 bg-green-50 p-4">
                                <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Logo" class="w-20 h-24" />
                                <div class="text-center">
                                    <h1 class="text-2xl font-bold text-green-900 uppercase">Hazera-Taju Degree College</h1>
                                    <p class="text-sm text-green-800 font-medium">B Sc chattar, Chandgaon, Chattogram</p>
                                    <p class="text-lg font-bold mt-1 uppercase">Teacher Recruitment Application</p>
                                </div>
                                <img :src="formData.photoPreview" class="w-20 h-24 object-cover border-2 border-green-800 shadow" />
                            </div>
                            <table class="min-w-full border border-gray-200 text-[11px]">
                                <tbody>
                                    <tr class="border-t">
                                        <th class="text-left px-3 py-1 bg-gray-50 w-1/3 uppercase text-gray-500">Name (English)</th>
                                        <td class="px-3 py-1 font-bold" x-text="formData.teacherName"></td>
                                        <td rowspan="6" class="w-28 border-l p-1 align-top text-center text-gray-400 italic">
                                            Auto Generated <br/> Document
                                        </td>
                                    </tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">Designation</th><td class="px-3 py-1" x-text="formData.designation"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">Mobile</th><td class="px-3 py-1 font-bold" x-text="formData.mobile"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">Email</th><td class="px-3 py-1" x-text="formData.email"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">Address</th><td class="px-3 py-1" x-text="formData.presentAddress"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">NID</th><td class="px-3 py-1" x-text="formData.nid"></td></tr>
                                    
                                    <tr class="border-t bg-green-50"><th colspan="3" class="px-3 py-1 text-center font-black uppercase text-green-900 tracking-widest text-[9px]">Education & Professional</th></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">SSC Board/Year</th><td colspan="2" class="px-3 py-1"><span x-text="formData.sscBoard"></span> / <span x-text="formData.sscYear"></span></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">Graduation</th><td colspan="2" class="px-3 py-1" x-text="formData.graduationSubject"></td></tr>
                                    <tr class="border-t"><th class="text-left px-3 py-1 bg-gray-50 uppercase text-gray-500">Recruitment Subject</th><td colspan="2" class="px-3 py-1 font-bold text-green-800" x-text="formData.subject"></td></tr>
                                </tbody>
                            </table>
                            <div class="mt-16 flex justify-between px-10 pb-8">
                                <div class="text-center">
                                    <div class="w-32 border-t border-black mb-1"></div>
                                    <p class="text-[9px] font-bold">Applicant's Signature</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-32 border-t border-black mb-1"></div>
                                    <p class="text-[9px] font-bold">Principal's Signature</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-center">
                            <button type="button" class="px-10 py-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 flex items-center gap-3 font-black transform transition hover:scale-105" @click="downloadPdf()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                DOWNLOAD APPLICATION (PDF)
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Navigation Buttons -->
            <div class="px-6 py-4 flex gap-2 justify-between border-t border-gray-200 bg-gray-50 rounded-b-lg no-print">
                <div>
                    <button type="button" x-show="currentStep > 1" class="px-6 py-2 rounded border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 font-bold text-xs uppercase" @click="prevStep()">Previous</button>
                </div>
                <div class="ml-auto flex gap-2">
                    <button type="button" x-show="currentStep < steps.length" class="px-10 py-2 rounded bg-indigo-600 text-white shadow-md hover:bg-indigo-700 font-bold text-xs uppercase transition transform hover:scale-105" @click="nextStep()">Next Step</button>
                    <button type="submit" x-show="currentStep === steps.length" class="px-10 py-2 rounded bg-green-600 text-white shadow-md hover:bg-green-700 font-bold text-xs uppercase transition transform hover:scale-105" :disabled="submitting" x-text="submitting ? 'Submitting...' : 'Confirm & Final Submit'"></button>
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
            teacherName: '', teacherNameBangla: '', designation: '', indexNo: '', ein: '', mobile: '', email: '', appointmentType: '',
            fatherName: '', motherName: '', religion: '', bloodGroup: '', dob: '', nid: '', bankName: '', bankAccountNo: '',
            presentAddress: '', upazilaThana: '', zillaPostOffice: '', photoPreview: 'https://placehold.co/150x150',
            sscExamType: '', sscBoard: '', sscYear: '', sscResult: '', sscRegistrationNo: '',
            hscExamType: '', hsceBoard: '', hscYear: '', hscResult: '', hscRegistrationNo: '',
            graduationExamType: '', graduationSubject: '', graduationResult: '', graduationYear: '',
            mastersExamType: '', mastersResult: '', mastersYear: '',
            bedResult: '', medResult: '', othersExam: '', othersExamResult: '',
            institutionType: '', subject: '', department: '', program: '',
            sscSubjectTeacher: '', hscSubjectTeacher: '',
            previousInstitution: '', previousDesignation: '', previousJoinDate: '', previousRelieveDate: '',
            agreed: false
        },
        steps: ['Basic Info', 'Personal', 'Address', 'Education', 'Higher Ed', 'Experience', 'Preview'],
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
@media print { .no-print { display: none !important; } }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/teacher-applications/create.blade.php ENDPATH**/ ?>