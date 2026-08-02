@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl" x-data="multiStepForm()">
        <!-- PDF Download Scripts (jsPDF + Bornomala font) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="{{ asset('js/studentapplicationPdf.js') }}"></script>

        <div class="rounded-lg shadow border border-gray-200 bg-white">
            <div class="px-4 py-2 bg-[#14532d] text-white font-semibold text-center flex items-center justify-center">
                <img src="{{ asset('icons/applicationform.svg') }}" alt="Application Form"
                    class="inline-block w-8 h-8 mr-2 p-1" />
                Application
            </div>

            <form id="application-form" action="{{ route('applications.store') }}" method="POST"
                enctype="multipart/form-data" class="p-0">
                @csrf

                <div class="p-6">
                    <!-- API Error Message / Admission Off -->
                    <div x-show="isApiDown" class="mb-4 rounded-lg border-2 border-red-500 bg-red-100 p-8 text-center"
                        x-cloak>
                        <h2 class="text-3xl font-bold text-red-700 uppercase tracking-widest">Admission Off</h2>
                        <p class="mt-2 text-red-600 font-semibold" x-text="admissionOffMessage || 'The admission system is currently unavailable. Please try again later or contact the administrator.'"></p>
                    </div>

                    <div x-show="!isApiDown">
                        <!-- Errors -->
                        <div x-show="showErrors && Object.keys(errors).length > 0"
                            class="mb-4 rounded border border-red-300 bg-red-50 text-red-700 px-3 py-2" x-cloak>
                            <div class="font-semibold">Fix the highlighted errors</div>
                            <ul class="mt-2 list-disc list-inside">
                                <template x-for="(error, key) in errors" :key="key">
                                    <li><span class="font-medium" x-text="fieldLabels[key] || key"></span>: <span
                                            x-text="error"></span></li>
                                </template>
                            </ul>
                        </div>

                        <!-- Steps -->

                        <!-- Step 1: Program Session & Group -->
                        <div x-show="currentStep === 1" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 1: Select Program Session & Group</div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border border-green-700 p-6 pt-8">
                                <div>
                                    <label class="text-sm font-medium">Program <span class="text-red-600">*</span></label>
                                    <select name="program" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.program ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.program" x-on:change="onProgramChange()">
                                        <option value="">Select</option>
                                        <template x-for="p in filteredPrograms" :key="p.id">
                                            <option :value="p.id" x-text="p.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Session <span class="text-red-600">*</span></label>
                                    <select name="session" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.session ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.session" x-on:change="onSessionChange()">
                                        <option value="">Select Session</option>
                                        <template x-for="(s, index) in admissionSessions"
                                            :key="typeof s === 'object' ? (s.id || s.session || index) : s">
                                            <option :value="typeof s === 'object' ? s.id : s"
                                                x-text="typeof s === 'object' ? s.session : s"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Group <span class="text-red-600">*</span></label>
                                    <select name="group" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.group ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.group" x-on:change="onGroupChange()">
                                        <option value="">Select Group</option>
                                        <template x-if="groups.length === 0">
                                            <option value="" disabled>Select a program first</option>
                                        </template>
                                        <template x-for="g in groups" :key="g.id">
                                            <option :value="g.id" x-text="g.name || g.group"></option>
                                        </template>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1" x-show="groups.length > 0">Available groups: <span
                                            x-text="groups.length"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Terms and Conditions -->
                        <div x-show="currentStep === 2" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 2: Terms and Conditions</div>
                            <div class="border border-green-700 text-gray-700 p-6 pt-8">
                                <!-- Terms Image from selected program -->
                                <template
                                    x-if="selectedProgram && (selectedProgram.termsImage || selectedProgram.termimage)">
                                    <div class="mb-4">
                                        <img :src="formatImageUrl(selectedProgram.termsImage || selectedProgram.termimage)"
                                            alt="Terms" class="max-w-full h-auto rounded border shadow-sm mx-auto"
                                            x-on:error="$el.src = 'https://placehold.co/600x800?text=Image+Not+Found'" />
                                    </div>
                                </template>
                                <p>Read the terms and accept to continue.</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <input type="checkbox" x-model="formData.agreed" />
                                    <span class="text-sm">I agree <span class="text-red-600">*</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Personal Information -->
                        <div x-show="currentStep === 3" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 3: Personal Information</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                <div>
                                    <label class="text-sm font-medium">Student Name (English) <span
                                            class="text-red-600">*</span></label>
                                    <input name="sNameEnglish" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.sNameEnglish ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.sNameEnglish" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Student Name (Bangla) <span
                                            class="text-red-600">*</span></label>
                                    <input name="sNameBangla" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.sNameBangla ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.sNameBangla" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Gender <span class="text-red-600">*</span></label>
                                    <select name="gender" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.gender ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.gender">
                                        <option value="">Select</option>
                                        <template x-for="g in genders" :key="g">
                                            <option :value="g" x-text="g"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Religion <span class="text-red-600">*</span></label>
                                    <select name="religion" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.religion ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.religion">
                                        <option value="">Select</option>
                                        <template x-for="r in religions" :key="r">
                                            <option :value="r" x-text="r"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Blood Group</label>
                                    <select name="bloodGroup" class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                        x-model="formData.bloodGroup">
                                        <option value="">Select</option>
                                        <template x-for="bg in bloodGroups" :key="bg">
                                            <option :value="bg" x-text="bg"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Nationality <span
                                            class="text-red-600">*</span></label>
                                    <select name="nationality" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.nationality ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.nationality">
                                        <option value="">Select</option>
                                        <template x-for="n in nationalities" :key="n">
                                            <option :value="n" x-text="n"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Marital Status</label>
                                    <select name="maritalStatus"
                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                        x-model="formData.maritalStatus">
                                        <option value="">Select</option>
                                        <template x-for="ms in maritalStatuses" :key="ms">
                                            <option :value="ms" x-text="ms"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Date of Birth <span
                                            class="text-red-600">*</span></label>
                                    <input type="date" name="dob" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.dob ? 'border-red-500' : 'border-gray-300'" x-model="formData.dob" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Mobile <span class="text-red-600">*</span></label>
                                    <input type="number" name="sMobileNo" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.sMobileNo ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.sMobileNo" placeholder="01XXXXXXXXX" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Birth Registration No <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" name="bitId" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.bitId ? 'border-red-500' : 'border-gray-300'"
                                        x-model="formData.bitId" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">NID</label>
                                    <input type="number" name="nid" class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.nid ? 'border-red-500' : 'border-gray-300'" x-model="formData.nid" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Hobby</label>
                                    <input name="hobby" class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                        x-model="formData.hobby" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Extra Curriculum</label>
                                    <input name="extracurriculam"
                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                        x-model="formData.extracurriculam" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium">Student Image <span
                                            class="text-red-600">*</span></label>
                                    <input type="file" name="sPicture" accept="image/png,image/jpeg,image/jpg"
                                        class="mt-1 w-full border rounded px-3 py-2"
                                        :class="errors.studentImage ? 'border-red-500' : 'border-gray-300'"
                                        x-on:change="handleImageUpload($event)" />
                                </div>
                                <div class="flex items-end">
                                    <img :src="formData.imagePreview" alt="preview"
                                        class="rounded w-20 h-20 object-cover" />
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Father and Mother Information -->
                        <div x-show="currentStep === 4" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 4: Father and Mother Information</div>
                            <div class="border border-green-700 p-6 pt-8">
                                <!-- Father -->
                                <div class="relative mt-4">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        Father Information</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">Name<span
                                                    class="text-red-600">*</span></label>
                                            <input name="fName" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.fName ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.fName" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Mobile <span
                                                    class="text-red-600">*</span></label>
                                            <input type="number" name="fMobileNo" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.fMobileNo ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.fMobileNo" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">NID</label>
                                            <input type="number" name="fNid" class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.fNid" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Occupation</label>
                                            <select name="fOccupation"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.fOccupation">
                                                <option value="">Select</option>
                                                <template x-for="o in occupations" :key="o.id">
                                                    <option :value="o.id" x-text="o.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Qualification</label>
                                            <select name="fQualification"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.fQualification">
                                                <option value="">Select</option>
                                                <template x-for="q in qualifications" :key="q.id">
                                                    <option :value="q.id" x-text="q.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Monthly Income</label>
                                            <input type="number" name="fMonthlyIncome"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.fMonthlyIncome" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Mother -->
                                <div class="relative mt-8">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        Mother Information</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">Name<span
                                                    class="text-red-600">*</span></label>
                                            <input name="mName" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.mName ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.mName" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Mobile</label>
                                            <input type="number" name="mMobileNo"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.mMobileNo" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">NID</label>
                                            <input type="number" name="mNid" class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.mNid" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Occupation</label>
                                            <select name="mOccupation"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.mOccupation">
                                                <option value="">Select</option>
                                                <template x-for="o in occupations" :key="o.id">
                                                    <option :value="o.id" x-text="o.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Qualification</label>
                                            <select name="mQualification"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.mQualification">
                                                <option value="">Select</option>
                                                <template x-for="q in qualifications" :key="q.id">
                                                    <option :value="q.id" x-text="q.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Monthly Income</label>
                                            <input type="number" name="mMonthlyIncome"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.mMonthlyIncome" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Address Information -->
                        <div x-show="currentStep === 5" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 5: Address Information</div>
                            <div class="border border-green-700 p-6 pt-8">
                                <!-- Present -->
                                <div class="relative mt-4">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        Present Address</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">Village/Block/Area <span
                                                    class="text-red-600">*</span></label>
                                            <input name="presentAddressVil" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.presentAddressVil ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.presentAddressVil" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">P.O<span
                                                    class="text-red-600">*</span></label>
                                            <input name="presentAddressPO" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.presentAddressPO ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.presentAddressPO" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">P.S <span
                                                    class="text-red-600">*</span></label>
                                            <input name="presentAddressPS" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.presentAddressPS ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.presentAddressPS" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">District <span
                                                    class="text-red-600">*</span></label>
                                            <select name="presentAddressDist" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.presentAddressDist ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.presentAddressDist">
                                                <option value="">Select</option>
                                                <template x-for="d in districts" :key="d.id">
                                                    <option :value="d.id" x-text="d.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="button"
                                        class="px-4 py-2 rounded border border-green-900 text-green-900 hover:bg-green-50 text-sm"
                                        x-on:click="copyAddress()">Same as Permanent Address</button>
                                </div>
                                <!-- Permanent -->
                                <div class="relative mt-8">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        Permanent Address</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">Village/Block/Area <span
                                                    class="text-red-600">*</span></label>
                                            <input name="permanentAddressVil" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.permanentAddressVil ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.permanentAddressVil" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">P.O <span
                                                    class="text-red-600">*</span></label>
                                            <input name="permanentAddressPO" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.permanentAddressPO ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.permanentAddressPO" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">P.S <span
                                                    class="text-red-600">*</span></label>
                                            <input name="permanentAddressPS" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.permanentAddressPS ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.permanentAddressPS" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">District <span
                                                    class="text-red-600">*</span></label>
                                            <select name="permanentAddressDist" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.permanentAddressDist ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.permanentAddressDist">
                                                <option value="">Select</option>
                                                <template x-for="d in districts" :key="d.id">
                                                    <option :value="d.id" x-text="d.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Guardian & Reference Information -->
                        <div x-show="currentStep === 6" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 6: Guardian & Reference Information</div>
                            <div class="border border-green-700 p-6 pt-8">
                                <!-- Guardian -->
                                <div class="relative mt-4">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        Guardian Information</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">Relation <span
                                                    class="text-red-600">*</span></label>
                                            <select name="gRelation" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.gRelation ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.gRelation" x-on:change="onGuardianRelationChange()">
                                                <option value="">Select</option>
                                                <option value="Father">Father</option>
                                                <option value="Mother">Mother</option>
                                                <template x-for="r in (constants.RELATIONSHIP || [])" :key="r">
                                                    <option x-show="r !== 'Father' && r !== 'Mother'" :value="r" x-text="r">
                                                    </option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Name <span
                                                    class="text-red-600">*</span></label>
                                            <input name="gName" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.gName ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.gName" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Mobile <span
                                                    class="text-red-600">*</span></label>
                                            <input type="number" name="gMobileNo" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.gMobileNo ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.gMobileNo" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">NID</label>
                                            <input type="number" name="gNid" class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.gNid" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Email</label>
                                            <input name="gEmail"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.gEmail" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Address</label>
                                            <input name="gAddress"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.gAddress" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Reference -->
                                <div class="relative mt-8">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        Reference Information</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">Name</label>
                                            <input name="refName"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.refName" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Mobile</label>
                                            <input type="number" name="refMobileNo"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.refMobileNo" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">NID</label>
                                            <input type="number" name="refNid"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.refNid" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Relation</label>
                                            <input name="refRelation"
                                                class="mt-1 w-full border rounded px-3 py-2 border-gray-300"
                                                x-model="formData.refRelation" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 7: Education Information -->
                        <div x-show="currentStep === 7" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-3/4 ">
                                Step 7: Education Information</div>
                            <div class="border border-green-700 p-6 pt-8">
                                <!-- SSC -->
                                <div class="relative mt-4">
                                    <div
                                        class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                        SSC/Equivalent Information</div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border border-green-700 p-6 pt-8">
                                        <div>
                                            <label class="text-sm font-medium">SSC Board <span
                                                    class="text-red-600">*</span></label>
                                            <select name="Board1" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.Board1 ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.Board1">
                                                <option value="">Select</option>
                                                <template x-for="b in boards" :key="b.id">
                                                    <option :value="b.id" x-text="b.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">SSC Session <span
                                                    class="text-red-600">*</span></label>
                                            <select name="sessionExam1" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.sessionExam1 ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.sessionExam1">
                                                <option value="">Select</option>
                                                <template x-for="(s, index) in allSessions"
                                                    :key="typeof s === 'object' ? (s.id || s.name || s.session || index) : s">
                                                    <option :value="typeof s === 'object' ? s.name : s"
                                                        x-text="typeof s === 'object' ? s.name : s"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">SSC Passing Year <span
                                                    class="text-red-600">*</span></label>
                                            <select name="passingYear1" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.passingYear1 ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.passingYear1">
                                                <option value="">Select</option>
                                                <template x-for="y in passingYears" :key="y">
                                                    <option :value="y" x-text="y"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">Registration <span
                                                    class="text-red-600">*</span></label>
                                            <input type="number" name="regNo1" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.regNo1 ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.regNo1" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">SSC Roll <span
                                                    class="text-red-600">*</span></label>
                                            <input type="number" name="rollNo1" class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.rollNo1 ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.rollNo1" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium">SSC GPA <span
                                                    class="text-red-600">*</span></label>
                                            <input type="number" step="0.01" name="gpa1"
                                                class="mt-1 w-full border rounded px-3 py-2"
                                                :class="errors.gpa1 ? 'border-red-500' : 'border-gray-300'"
                                                x-model="formData.gpa1" required />
                                        </div>
                                    </div>
                                </div>

                                <!-- HSC Information -->
                                <template
                                    x-if="selectedProgram && (selectedProgram.hscStatus == 1 || selectedProgram.hscStatus === true)">
                                    <div class="relative mt-8">
                                        <div
                                            class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                            HSC Information</div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border border-green-700 p-6 pt-8">
                                            <div>
                                                <label class="text-sm font-medium">HSC Board <span
                                                        class="text-red-600">*</span></label>
                                                <select name="Board2" class="mt-1 w-full border rounded px-3 py-2"
                                                    :class="errors.Board2 ? 'border-red-500' : 'border-gray-300'"
                                                    x-model="formData.Board2">
                                                    <option value="">Select</option>
                                                    <template x-for="b in boards" :key="b.id">
                                                        <option :value="b.id" x-text="b.name"></option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">HSC Session <span
                                                        class="text-red-600">*</span></label>
                                                <select name="sessionExam2" class="mt-1 w-full border rounded px-3 py-2"
                                                    :class="errors.sessionExam2 ? 'border-red-500' : 'border-gray-300'"
                                                    x-model="formData.sessionExam2">
                                                    <option value="">Select</option>
                                                    <template x-for="(s, index) in allSessions"
                                                        :key="typeof s === 'object' ? (s.id || s.name || s.session || index) : s">
                                                        <option :value="typeof s === 'object' ? s.name : s"
                                                            x-text="typeof s === 'object' ? s.name : s"></option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">HSC Passing Year <span
                                                        class="text-red-600">*</span></label>
                                                <select name="passingYear2" class="mt-1 w-full border rounded px-3 py-2"
                                                    :class="errors.passingYear2 ? 'border-red-500' : 'border-gray-300'"
                                                    x-model="formData.passingYear2">
                                                    <option value="">Select</option>
                                                    <template x-for="y in passingYears" :key="y">
                                                        <option :value="y" x-text="y"></option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">HSC Roll <span
                                                        class="text-red-600">*</span></label>
                                                <input type="number" name="rollNo2"
                                                    class="mt-1 w-full border rounded px-3 py-2"
                                                    :class="errors.rollNo2 ? 'border-red-500' : 'border-gray-300'"
                                                    x-model="formData.rollNo2" />
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">HSC Reg <span
                                                        class="text-red-600">*</span></label>
                                                <input type="number" name="regNo2"
                                                    class="mt-1 w-full border rounded px-3 py-2"
                                                    :class="errors.regNo2 ? 'border-red-500' : 'border-gray-300'"
                                                    x-model="formData.regNo2" />
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium">HSC GPA <span
                                                        class="text-red-600">*</span></label>
                                                <input type="number" step="0.01" name="gpa2"
                                                    class="mt-1 w-full border rounded px-3 py-2"
                                                    :class="errors.gpa2 ? 'border-red-500' : 'border-gray-300'"
                                                    x-model="formData.gpa2" required />
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <template
                                    x-if="selectedProgram && (selectedProgram.hscStatus == 0 || selectedProgram.hscStatus === false)">
                                    <div class="relative mt-8">
                                        <div
                                            class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-green-700 p-1 w-1/2 ">
                                            Registered Subjects</div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-green-700 p-4 p-6">
                                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label class="text-sm font-medium">Compulsory 1</label>
                                                    <input x-show="subjects.find(s => s.status === 'Compulsory1')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.compulsory1)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Compulsory1')"
                                                        name="compulsory1" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.compulsory1 ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.compulsory1"
                                                        x-on:change="onSubjectChange('compulsory1', formData.compulsory1)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('compulsory1')"
                                                            :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium">Compulsory 2</label>
                                                    <input x-show="subjects.find(s => s.status === 'Compulsory2')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.compulsory2)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Compulsory2')"
                                                        name="compulsory2" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.compulsory2 ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.compulsory2"
                                                        x-on:change="onSubjectChange('compulsory2', formData.compulsory2)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('compulsory2')"
                                                            :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium">Compulsory 3</label>
                                                    <input x-show="subjects.find(s => s.status === 'Compulsory3')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.compulsory3)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Compulsory3')"
                                                        name="compulsory3" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.compulsory3 ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.compulsory3"
                                                        x-on:change="onSubjectChange('compulsory3', formData.compulsory3)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('compulsory3')"
                                                            :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div>
                                                    <label class="text-sm font-medium">Elective 1 <span
                                                            class="text-red-600">*</span></label>
                                                    <input x-show="subjects.find(s => s.status === 'Elective1')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.elective1)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Elective1')"
                                                        name="elective1" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.elective1 ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.elective1"
                                                        x-on:change="onSubjectChange('elective1', formData.elective1)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('elective1')"
                                                            :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium">Elective 2 <span
                                                            class="text-red-600">*</span></label>
                                                    <input x-show="subjects.find(s => s.status === 'Elective2')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.elective2)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Elective2')"
                                                        name="elective2" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.elective2 ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.elective2"
                                                        x-on:change="onSubjectChange('elective2', formData.elective2)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('elective2')"
                                                            :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium">Elective 3 <span
                                                            class="text-red-600">*</span></label>
                                                    <input x-show="subjects.find(s => s.status === 'Elective3')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.elective3)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Elective3')"
                                                        name="elective3" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.elective3 ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.elective3"
                                                        x-on:change="onSubjectChange('elective3', formData.elective3)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('elective3')"
                                                            :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="text-sm font-medium">Optional <span
                                                            class="text-red-600">*</span></label>
                                                    <input x-show="subjects.find(s => s.status === 'Optional')"
                                                        class="mt-1 w-full border rounded px-3 py-2 border-gray-300 bg-gray-50"
                                                        :value="getSubjectName(formData.optional)" readonly />
                                                    <select x-show="!subjects.find(s => s.status === 'Optional')"
                                                        name="optional" class="mt-1 w-full border rounded px-3 py-2"
                                                        :class="errors.optional ? 'border-red-500' : 'border-gray-300'"
                                                        x-model="formData.optional"
                                                        x-on:change="onSubjectChange('optional', formData.optional)">
                                                        <option value="">Select</option>
                                                        <template x-for="s in getAvailableSubjects('optional')" :key="s.id">
                                                            <option :value="s.id" x-text="`${s.name} [${s.code}]`"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Step 8: Preview & Final Submission -->
                        <div x-show="currentStep === 8" class="relative mt-3" x-cloak>
                            <div
                                class="absolute top-[-12px] left-4 text-sm font-semibold text-gray-100 bg-[#14532d] p-1 w-3/4 ">
                                Step 8: Final Preview & Submission</div>


                            <div class="border-2 border-green-800 rounded-lg bg-gray-50/50  md:p-1  overflow-x-auto shadow-xl mb-2"
                                style="font-size: 12px;">
                                <!-- THE FORM FOR PDF (printable-form) -->
                                <div id="preview-content"
                                    class="bg-white min-w-[780px] mx-auto shadow-sm printable-form mt-5 font-sans text-[#1a1a1a]">
                                    <!-- Collage Header (Premium) -->
                                    <div class="relative flex items-center p-1 justify-between  font-serif mb-0.5  pb-1"
                                        :style="{ background: formData.groupColor || '#14532d' }">
                                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="w-28 h-28"
                                            onerror="this.onerror=null; this.src='https://placehold.co/100x120?text=LOGO'" />
                                        <div class="text-center">
                                            <h1 class="text-3xl font-bold tracking-tight uppercase"
                                                style="font-family: serif;">Hazera-Taju Degree College</h1>
                                            <p class="text-xs  tracking-widest ">B.Sc Chattar, Chandgaon, Chattogram</p>
                                            <div class="inline-block  text-xs font-bold  tracking-widest ">
                                                Application Form for <span
                                                    x-text="getNameById(programs, formData.program) || 'Admission'"></span>
                                                Admission
                                            </div>
                                            <div class="mt-3 flex flex-col items-center">
                                                <p class="text-lg font-bold "><span
                                                        x-text="getNameById(groups, formData.group) || 'Program Group'"></span>
                                                    Group</p>
                                                <p class="text-xs font-bold">Session: <span
                                                        x-text="getNameById(admissionSessions, formData.session) || '20XX-20XX'"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <img :src="formData.imagePreview" class="w-28 h-28 object-cover " />
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <!-- 1. Students Information -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">1. Students Information</h6>
                                                <p>
                                                    <span class="field-label w-40" style="font-size:12px;">Student Name (In
                                                        English):</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.sNameEnglish.toUpperCase()"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Student Name (In
                                                        Bangla):</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.sNameBangla"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Blood
                                                        Group:</span>
                                                    <span class="boxed-text min-w-[40px] text-center"><span
                                                            x-text="formData.bloodGroup"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Religion:</span>
                                                    <span class="boxed-text min-w-[60px] text-center"><span
                                                            x-text="formData.religion"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Gender:</span>
                                                    <span class="boxed-text min-w-[60px] text-center"><span
                                                            x-text="formData.gender"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Date of
                                                        Birth:</span>
                                                    <span class="boxed-text min-w-[100px] text-center font-mono"><span
                                                            x-text="formData.dob"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Birth
                                                        Registration No.:</span>
                                                    <span class="boxed-text flex-grow text-center font-mono"><span
                                                            x-text="formData.bitId"></span></span>
                                                    <span class="field-label w-40"
                                                        style="font-size:12px;">Nationality:</span>
                                                    <span class="boxed-text min-w-[80px] text-center"><span
                                                            x-text="formData.nationality"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Marital
                                                        Status:</span>
                                                    <span class="boxed-text min-w-[70px] text-center"><span
                                                            x-text="formData.maritalStatus"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Mobile No:</span>
                                                    <span class="boxed-text flex-grow text-center font-mono text-lg"><span
                                                            x-text="formData.sMobileNo"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">NID:</span>
                                                    <span class="boxed-text flex-grow text-center font-mono"><span
                                                            x-text="formData.nid"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Hobby:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.hobby"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Extra
                                                        Curricular:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.extraCurricular"></span></span>
                                                </p>
                                            </div>
                                        </section>

                                        <!-- 2. Father's Information -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">2. Father's Information</h6>
                                                <p>
                                                    <span class="field-label w-40" style="font-size:12px;">Father's
                                                        Name:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.fName.toUpperCase()"></span></span>
                                                    <span class="field-label ml-4">NID:</span>
                                                    <span class="boxed-text min-w-[150px] text-center font-mono"><span
                                                            x-text="formData.fNid"></span></span>
                                                    <span class="field-label w-40"
                                                        style="font-size:12px;">Qualification:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="getNameById(qualifications, formData.fQualification)"></span></span>
                                                    <span class="field-label ml-4"
                                                        style="font-size:12px;">Occupation:</span>
                                                    <span class="boxed-text min-w-[120px] text-center"><span
                                                            x-text="getNameById(occupations, formData.fOccupation)"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Monthly
                                                        Income:</span>
                                                    <span class="boxed-text min-w-[100px] text-center font-mono"><span
                                                            x-text="formData.fMonthlyIncome || 0"></span></span>
                                                    <span class="field-label ml-4" style="font-size:12px;">Yearly
                                                        Income:</span>
                                                    <span class="boxed-text min-w-[100px] text-center font-mono"><span
                                                            x-text="(formData.fMonthlyIncome * 12) || 0"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Mobile No:</span>
                                                    <span class="boxed-text flex-grow text-center font-mono"><span
                                                            x-text="formData.fMobileNo"></span></span>
                                                </p>
                                            </div>
                                        </section>

                                        <!-- 3. Mother's Information -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">3. Mother's Information</h6>
                                                <p>
                                                    <span class="field-label w-40" style="font-size:12px;"
                                                        style="font-size:12px;">Mother's Name:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.mName.toUpperCase()"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">NID:</span>
                                                    <span class="boxed-text min-w-[150px] text-center font-mono"><span
                                                            x-text="formData.mNid"></span></span>
                                                    <span class="field-label w-40"
                                                        style="font-size:12px;">Qualification:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="getNameById(qualifications, formData.mQualification)"></span></span>
                                                    <span class="field-label w-40"
                                                        style="font-size:12px;">Occupation:</span>
                                                    <span class="boxed-text min-w-[120px] text-center"><span
                                                            x-text="getNameById(occupations, formData.mOccupation)"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Monthly
                                                        Income:</span>
                                                    <span class="boxed-text min-w-[100px] text-center font-mono"><span
                                                            x-text="formData.mMonthlyIncome || 0"></span></span>
                                                    <span class="field-label ml-4" style="font-size:12px;">Yearly
                                                        Income:</span>
                                                    <span class="boxed-text min-w-[100px] text-center font-mono"><span
                                                            x-text="(formData.mMonthlyIncome * 12) || 0"></span></span>
                                                    <span class="field-label ml-4">Mobile No:</span>
                                                    <span class="boxed-text flex-grow text-center font-mono"><span
                                                            x-text="formData.mMobileNo"></span></span>
                                                </p>
                                            </div>
                                        </section>

                                        <!-- 4. Total Yearly Income -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">4. Total Yearly Income</h6>
                                                <p>
                                                    <span class="field-label w-40" style="font-size:12px;">Total Yearly
                                                        Income (Father + Mother):</span>
                                                    <span
                                                        class="boxed-text flex-grow text-center font-mono text-lg bg-green-50"><span
                                                            x-text="((formData.fMonthlyIncome * 12) + (formData.mMonthlyIncome * 12)) || 0"></span></span>
                                                </p>
                                            </div>
                                        </section>

                                        <!-- 5. Address -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">5. Address</h6>
                                                <p>
                                                    <span class="field-label block italic mb-1">Permanent Address:</span>
                                                    <span class="field-label text-[9px]">Vill/Block/Area:</span>
                                                    <span class="boxed-text min-w-[120px]"><span
                                                            x-text="formData.permanentAddressVil"></span></span>
                                                    <span class="field-label text-[9px]">Post office:</span>
                                                    <span class="boxed-text min-w-[100px]"><span
                                                            x-text="formData.permanentAddressPO"></span></span>
                                                    <span class="field-label text-[9px]">Thana:</span>
                                                    <span class="boxed-text min-w-[100px]"><span
                                                            x-text="formData.permanentAddressPS"></span></span>
                                                    <span class="field-label text-[9px]">District:</span>
                                                    <span class="boxed-text min-w-[100px]"><span
                                                            x-text="getNameById(districts, formData.permanentAddressDist)"></span></span>
                                                </p>
                                                <p class="mt-2">
                                                    <span class="field-label block italic mb-1">Present Address:</span>
                                                    <span class="field-label text-[9px]">Vill/Block/Area:</span>
                                                    <span class="boxed-text min-w-[120px]"><span
                                                            x-text="formData.presentAddressVil"></span></span>
                                                    <span class="field-label text-[9px]">Post office:</span>
                                                    <span class="boxed-text min-w-[100px]"><span
                                                            x-text="formData.presentAddressPO"></span></span>
                                                    <span class="field-label text-[9px]">Thana:</span>
                                                    <span class="boxed-text min-w-[100px]"><span
                                                            x-text="formData.presentAddressPS"></span></span>
                                                    <span class="field-label text-[9px]">District:</span>
                                                    <span class="boxed-text min-w-[100px]"><span
                                                            x-text="getNameById(districts, formData.presentAddressDist)"></span></span>
                                                </p>
                                            </div>
                                        </section>

                                        <!-- 6. Guardian's Information -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">6. Guardian's Information</h6>
                                                <p>
                                                    <span class="field-label w-40" style="font-size:12px;">Guardian's
                                                        Name:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.gName.toUpperCase()"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">NID:</span>
                                                    <span class="boxed-text min-w-[120px] text-center font-mono"><span
                                                            x-text="formData.gNid"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Relation:</span>
                                                    <span class="boxed-text min-w-[60px] text-center"><span
                                                            x-text="formData.gRelation"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Mobile No:</span>
                                                    <span class="boxed-text min-w-[120px] text-center font-mono"><span
                                                            x-text="formData.gMobileNo"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">E-mail:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.gEmail"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Address:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.gAddress"></span></span>
                                                </p>
                                            </div>
                                        </section>
                                        <!-- 7. Reference's Information -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">7. Reference's Information</h6>
                                                <p>
                                                    <span class="field-label w-40" style="font-size:12px;">Reference
                                                        Name:</span>
                                                    <span class="boxed-text flex-grow"><span
                                                            x-text="formData.refName ? formData.refName.toUpperCase() : ''"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Relation:</span>
                                                    <span class="boxed-text min-w-[80px] text-center"><span
                                                            x-text="formData.refRelation || ''"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">Mobile No:</span>
                                                    <span class="boxed-text min-w-[120px] text-center font-mono"><span
                                                            x-text="formData.refMobileNo || ''"></span></span>
                                                    <span class="field-label w-40" style="font-size:12px;">NID:</span>
                                                    <span class="boxed-text flex-grow text-center font-mono"><span
                                                            x-text="formData.refNid || ''"></span></span>
                                                </p>
                                            </div>
                                        </section>
                                        <!-- 8. Educational Information -->
                                        <section>
                                            <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                class="p-1">
                                                <h6 class="text-lg font-bold">8. Educational Information</h6>
                                                <div class="p-1">
                                                    <p class="mb-1 text-[11px]">
                                                        <span class="font-bold">Exam name :</span> SSC
                                                        <span class="font-bold ml-2">Roll No :</span> <span
                                                            x-text="formData.rollNo1"></span>
                                                        <span class="font-bold ml-2">Reg. No :</span> <span
                                                            x-text="formData.regNo1"></span>
                                                        <span class="font-bold ml-2">Session :</span> <span
                                                            x-text="formData.sessionExam1"></span>
                                                        <span class="font-bold ml-2">GPA :</span> <span
                                                            x-text="formData.gpa1"></span>
                                                        <span class="font-bold ml-2">Passing Year :</span> <span
                                                            x-text="formData.passingYear1"></span>
                                                        <span class="font-bold ml-2">Board :</span> <span
                                                            x-text="getNameById(boards, formData.Board1)"></span>
                                                    </p>
                                                    <!-- HSC if required -->
                                                    <template
                                                        x-if="selectedProgram && (selectedProgram.hscStatus == 1 || selectedProgram.hscStatus === true)">
                                                        <p class="text-[11px]">
                                                            <span class="font-bold">Exam name :</span> HSC
                                                            <span class="font-bold ml-2">Roll No :</span> <span
                                                                x-text="formData.rollNo2"></span>
                                                            <span class="font-bold ml-2">Reg. No :</span> <span
                                                                x-text="formData.regNo2"></span>
                                                            <span class="font-bold ml-2">Session :</span> <span
                                                                x-text="formData.sessionExam2"></span>
                                                            <span class="font-bold ml-2">GPA :</span> <span
                                                                x-text="formData.gpa2"></span>
                                                            <span class="font-bold ml-2">Passing Year :</span> <span
                                                                x-text="formData.passingYear2"></span>
                                                            <span class="font-bold ml-2">Board :</span> <span
                                                                x-text="getNameById(boards, formData.Board2)"></span>
                                                        </p>
                                                    </template>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- 9. Subject Information -->
                                        <template
                                            x-if="selectedProgram && (selectedProgram.hscStatus == 0 || selectedProgram.hscStatus === false)">
                                            <section>
                                                <div :style="{ border: '1px solid ' + (formData.groupColor || '#14532d') }"
                                                    class="p-1">
                                                    <h6 class="text-lg font-bold">9. Subject Information</h6>
                                                    <div class="p-1 pb-2">
                                                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-[10px]">
                                                            <div class="inline-block"><span
                                                                    class="font-bold underline">Compulsory:</span>
                                                                (1) <span
                                                                    x-text="getSubjectName(formData.compulsory1)"></span>,
                                                                (2) <span
                                                                    x-text="getSubjectName(formData.compulsory2)"></span>,
                                                                (3) <span
                                                                    x-text="getSubjectName(formData.compulsory3)"></span>
                                                            </div>
                                                            <div class="inline-block"><span
                                                                    class="font-bold underline">Elective:</span>
                                                                (4) <span
                                                                    x-text="getSubjectName(formData.elective1)"></span>,
                                                                (5) <span
                                                                    x-text="getSubjectName(formData.elective2)"></span>,
                                                                (6) <span
                                                                    x-text="getSubjectName(formData.elective3)"></span>
                                                            </div>
                                                            <div class="inline-block"><span
                                                                    class="font-bold underline">Optional:</span>
                                                                (7) <span x-text="getSubjectName(formData.optional)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </template>
                                    </div>
                                    <div class="border-t border-dashed border-gray-300 pt-2 flex justify-center">
                                        <span class="text-[8px] text-gray-400 uppercase tracking-tighter">Page-1</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Final Action (Combined Submit & Download) -->
                            <div
                                class="mt-8 flex flex-col items-center gap-4 no-print py-6 bg-green-50 rounded-xl border-2 border-green-200 shadow-inner">
                                <p class="text-green-800 font-bold text-center px-4">If the preview looks correct, please
                                    click below to finalize your application.</p>
                                <button type="button"
                                    class="px-12 py-4 bg-[#14532d] text-white rounded-full shadow-2xl hover:bg-green-800 flex items-center gap-3 font-black text-xl transform transition hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                    x-on:click="submitAndDownload()" :disabled="submitting">
                                    <template x-if="!submitting">
                                        <div class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>SUBMIT & DOWNLOAD PDF</span>
                                        </div>
                                    </template>
                                    <template x-if="submitting">
                                        <div class="flex items-center gap-3">
                                            <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span>PROCESSING...</span>
                                        </div>
                                    </template>
                                </button>
                                <p class="text-xs text-green-600 italic">This will securely submit your data and
                                    automatically start your download.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation Buttons -->
                    <div class="px-4 py-4 flex gap-2 justify-between border-t border-gray-200 bg-gray-50 rounded-b-lg no-print"
                        x-show="!isApiDown">
                        <div>
                            <button type="button" x-show="currentStep > 1 && currentStep < 8"
                                class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white shadow-sm hover:bg-gray-100 font-medium transition"
                                @click="prevStep()">Previous</button>
                            <button type="button" x-show="currentStep === 8"
                                class="px-6 py-2 rounded-lg border-2 border-green-300 text-green-700 bg-white shadow-sm hover:bg-green-50 font-bold transition"
                                @click="prevStep()">Edit Form</button>
                        </div>
                        <div class="ml-auto flex gap-2">
                            <button type="button" x-show="currentStep < 8"
                                class="px-10 py-2 rounded-lg bg-green-600 text-white shadow-md hover:bg-green-700 font-bold transition transform hover:scale-105"
                                @click="nextStep()">Next</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script>
        function multiStepForm() {
            return {
                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const progId = urlParams.get('program_id');

                    if (this.programs && this.programs.error === 'connection_failed') {
                        console.error('API Connection Error: Failed to fetch programs from {{ $options["apiBaseUrl"] }}/api/programs/admission/');
                        this.isApiDown = true;
                        this.programs = [];
                    } else if (!Array.isArray(this.programs) || this.programs.length === 0) {
                        console.warn('No programs available from API.');
                        this.isApiDown = true;
                    } else {
                        console.log('Programs API Data:', this.programs);
                        
                        // Handle auto-selection via URL
                        if (progId) {
                            this.$nextTick(() => {
                                const program = this.programs.find(p => p.id == progId);
                                if (program) {
                                    console.log('Auto-selecting program:', program.name);
                                    this.formData.program = program.id;
                                    this.onProgramChange();
                                } else {
                                    console.warn('Program ID from URL not found in available programs:', progId);
                                    this.isApiDown = true;
                                    this.admissionOffMessage = "Admission for the selected program is currently off.";
                                }
                            });
                        }
                    }
                },
                currentStep: 1,
                isApiDown: false,
                admissionOffMessage: '',
                showErrors: false,
                errors: {},
                submitting: false,
                selectedProgram: null,
                formData: {
                    program: '', session: '', group: '', groupColor: '', sNameEnglish: '', sNameBangla: '',
                    gender: '', religion: '', bloodGroup: '', nationality: '', dob: '', sMobileNo: '',
                    bitId: '', nid: '', imagePreview: 'https://placehold.co/150x150', imageFileSelected: false, hobby: '', extracurriculam: '',
                    agreed: false, fName: '', fMobileNo: '', fNid: '', fOccupation: '', fQualification: '', fMonthlyIncome: '',
                    mName: '', mMobileNo: '', mNid: '', mOccupation: '', mQualification: '', mMonthlyIncome: '',
                    presentAddressVil: '', presentAddressPO: '', presentAddressPS: '', presentAddressDist: '',
                    permanentAddressVil: '', permanentAddressPO: '', permanentAddressPS: '', permanentAddressDist: '',
                    gRelation: '', gName: '', gMobileNo: '', gNid: '', gEmail: '', gAddress: '',
                    refName: '', refMobileNo: '', refNid: '', refRelation: '',
                    Board1: '', sessionExam1: '', rollNo1: '', regNo1: '', gpa1: '', passingYear1: '',
                    Board2: '', sessionExam2: '', rollNo2: '', regNo2: '', gpa2: '', passingYear2: '',
                    compulsory1: '', compulsory2: '', compulsory3: '', elective1: '', elective2: '', elective3: '', optional: ''
                },
                fieldLabels: {
                    program: 'Program',
                    session: 'Session',
                    group: 'Group',
                    sNameEnglish: 'Student Name (English)',
                    sNameBangla: 'Student Name (Bangla)',
                    gender: 'Gender',
                    religion: 'Religion',
                    sMobileNo: 'Mobile Number',
                    bitId: 'Birth Registration No',
                    studentImage: 'Student Image',
                    fName: "Father's Name",
                    mName: "Mother's Name",
                    agreed: 'Terms Acceptance',
                    Board1: 'SSC Board',
                    rollNo1: 'SSC Roll',
                    regNo1: 'SSC Registration',
                    passingYear1: 'SSC Passing Year'
                },
                admissionSessions: {!! json_encode(count($options['admissionSessions']) > 0 ? $options['admissionSessions'] : [['id' => 1, 'session' => '2024-2025'], ['id' => 2, 'session' => '2025-2026']]) !!},
                allSessions: {!! json_encode(count($options['allSessions']) > 0 ? $options['allSessions'] : [['name' => '2024-2025'], ['name' => '2023-2024']]) !!},
                programs: {!! json_encode($options['programs']) !!},
                constants: {!! json_encode($options['constants']) !!},
                groups: [],
                get genders() { return this.constants.GENDERS || []; },
                get religions() { return this.constants.RELIGIONS || []; },
                get bloodGroups() { return this.constants.BLOOD_GROUPS || []; },
                get nationalities() { return this.constants.NATIONALITY || []; },
                get maritalStatuses() { return this.constants.MARITAL_STATUS || []; },
                get passingYears() { return (this.constants.YEAR_CHOICES || []).map(String); },
                occupations: {!! json_encode($options['occupations']) !!},
                qualifications: {!! json_encode($options['qualifications']) !!},
                districts: {!! json_encode($options['districts']) !!},
                boards: {!! json_encode($options['boards']) !!},
                subjects: [],
                get filteredPrograms() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const progId = urlParams.get('program_id');
                    if (progId && Array.isArray(this.programs)) {
                        return this.programs.filter(p => p.id == progId);
                    }
                    return this.programs || [];
                },

                getNameById(list, id) {
                    if (!id) return '';
                    const item = (list || []).find(x => x.id == id);
                    return item ? (item.name || item.group || item.session || '') : id;
                },

                getSubjectName(id) {
                    if (!id) return '';
                    const s = this.subjects.find(x => x.id == id);
                    return s ? `${s.name} [${s.code}]` : id;
                },

                onProgramChange() {
                    console.log('Program changed to ID:', this.formData.program);

                    this.selectedProgram = this.programs.find(p => p.id == this.formData.program) || null;

                    if (this.selectedProgram) {
                        this.formData.programId = this.selectedProgram.id;
                        console.log('Selected Program:', this.selectedProgram.name);

                        this.groups = [];
                        this.formData.group = '';
                        this.fetchGroups(this.formData.program);
                    } else {
                        this.formData.programId = '';
                        this.groups = [];
                        this.formData.group = '';
                    }

                    // Clear all dependent fields
                    this.formData.session = '';
                    this.formData.session = '';
                    this.formData.elective1 = '';
                    this.formData.elective2 = '';
                    this.formData.elective3 = '';
                    this.formData.optional = '';
                    this.subjects = [];
                },

                onGroupChange() {
                    console.log('Group changed to ID:', this.formData.group);
                    const group = this.groups.find(g => g.id == this.formData.group);
                    this.formData.groupColor = group ? group.color : '';

                    if (this.formData.group && this.formData.program) {
                        this.fetchSubjects(this.formData.program, this.formData.group);
                    } else {
                        this.subjects = [];
                    }
                },

                // Handle subject selection changes and update exclusions
                onSubjectChange(field, selectedId) {
                    console.log('=== Subject Change ===');
                    console.log('Changed field:', field, 'to ID:', selectedId);

                    const allSubjectFields = ['compulsory1', 'compulsory2', 'compulsory3', 'elective1', 'elective2', 'elective3', 'optional'];
                    const fieldIndex = allSubjectFields.indexOf(field);

                    // Cascading Reset: Clear downstream fields if they have the SAME subject
                    if (selectedId && fieldIndex !== -1) {
                        for (let i = fieldIndex + 1; i < allSubjectFields.length; i++) {
                            const f = allSubjectFields[i];
                            if (this.formData[f] == selectedId) {
                                console.log(`  → Resetting downstream field ${f} (conflict)`);
                                this.formData[f] = '';
                            }
                        }
                    }

                    // Force Alpine.js reactivity update
                    this.$nextTick(() => {
                        this.subjects = [...this.subjects];
                    });
                },

                // Helper to get available subjects for a specific field based on cascading rules
                getAvailableSubjects(field) {
                    const allSubjectFields = ['compulsory1', 'compulsory2', 'compulsory3', 'elective1', 'elective2', 'elective3', 'optional'];
                    const fieldIndex = allSubjectFields.indexOf(field);

                    // Preceding fields must not contain the same subject
                    const usedUpstream = [];
                    for (let i = 0; i < fieldIndex; i++) {
                        const f = allSubjectFields[i];
                        if (this.formData[f]) {
                            usedUpstream.push(this.formData[f]);
                        }
                    }

                    return (this.subjects || []).filter(s => {
                        // Must be selectable status
                        if (s.status !== 'selectable') return false;
                        // Must not be used in any upstream slot
                        return !usedUpstream.some(id => id == s.id);
                    });
                },

                async fetchSubjects(programId, groupId) {
                    console.log('=== fetchSubjects called for:', programId, groupId);
                    try {
                        const url = `/proxy/subjects/${programId}/${groupId}`;
                        console.log('Fetching subjects through local proxy from:', url);

                        const response = await fetch(url, {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const data = await response.json();
                        this.subjects = Array.isArray(data) ? data : [];

                        // Reset subject fields
                        this.formData.compulsory1 = '';
                        this.formData.compulsory2 = '';
                        this.formData.compulsory3 = '';
                        this.formData.elective1 = '';
                        this.formData.elective2 = '';
                        this.formData.elective3 = '';
                        this.formData.optional = '';

                        // Flexible logic: if status is given, it's fixed
                        this.subjects.forEach(s => {
                            if (s.status === 'Compulsory1') this.formData.compulsory1 = s.id;
                            else if (s.status === 'Compulsory2') this.formData.compulsory2 = s.id;
                            else if (s.status === 'Compulsory3') this.formData.compulsory3 = s.id;
                            else if (s.status === 'Elective1') this.formData.elective1 = s.id;
                            else if (s.status === 'Elective2') this.formData.elective2 = s.id;
                            else if (s.status === 'Elective3') this.formData.elective3 = s.id;
                            else if (s.status === 'Optional') this.formData.optional = s.id;
                        });
                    } catch (e) {
                        console.error('Error fetching subjects:', e);
                    }
                },
                async fetchGroups(programId) {
                    if (!programId) return;
                    console.log('=== fetchGroups called with programId:', programId);
                    try {
                        const url = `/proxy/groups/${programId}`;
                        console.log('Fetching groups through local proxy from:', url);

                        this.groups = [];

                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            const data = await response.json();
                            console.log('Groups API response:', data);
                            this.groups = Array.isArray(data) ? data : (data.data || []);
                        } else {
                            console.error('Failed to fetch groups. Status:', response.status);
                        }
                    } catch (error) {
                        console.error('Error fetching groups:', error);
                    }
                },
                onSessionChange() {
                    this.formData.group = '';
                },
                onGuardianRelationChange() {
                    const v = this.formData.gRelation;
                    if (v === 'Father') {
                        this.formData.gName = this.formData.fName;
                        this.formData.gMobileNo = this.formData.fMobileNo;
                        this.formData.gNid = this.formData.fNid;
                    } else if (v === 'Mother') {
                        this.formData.gName = this.formData.mName;
                        this.formData.gMobileNo = this.formData.mMobileNo;
                        this.formData.gNid = this.formData.mNid;
                    }
                },
                formatImageUrl(path) {
                    if (!path) return '';
                    let cleanPath = path.toString().replace(/[`\s]/g, '');

                    console.log('Formatting image path:', path);

                    // If already a full URL, return as is
                    if (cleanPath.startsWith('http://') || cleanPath.startsWith('https://')) {
                        console.log('Full URL detected:', cleanPath);
                        return cleanPath;
                    }

                    // If path starts with 'media/', prepend base URL
                    if (cleanPath.startsWith('media/')) {
                        const baseUrl = "{{ $options['apiBaseUrl'] }}";
                        const finalUrl = baseUrl + '/' + cleanPath.replace(/^\//, '');
                        console.log('Media path detected, final URL:', finalUrl);
                        return finalUrl;
                    }

                    // Default: prepend base URL
                    const baseUrl = "{{ $options['apiBaseUrl'] }}";
                    const finalUrl = baseUrl + '/' + cleanPath.replace(/^\//, '');
                    console.log('Default formatting, final URL:', finalUrl);
                    return finalUrl;
                },
                handleImageUpload(e) {
                    const f = e.target.files[0];
                    if (!f) return;
                    const reader = new FileReader();
                    reader.onload = () => {
                        this.formData.imagePreview = reader.result;
                        this.formData.imageFileSelected = true;
                    };
                    reader.readAsDataURL(f);
                },
                copyAddress() {
                    this.formData.permanentAddressVil = this.formData.presentAddressVil;
                    this.formData.permanentAddressPO = this.formData.presentAddressPO;
                    this.formData.permanentAddressPS = this.formData.presentAddressPS;
                    this.formData.permanentAddressDist = this.formData.presentAddressDist;
                },
                validateCurrentStep() {
                    this.errors = {};
                    if (this.currentStep === 1) {
                        if (!this.formData.program) this.errors.program = 'Required';
                        if (!this.formData.session) this.errors.session = 'Required';
                        if (!this.formData.group) this.errors.group = 'Required';
                    } else if (this.currentStep === 2) {
                        if (!this.formData.agreed) this.errors.agreed = 'Required';
                    } else if (this.currentStep === 3) {
                        if (!this.formData.sNameEnglish) this.errors.sNameEnglish = 'Required';
                        if (!this.formData.sNameBangla) {
                            this.errors.sNameBangla = 'Required';
                        } else if (!this.formData.sNameBangla.match(/^[\u0980-\u09FF\s\u200C\u200D]+$/)) {
                            this.errors.sNameBangla = 'Only Bangla characters allowed';
                        }
                        if (!this.formData.gender) this.errors.gender = 'Required';
                        if (!this.formData.religion) this.errors.religion = 'Required';
                        if (!this.formData.nationality) this.errors.nationality = 'Required';
                        if (!this.formData.dob) this.errors.dob = 'Required';
                        if (!this.formData.sMobileNo.toString().match(/^01[0-9]{9}$/)) this.errors.sMobileNo = 'Invalid (01XXXXXXXXX)';
                        if (!this.formData.bitId) this.errors.bitId = 'Required';
                        if (!this.formData.imageFileSelected) this.errors.studentImage = 'Required';
                    } else if (this.currentStep === 4) {
                        if (!this.formData.fName) this.errors.fName = 'Required';
                        if (!this.formData.fMobileNo) this.errors.fMobileNo = 'Required';
                        if (!this.formData.mName) this.errors.mName = 'Required';
                    } else if (this.currentStep === 5) {
                        if (!this.formData.presentAddressVil) this.errors.presentAddressVil = 'Required';
                        if (!this.formData.presentAddressPO) this.errors.presentAddressPO = 'Required';
                        if (!this.formData.presentAddressPS) this.errors.presentAddressPS = 'Required';
                        if (!this.formData.presentAddressDist) this.errors.presentAddressDist = 'Required';
                        if (!this.formData.permanentAddressVil) this.errors.permanentAddressVil = 'Required';
                        if (!this.formData.permanentAddressPO) this.errors.permanentAddressPO = 'Required';
                        if (!this.formData.permanentAddressPS) this.errors.permanentAddressPS = 'Required';
                        if (!this.formData.permanentAddressDist) this.errors.permanentAddressDist = 'Required';
                    } else if (this.currentStep === 6) {
                        if (!this.formData.gRelation) this.errors.gRelation = 'Required';
                        if (!this.formData.gName) this.errors.gName = 'Required';
                        if (!this.formData.gMobileNo) this.errors.gMobileNo = 'Required';
                    } else if (this.currentStep === 7) {
                        // SSC is always required
                        if (!this.formData.Board1) this.errors.Board1 = 'Required';
                        if (!this.formData.sessionExam1) this.errors.sessionExam1 = 'Required';
                        if (!this.formData.passingYear1) this.errors.passingYear1 = 'Required';
                        if (!this.formData.regNo1) this.errors.regNo1 = 'Required';
                        if (!this.formData.rollNo1) this.errors.rollNo1 = 'Required';
                        if (!this.formData.gpa1) this.errors.gpa1 = 'Required';

                        // Check the hscStatus of the selected program
                        const hscEnabled = this.selectedProgram ?
                            (this.selectedProgram.hscStatus === true) : false;

                        if (!hscEnabled) {
                            // When hscStatus is false, Registered Subjects is ON
                            if (!this.formData.compulsory1) this.errors.compulsory1 = 'Required';
                            if (!this.formData.compulsory2) this.errors.compulsory2 = 'Required';
                            if (!this.formData.compulsory3) this.errors.compulsory3 = 'Required';
                            if (!this.formData.elective1) this.errors.elective1 = 'Required';
                            if (!this.formData.elective2) this.errors.elective2 = 'Required';
                            if (!this.formData.elective3) this.errors.elective3 = 'Required';
                            if (!this.formData.optional) this.errors.optional = 'Required';
                        } else {
                            // When hscStatus is true, HSC Information is ON
                            if (!this.formData.Board2) this.errors.Board2 = 'Required';
                            if (!this.formData.sessionExam2) this.errors.sessionExam2 = 'Required';
                            if (!this.formData.passingYear2) this.errors.passingYear2 = 'Required';
                            if (!this.formData.rollNo2) this.errors.rollNo2 = 'Required';
                            if (!this.formData.regNo2) this.errors.regNo2 = 'Required';
                            if (!this.formData.gpa2) this.errors.gpa2 = 'Required';
                        }
                    }
                    return Object.keys(this.errors).length === 0;
                },
                nextStep() {
                    if (this.validateCurrentStep()) {
                        this.currentStep++;
                        this.showErrors = false;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        this.showErrors = true;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                prevStep() {
                    this.currentStep--;
                    this.showErrors = false;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                async submitAndDownload() {
                    if (this.submitting) return;
                    this.submitting = true;

                    try {
                        // 1. Prepare Form Data
                        const formElement = document.getElementById('application-form');
                        const formData = new FormData(formElement);

                        console.log('Submitting application data via AJAX...');

                        // 2. AJAX Submission
                        const response = await fetch(formElement.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Submission failed');
                        }

                        const result = await response.json();
                        console.log('Submission successful:', result);

                        // Update local PIN code from server response
                        if (result.pinCode) {
                            this.formData.pinCode = result.pinCode;
                        }

                        // 3. Trigger PDF Download
                        console.log('Generating PDF...');
                        // Wait a bit for the PIN code to render in DOM
                        await this.$nextTick();
                        await this.downloadPdf();

                        // 4. Success handling
                        alert('Success! Your application has been submitted and the PDF is downloading.');

                        // Reset/Refresh page as requested
                        window.location.href = window.location.pathname; // Redirects to the same page (apply)

                    } catch (error) {
                        console.error('Submission Error:', error);
                        alert('Error: ' + error.message);
                        this.errors = { submission: error.message };
                        this.showErrors = true;
                    } finally {
                        this.submitting = false;
                    }
                },

                // === PDF Download — delegates to external studentapplicationPdf.js ===
                async downloadPdf() {
                    const lookups = {
                        programs: this.programs,
                        groups: this.groups,
                        allSessions: this.allSessions,
                        admissionSessions: this.admissionSessions,
                        qualifications: this.qualifications,
                        occupations: this.occupations,
                        districts: this.districts,
                        boards: this.boards,
                        subjects: this.subjects
                    };
                    await generateStudentApplicationPdf(
                        this.formData,
                        lookups,
                        this.getNameById.bind(this),
                        this.getSubjectName.bind(this)
                    );
                }

            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }

        /* Redesigned Form Styles */
        .section-title {
            background-color: #14532d;
            color: white;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 1px;
        }

        .field-label {
            font-weight: 700;
            font-size: 10px;
            color: #374151;
        }

        .boxed-text {
            border: 1px solid #9ca3af;
            background-color: #ffffff;
            padding: 2px 8px;
            min-height: 22px;
            display: inline-block;
            vertical-align: middle;
            font-size: 11px;
            font-weight: 600;
            color: #111827;
            border-radius: 2px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .printable-form {
            line-height: 1.25;
        }

        /* Pulse animation for submittion */
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }
    </style>
@endsection