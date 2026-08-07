@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.create_new_page') }}</h1>
        <a href="{{ route('admin.custom-pages.index') }}" class="text-gray-500 hover:text-gray-700 font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('admin.back_to_list') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.custom-pages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Page Name -->
                <div class="space-y-1">
                    <label for="page_name" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.page_name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="page_name" id="page_name" required value="{{ old('page_name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('page_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Page Name (Bangla) -->
                <div class="space-y-1">
                    <label for="page_name_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.page_name_bn') }}</label>
                    <input type="text" name="page_name_bn" id="page_name_bn" value="{{ old('page_name_bn') }}" placeholder="বাংলায় পৃষ্ঠার নাম"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('page_name_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Title -->
                <div class="space-y-1">
                    <label for="title" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.display_title') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g. Welcome to Our College"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Title (Bangla) -->
                <div class="space-y-1">
                    <label for="title_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.display_title_bn') }}</label>
                    <input type="text" name="title_bn" id="title_bn" value="{{ old('title_bn') }}" placeholder="বাংলায় শিরোনাম"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('title_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div class="space-y-1">
                    <label for="category" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.category') }}</label>
                    <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="e.g. Academic" list="category_list"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    <datalist id="category_list">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category (Bangla) -->
                <div class="space-y-1">
                    <label for="category_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.category_bn') }}</label>
                    <input type="text" name="category_bn" id="category_bn" value="{{ old('category_bn') }}" placeholder="বাংলায় ক্যাটাগরি"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('category_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Subcategory -->
                <div class="space-y-1">
                    <label for="subcategory" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.subcategory') }}</label>
                    <input type="text" name="subcategory" id="subcategory" value="{{ old('subcategory') }}" placeholder="e.g. Admission" list="subcategory_list"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    <datalist id="subcategory_list">
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub }}">
                        @endforeach
                    </datalist>
                    @error('subcategory') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Subcategory (Bangla) -->
                <div class="space-y-1">
                    <label for="subcategory_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.subcategory_bn') }}</label>
                    <input type="text" name="subcategory_bn" id="subcategory_bn" value="{{ old('subcategory_bn') }}" placeholder="বাংলায় সাবক্যাটাগরি"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('subcategory_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="space-y-1">
                    <label for="status" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.status') }}</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>{{ __('admin.active') }}</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('admin.inactive') }}</option>
                    </select>
                </div>

                <!-- Route -->
                <div class="space-y-1">
                    <label for="route" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.custom_route_optional') }}</label>
                    <input type="text" name="route" id="route" value="{{ old('route') }}" placeholder="/admission-policy"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none">
                    @error('route') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Media Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                <!-- Image Upload (About Section Style) -->
                <div class="space-y-2">
                    <label for="image" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.feature_image') }}</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-[#3dab8c] transition-all bg-gray-50">
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        <label for="image" class="cursor-pointer block">
                            <div id="imagePreview" class="hidden mb-3">
                                <img id="previewImg" src="" class="mx-auto h-32 object-cover rounded-lg shadow-sm">
                            </div>
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-1 text-sm text-gray-600 font-medium">{{ __('admin.click_to_upload_image') }}</p>
                            <p class="text-[10px] text-gray-400 uppercase">JPG, PNG, WEBP up to 5MB</p>
                        </label>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- File Attachment (Notice Style) -->
                <div class="space-y-2">
                    <label for="file" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.attachment_pdf_docs') }}</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-[#3dab8c] transition-all bg-gray-50 h-full flex flex-col justify-center">
                        <input type="file" name="file" id="file" class="hidden" onchange="updateFileName(event)">
                        <label for="file" class="cursor-pointer block">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p id="fileName" class="mt-1 text-sm text-gray-600 font-medium">{{ __('admin.click_to_upload_file') }}</p>
                            <p class="text-[10px] text-gray-400 uppercase">PDF, PNG, JPG up to 10MB</p>
                        </label>
                    </div>
                    @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-1">
                <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.main_content_description') }}</label>
                <textarea name="description" id="description" rows="8" placeholder="Enter the detailed content for this page..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none leading-relaxed">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Description (Bangla) -->
            <div class="space-y-1">
                <label for="description_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Main Content / Description (বাংলা)</label>
                <textarea name="description_bn" id="description_bn" rows="8" placeholder="বাংলায় এই পৃষ্ঠার বিস্তারিত বিষয়বস্তু লিখুন..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none leading-relaxed bn-font">{{ old('description_bn') }}</textarea>
                @error('description_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hidden Fields with Defaults -->
            <input type="hidden" name="status" value="1">

            <script>
                function previewImage(event) {
                    const input = event.target;
                    const preview = document.getElementById('imagePreview');
                    const previewImg = document.getElementById('previewImg');
                    const icon = document.getElementById('imageUploadIcon');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            preview.classList.remove('hidden');
                            icon.classList.add('hidden');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function updateFileName(event) {
                    const input = event.target;
                    const label = document.getElementById('fileName');
                    if (input.files && input.files[0]) {
                        label.textContent = input.files[0].name;
                        label.classList.add('text-[#3dab8c]', 'font-bold');
                    }
                }
            </script>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-[#3dab8c] hover:bg-[#0d3a37] text-white font-bold py-3 px-10 rounded-lg transition duration-300 shadow-md">
                    {{ __('admin.create_page') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
