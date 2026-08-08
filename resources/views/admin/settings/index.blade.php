@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('admin.contact_settings_management') }}</h1>
            <p class="text-gray-600 mt-1">Manage all contact information displayed on the website</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            {{ __('admin.back_to_dashboard') }}
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Basic Information Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ __('admin.college_information') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.college_name') }} (EN)</label>
                        <input type="text" name="college_name" value="{{ old('college_name', $setting->college_name) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.college_name') }} (BN)</label>
                        <input type="text" name="college_name_bn" value="{{ old('college_name_bn', $setting->college_name_bn) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.location') }} (EN)</label>
                        <input type="text" name="location" value="{{ old('location', $setting->location) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.location') }} (BN)</label>
                        <input type="text" name="location_bn" value="{{ old('location_bn', $setting->location_bn) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.full_address') }} (EN)</label>
                        <textarea name="address" rows="3" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">{{ old('address', $setting->address) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.full_address') }} (BN)</label>
                        <textarea name="address_bn" rows="3" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">{{ old('address_bn', $setting->address_bn) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Website Language Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    {{ __('admin.website_language') }}
                </h2>
            </div>
            <div class="p-6">
                <div class="max-w-md">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.select_website_language') }}</label>
                    <select name="site_language" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                        <option value="en" {{ old('site_language', $setting->site_language ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                        <option value="bn" {{ old('site_language', $setting->site_language ?? 'en') === 'bn' ? 'selected' : '' }}>বাংলা (Bangla)</option>
                    </select>
                    <p class="mt-2 text-sm text-gray-500">Choose the default language for your website and admin panel. This will apply to all users and browsers.</p>
                </div>
            </div>
        </div>

        <!-- Contact Numbers Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    {{ __('admin.phone_numbers') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.telephone') }}</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $setting->telephone) }}" 
                               placeholder="031-671018"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.cell_phone') }}</label>
                        <input type="text" name="cell_phone" value="{{ old('cell_phone', $setting->cell_phone) }}" 
                               placeholder="+880-1535-454836"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                </div>
            </div>
        </div>

        <!-- Codes & Email Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('admin.codes_email') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.eiin') }}</label>
                        <input type="text" name="ein" value="{{ old('ein', $setting->ein) }}" 
                               placeholder="104237"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.nu_code') }}</label>
                        <input type="text" name="nu_code" value="{{ old('nu_code', $setting->nu_code) }}" 
                               placeholder="4303"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.e_mail') }}</label>
                    <input type="email" name="email" value="{{ old('email', $setting->email) }}" 
                           placeholder="info@htdc.edu.bd"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                </div>
            </div>
        </div>

        <!-- Online Presence Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    {{ __('admin.online_presence') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.website_url') }}</label>
                        <input type="url" name="website" value="{{ old('website', $setting->website) }}" 
                               placeholder="https://www.htdc.edu.bd"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.facebook_page_url') }}</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}" 
                               placeholder="https://www.facebook.com/..."
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.youtube_channel_url') }}</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $setting->youtube_url) }}" 
                           placeholder="https://www.youtube.com/..."
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                </div>
            </div>
        </div>

        <!-- About Section Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('admin.about_section') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.about_title') }} (EN)</label>
                        <input type="text" name="about_title" value="{{ old('about_title', $setting->about_title) }}" 
                               placeholder="About Our College"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.about_title') }} (BN)</label>
                        <input type="text" name="about_title_bn" value="{{ old('about_title_bn', $setting->about_title_bn) }}" 
                               placeholder="আমাদের কলেজ সম্পর্কে"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.about_description') }} (EN)</label>
                        <textarea name="about_description" rows="6" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">{{ old('about_description', $setting->about_description) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Provide a detailed description about your institution</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.about_description') }} (BN)</label>
                        <textarea name="about_description_bn" rows="6" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">{{ old('about_description_bn', $setting->about_description_bn) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">প্রতিষ্ঠান সম্পর্কে বিস্তারিত বিবরণ প্রদান করুন</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('admin.about_image') }}</label>
                    
                    <!-- Tab Navigation -->
                    <div class="mb-4 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="imageSelectTabs" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-3 border-b-2 border-[#3dab8c] rounded-t-lg active text-[#3dab8c]" 
                                        id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-select" 
                                        type="button" role="tab" onclick="switchTab('gallery')">
                                    <svg class="w-5 h-5 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('admin.choose_from_gallery') }}
                                </button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-3 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" 
                                        id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-select" 
                                        type="button" role="tab" onclick="switchTab('upload')">
                                    <svg class="w-5 h-5 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    {{ __('admin.upload_new_image') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Current Image Preview (Always Visible) -->
                    @php
                        $currentAboutImageId = old('about_image_id', $setting->about_image_id);
                        $selectedGallery = null;
                        if ($currentAboutImageId) {
                            $selectedGallery = $galleries->firstWhere('id', $currentAboutImageId);
                        }
                    @endphp
                    
                    <div id="currentImagePreview" class="mb-4 {{ !$selectedGallery ? 'hidden' : '' }}">
                        <div class="relative inline-block">
                            <img id="previewImg" src="{{ $selectedGallery ? asset('storage/' . $selectedGallery->image) : '' }}" 
                                 alt="Selected Image" 
                                 class="h-48 object-cover rounded-lg border-2 border-[#3dab8c] shadow-md">
                            <button type="button" onclick="removeSelectedImage()" 
                                    class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-full shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-1">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Image selected: <span id="selectedImageName" class="font-medium">{{ $selectedGallery?->title ?? 'Image #' . $selectedGallery?->id }}</span>
                        </p>
                    </div>
                    
                    <!-- Gallery Selection Content -->
                    <div id="gallery-content" class="block">
                        <button type="button" onclick="openImageSelectorModal()" 
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('admin.select_image_from_gallery_modal') }}
                        </button>
                        <p class="mt-2 text-xs text-gray-500">Choose an existing image from your gallery</p>
                    </div>
                    
                    <!-- Upload Content (Hidden by default) -->
                    <div id="upload-content" class="hidden">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#3dab8c] transition-all">
                            <input type="file" id="aboutImageUpload" name="about_image_upload" accept="image/*" 
                                   class="hidden" onchange="handleFileUpload(event)">
                            <label for="aboutImageUpload" class="cursor-pointer">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium text-[#3dab8c]">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                            </label>
                        </div>
                        <div id="uploadPreview" class="hidden mt-4">
                            <div class="relative inline-block">
                                <img id="uploadedPreview" src="" alt="Upload Preview" 
                                     class="h-40 object-cover rounded-lg border-2 border-gray-300">
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs py-1 px-2 rounded-b-lg">
                                    Preview
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-green-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Image ready to upload
                            </p>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Upload a new image directly to the gallery</p>
                    </div>
                    
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="about_image_id" id="about_image_id" value="{{ $currentAboutImageId ?? '' }}">
                    <input type="hidden" name="new_gallery_image_id" id="new_gallery_image_id" value="">
                </div>
            </div>
        </div>

        <!-- Google Maps Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ __('admin.google_maps_location') }}
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.google_maps_embed_code') }}</label>
                    <textarea name="google_map_embed" rows="4" 
                              placeholder='<iframe src="https://www.google.com/maps/embed?pb=..."></iframe>'
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] font-mono text-sm">{{ old('google_map_embed', $setting->google_map_embed) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">Paste the complete iframe embed code from Google Maps</p>
                </div>
                
                @if($setting->google_map_embed)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.current_map_preview') }}</label>
                    <div class="border rounded-lg overflow-hidden h-64" style="position: relative;">
                        <div style="width: 100%; height: 100%;">{!! $setting->google_map_embed !!}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('admin.settings_status') }}
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $setting->is_active) ? 'checked' : '' }} 
                           class="h-5 w-5 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded">
                    <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                        {{ __('admin.active_show_contact') }}
                    </label>
                </div>
            </div>
        </div>



        <!-- Founder Section Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __('admin.founder_information') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.founder_name') }} (EN)</label>
                        <input type="text" name="founder_name" value="{{ old('founder_name', $setting->founder_name) }}" 
                               placeholder="Enter founder name"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.founder_name') }} (BN)</label>
                        <input type="text" name="founder_name_bn" value="{{ old('founder_name_bn', $setting->founder_name_bn) }}" 
                               placeholder="প্রতিষ্ঠাতার নাম"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.title_designation') }} (EN)</label>
                        <input type="text" name="founder_title" value="{{ old('founder_title', $setting->founder_title) }}" 
                               placeholder="e.g., Founder, Chairman"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.title_designation') }} (BN)</label>
                        <input type="text" name="founder_title_bn" value="{{ old('founder_title_bn', $setting->founder_title_bn) }}" 
                               placeholder="যেমন: প্রতিষ্ঠাতা, চেয়ারম্যান"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message (EN)</label>
                        <textarea name="founder_message" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">{{ old('founder_message', $setting->founder_message) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Founder's message or quote</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message (BN)</label>
                        <textarea name="founder_message_bn" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">{{ old('founder_message_bn', $setting->founder_message_bn) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">প্রতিষ্ঠাতার বার্তা বা উদ্ধৃতি</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.founder_image') }}</label>
                    @error('founder_image')
                        <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                    @enderror
                    <div id="founderImagePreview" class="mb-4 {{ !$setting->founder_image ? 'hidden' : '' }}">
                        <img id="founderPreviewImg" src="{{ $setting->founder_image ? asset('storage/' . $setting->founder_image) : '' }}" 
                             alt="Founder" 
                             class="h-32 object-cover rounded-lg border-2 border-[#3dab8c] shadow-md">
                    </div>
                    <input type="file" name="founder_image" id="founder_image_input" accept="image/*" 
                           onchange="previewFounderImage(event)"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    <p class="mt-2 text-xs text-gray-500">Upload image (JPG, PNG, GIF - Max 2MB). Will be saved in images/founder folder</p>
                </div>
            </div>
        </div>

        <!-- Principal Section Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __('admin.principal_information') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.principal_name') }} (EN)</label>
                        <input type="text" name="principal_name" value="{{ old('principal_name', $setting->principal_name) }}" 
                               placeholder="Enter principal name"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.principal_name') }} (BN)</label>
                        <input type="text" name="principal_name_bn" value="{{ old('principal_name_bn', $setting->principal_name_bn) }}" 
                               placeholder="অধ্যক্ষের নাম"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.title_designation') }} (EN)</label>
                        <input type="text" name="principal_title" value="{{ old('principal_title', $setting->principal_title) }}" 
                               placeholder="e.g., Principal, Professor"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.title_designation') }} (BN)</label>
                        <input type="text" name="principal_title_bn" value="{{ old('principal_title_bn', $setting->principal_title_bn) }}" 
                               placeholder="যেমন: অধ্যক্ষ, অধ্যাপক"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message (EN)</label>
                        <textarea name="principal_message" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">{{ old('principal_message', $setting->principal_message) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Principal's message or quote</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message (BN)</label>
                        <textarea name="principal_message_bn" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">{{ old('principal_message_bn', $setting->principal_message_bn) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">অধ্যক্ষের বার্তা বা উদ্ধৃতি</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.principal_image') }}</label>
                    @error('principal_image')
                        <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                    @enderror
                    <div id="principalImagePreview" class="mb-4 {{ !$setting->principal_image ? 'hidden' : '' }}">
                        <img id="principalPreviewImg" src="{{ $setting->principal_image ? asset('storage/' . $setting->principal_image) : '' }}" 
                             alt="Principal" 
                             class="h-32 object-cover rounded-lg border-2 border-[#3dab8c] shadow-md">
                    </div>
                    <input type="file" name="principal_image" id="principal_image_input" accept="image/*" 
                           onchange="previewPrincipalImage(event)"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                    <p class="mt-2 text-xs text-gray-500">Upload image (JPG, PNG, GIF - Max 2MB). Will be saved in images/principal folder</p>
                </div>
            </div>
        <!-- BOU (Board of Trustees) Section Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ __('admin.board_of_trustees') }}
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.bou_body_title') }} (EN)</label>
                        <input type="text" name="bou_body" value="{{ old('bou_body', $setting->bou_body) }}" 
                               placeholder="e.g., Board of Trustees, Governing Body"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                        <p class="mt-2 text-xs text-gray-500">Main title or designation for the board</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.bou_body_title') }} (BN)</label>
                        <input type="text" name="bou_body_bn" value="{{ old('bou_body_bn', $setting->bou_body_bn) }}" 
                               placeholder="যেমন: পরিচালনা পরিষদ, ট্রাস্টি বোর্ড"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">
                        <p class="mt-2 text-xs text-gray-500">বোর্ডের প্রধান শিরোনাম বা পদবি</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description (EN)</label>
                        <textarea name="bou_description" rows="5" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">{{ old('bou_description', $setting->bou_description) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Detailed information about the Board of Trustees and their role</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description (BN)</label>
                        <textarea name="bou_description_bn" rows="5" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] bn-font">{{ old('bou_description_bn', $setting->bou_description_bn) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">পরিচালনা পরিষদ এবং তাদের ভূমিকা সম্পর্কে বিস্তারিত তথ্য</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.settings.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white rounded-lg hover:from-green-600 hover:to-green-800 font-medium shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                {{ __('admin.save_changes') }}
            </button>
        </div>
    </form>

    <!-- Image Selector Modal -->
    <div id="imageSelectorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full mx-4 my-8">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ __('admin.select_image_from_gallery_modal') }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Choose an image for the About section</p>
                    </div>
                    <button type="button" onclick="closeImageSelectorModal()" 
                            class="text-gray-400 hover:text-gray-600 transition-all p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body - Image Grid -->
                <div class="p-6">
                    @if($galleries->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 max-h-[60vh] overflow-y-auto">
                            @foreach($galleries as $gallery)
                                <div onclick="selectImageFromModal({{ $gallery->id }}, '{{ $gallery->title ?? 'Image #' . $gallery->id }}', '{{ asset('storage/' . $gallery->image) }}')"
                                     class="relative group cursor-pointer rounded-lg overflow-hidden border-2 border-gray-200 hover:border-[#3dab8c] transition-all transform hover:scale-105 shadow-md hover:shadow-xl">
                                    <img src="{{ asset('storage/' . $gallery->image) }}" 
                                         alt="{{ $gallery->title ?? 'Gallery Image' }}" 
                                         class="w-full h-48 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3">
                                        <p class="text-white text-sm font-medium truncate">{{ $gallery->title ?? 'Image #' . $gallery->id }}</p>
                                    </div>
                                    <!-- Checkmark for selected image -->
                                    <div id="checkmark-{{ $gallery->id }}" class="hidden absolute top-2 right-2 bg-[#3dab8c] text-white p-2 rounded-full shadow-lg">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('admin.no_images_in_gallery') }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ __('admin.upload_images_first') }}</p>
                            <a href="{{ route('admin.galleries.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all">
                                {{ __('admin.upload_images') }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    <button type="button" onclick="closeImageSelectorModal()" 
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-all">
                        {{ __('admin.cancel') }}
                    </button>
                    <button type="button" onclick="confirmImageSelection()" 
                            class="px-6 py-2.5 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all shadow-md">
                        Confirm Selection
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let tempSelectedImage = null; // Temporary storage for image being selected

// Switch between Gallery and Upload tabs
function switchTab(tab) {
    if (tab === 'gallery') {
        document.getElementById('gallery-content').classList.remove('hidden');
        document.getElementById('upload-content').classList.add('hidden');
        document.getElementById('gallery-tab').classList.add('border-[#3dab8c]', 'text-[#3dab8c]');
        document.getElementById('gallery-tab').classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
        document.getElementById('upload-tab').classList.remove('border-[#3dab8c]', 'text-[#3dab8c]');
        document.getElementById('upload-tab').classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
    } else {
        document.getElementById('gallery-content').classList.add('hidden');
        document.getElementById('upload-content').classList.remove('hidden');
        document.getElementById('upload-tab').classList.add('border-[#3dab8c]', 'text-[#3dab8c]');
        document.getElementById('upload-tab').classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
        document.getElementById('gallery-tab').classList.remove('border-[#3dab8c]', 'text-[#3dab8c]');
        document.getElementById('gallery-tab').classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
    }
}

// Handle File Upload
function handleFileUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a valid image file (JPG, PNG, or GIF)');
        return;
    }
    
    // Validate file size (5MB max)
    if (file.size > 5 * 1024 * 1024) {
        alert('File size must be less than 5MB');
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('uploadedPreview').src = e.target.result;
        document.getElementById('uploadPreview').classList.remove('hidden');
        
        // Store the file for upload
        window.uploadedImageFile = file;
    };
    reader.readAsDataURL(file);
}

// Open Image Selector Modal
function openImageSelectorModal() {
    document.getElementById('imageSelectorModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
    
    // Highlight currently selected image in modal
    const currentId = document.getElementById('about_image_id').value;
    if (currentId) {
        selectImageFromModal(parseInt(currentId), '', '');
    }
}

// Close Image Selector Modal
function closeImageSelectorModal() {
    document.getElementById('imageSelectorModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    tempSelectedImage = null;
}

// Select Image from Modal
function selectImageFromModal(galleryId, title, imageUrl) {
    // Remove checkmark from all images
    document.querySelectorAll('[id^="checkmark-"]').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Add checkmark to selected image
    const checkmark = document.getElementById(`checkmark-${galleryId}`);
    if (checkmark) {
        checkmark.classList.remove('hidden');
    }
    
    // Store temporary selection
    tempSelectedImage = {
        id: galleryId,
        title: title,
        url: imageUrl
    };
}

// Confirm Image Selection
function confirmImageSelection() {
    if (!tempSelectedImage) {
        alert('Please select an image first');
        return;
    }
    
    // Update hidden input with gallery ID
    document.getElementById('about_image_id').value = tempSelectedImage.id;
    document.getElementById('new_gallery_image_id').value = ''; // Clear any new upload ID
    
    // Update preview
    document.getElementById('previewImg').src = tempSelectedImage.url;
    document.getElementById('selectedImageName').textContent = tempSelectedImage.title || `Image #${tempSelectedImage.id}`;
    document.getElementById('currentImagePreview').classList.remove('hidden');
    
    // Switch to gallery tab
    switchTab('gallery');
    
    // Close modal
    closeImageSelectorModal();
}

// Remove Selected Image
function removeSelectedImage() {
    if (confirm('Are you sure you want to remove the selected image?')) {
        document.getElementById('about_image_id').value = '';
        document.getElementById('new_gallery_image_id').value = '';
        document.getElementById('currentImagePreview').classList.add('hidden');
        document.getElementById('previewImg').src = '';
        document.getElementById('selectedImageName').textContent = '';
        
        // Clear any selections in modal
        document.querySelectorAll('[id^="checkmark-"]').forEach(el => {
            el.classList.add('hidden');
        });
        tempSelectedImage = null;
        
        // Clear upload if any
        document.getElementById('aboutImageUpload').value = '';
        document.getElementById('uploadPreview').classList.add('hidden');
        window.uploadedImageFile = null;
    }
}

// Close modal when clicking outside
document.getElementById('imageSelectorModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageSelectorModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('imageSelectorModal').classList.contains('hidden')) {
        closeImageSelectorModal();
    }
});

// Preview Founder Image
function previewFounderImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('founderPreviewImg').src = e.target.result;
            document.getElementById('founderImagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Preview Principal Image
function previewPrincipalImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('principalPreviewImg').src = e.target.result;
            document.getElementById('principalImagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Form submission handler to upload image if exists
document.querySelector('form').addEventListener('submit', async function(e) {
    const fileInput = document.getElementById('aboutImageUpload');
    const file = window.uploadedImageFile;
    
    // Only prevent default if there's a file to upload
    if (file) {
        e.preventDefault();
        
        // Create FormData
        const formData = new FormData();
        formData.append('image', file);
        formData.append('title', 'About Section Image');
        
        try {
            // Upload to gallery first
            const response = await fetch('{{ route("admin.galleries.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });
            
            if (response.ok) {
                const result = await response.json();
                // Set the new gallery image ID
                document.getElementById('new_gallery_image_id').value = result.galleryId;
                document.getElementById('about_image_id').value = result.galleryId;
                
                // Submit form after successful upload
                this.submit();
            } else {
                alert('Failed to upload image. Please try again.');
            }
        } catch (error) {
            console.error('Upload error:', error);
            alert('An error occurred while uploading the image.');
        }
    }
    // If no file, form will submit normally with all founder/principal data
});
</script>
@endsection
