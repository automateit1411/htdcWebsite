@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('admin.page_settings') }} <span class="text-[#3dab8c]">{{ $custom_page->page_name }}</span></h1>
            <p class="text-gray-500 mt-1">Manage the content and design of this page.</p>
        </div>
        <a href="{{ route('admin.custom-pages.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all font-medium shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('admin.back_to_list') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-[#3dab8c] text-[#0d3a37] rounded-r-xl shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.custom-pages.update-settings', $custom_page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Main Content Card (About Style) -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 transition-all hover:shadow-2xl">
            <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('admin.edit_page_content') }}
                </h2>
                <p class="text-green-100 text-sm mt-1">{{ __('admin.about_section_template') }}</p>
            </div>
            
            <div class="p-8 space-y-8">
                <!-- Display Title -->
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.display_title') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $custom_page->title) }}" placeholder="Enter the main title for this page..."
                        class="w-full px-5 py-4 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none text-xl font-semibold text-gray-800">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Display Title (Bangla) -->
                <div class="space-y-2">
                    <label for="title_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.display_title_bn') }}</label>
                    <input type="text" name="title_bn" id="title_bn" value="{{ old('title_bn', $custom_page->title_bn) }}" placeholder="বাংলায় পৃষ্ঠার শিরোনাম..."
                        class="w-full px-5 py-4 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none text-xl font-semibold text-gray-800 bn-font">
                    @error('title_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.main_description_story') }}</label>
                    <textarea name="description" id="description" rows="12" placeholder="Tell the story of this page..."
                        class="w-full px-5 py-4 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none text-gray-700 leading-relaxed text-lg">{{ old('description', $custom_page->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description (Bangla) -->
                <div class="space-y-2">
                    <label for="description_bn" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.main_description_story_bn') }}</label>
                    <textarea name="description_bn" id="description_bn" rows="12" placeholder="বাংলায় এই পৃষ্ঠার বিস্তারিত বিষয়বস্তু লিখুন..."
                        class="w-full px-5 py-4 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition duration-200 outline-none text-gray-700 leading-relaxed text-lg bn-font">{{ old('description_bn', $custom_page->description_bn) }}</textarea>
                    @error('description_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Media Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Feature Image with Gallery Option -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.feature_image') }}</label>
                        <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-6 transition-all hover:border-[#3dab8c] bg-gray-50">
                            <!-- Hidden input for file upload -->
                            <input type="file" name="image" id="image_upload" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <!-- Hidden input for gallery selection -->
                            <input type="hidden" name="gallery_image_path" id="gallery_image_path">
                            
                            <div id="imagePreview" class="mb-4 {{ $custom_page->image_path ? '' : 'hidden' }}">
                                <img id="previewImg" src="{{ $custom_page->image_path ? asset('storage/' . $custom_page->image_path) : '' }}" class="w-full h-48 object-cover rounded-xl shadow-lg border-4 border-white">
                            </div>

                            <div class="flex flex-col gap-3">
                                <button type="button" onclick="document.getElementById('image_upload').click()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-all font-medium shadow-sm">
                                    <svg class="w-5 h-5 text-[#3dab8c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    {{ __('admin.upload_from_computer') }}
                                </button>
                                <button type="button" onclick="openGalleryModal()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#0d3a37] text-white rounded-xl hover:bg-[#092a28] transition-all font-medium shadow-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('admin.select_from_gallery') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Attachment File -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">{{ __('admin.attachment_pdf_document') }}</label>
                        <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gray-50 h-full flex flex-col justify-center items-center text-center group hover:border-[#3dab8c] transition-all">
                            <input type="file" name="file" id="file_upload" class="hidden" onchange="updateFileName(event)">
                            <label for="file_upload" class="cursor-pointer flex flex-col items-center">
                                @if($custom_page->file_path)
                                    <div class="mb-4 p-3 bg-white rounded-lg shadow-sm border border-gray-100 flex items-center gap-2 text-xs text-[#3dab8c] font-bold">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ basename($custom_page->file_path) }}
                                    </div>
                                @endif
                                <div class="p-4 bg-white rounded-full shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-[#3dab8c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p id="fileNameDisplay" class="mt-4 text-sm text-gray-600 font-medium group-hover:text-[#3dab8c]">{{ __('admin.click_to_change_file') }}</p>
                                <p class="text-[10px] text-gray-400 uppercase mt-1">PDF, DOC, DOCX up to 10MB</p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="flex items-center justify-between p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="text-sm text-gray-500 italic">
                * Other settings (Category, Route) are managed in the <a href="{{ route('admin.custom-pages.index') }}" class="text-[#3dab8c] font-bold hover:underline">Page List</a>.
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white rounded-xl hover:from-green-600 hover:to-green-800 font-bold shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    {{ __('admin.save_page_content') }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Gallery Selector Modal -->
<div id="galleryModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[999] hidden overflow-y-auto animate-fade-in">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="bg-white rounded-3xl shadow-2xl max-w-5xl w-full mx-auto overflow-hidden animate-scale-up">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ __('admin.select_image_from_gallery_modal') }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Choose a professional image for your page.</p>
                </div>
                <button type="button" onclick="closeGalleryModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-full transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                @if($galleries->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($galleries as $gallery)
                            <div onclick="selectFromGallery('{{ asset('storage/' . $gallery->image) }}', {{ $gallery->id }})" 
                                 class="gallery-item relative group cursor-pointer rounded-2xl overflow-hidden border-2 border-transparent hover:border-[#3dab8c] transition-all"
                                 id="gallery-item-{{ $gallery->id }}">
                                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-40 object-cover transform transition-transform group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 bg-[#3dab8c] text-white p-2 rounded-full shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="mb-4 inline-flex p-6 bg-gray-50 rounded-full text-gray-300">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700">{{ __('admin.gallery_empty') }}</h3>
                        <p class="text-gray-500 mt-2">{{ __('admin.upload_images_first') }}</p>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 rounded-b-3xl">
                <button type="button" onclick="closeGalleryModal()" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition-all">
                    {{ __('admin.cancel') }}
                </button>
                <button type="button" onclick="confirmGallerySelection()" class="px-6 py-2.5 bg-[#3dab8c] text-white font-bold rounded-xl hover:bg-green-600 transition-all shadow-md">
                    {{ __('admin.apply_selected_image_btn') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes scale-up {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .animate-fade-in-down { animation: fade-in-down 0.4s ease-out; }
    .animate-fade-in { animation: fade-in 0.3s ease-out; }
    .animate-scale-up { animation: scale-up 0.3s ease-out; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #3dab8c; border-radius: 10px; }
</style>

<script>
    let selectedGalleryPath = null;

    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('gallery_image_path').value = ''; // Clear gallery path if uploading new
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateFileName(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            document.getElementById('fileNameDisplay').textContent = input.files[0].name;
            document.getElementById('fileNameDisplay').classList.add('text-[#3dab8c]', 'font-bold');
        }
    }

    function openGalleryModal() {
        document.getElementById('galleryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeGalleryModal() {
        document.getElementById('galleryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function selectFromGallery(path, id) {
        selectedGalleryPath = path;
        // Remove active class from all
        document.querySelectorAll('.gallery-item').forEach(el => el.classList.remove('border-[#3dab8c]', 'ring-4', 'ring-[#3dab8c]/20'));
        // Add to selected
        document.getElementById('gallery-item-' + id).classList.add('border-[#3dab8c]', 'ring-4', 'ring-[#3dab8c]/20');
    }

    function confirmGallerySelection() {
        if (selectedGalleryPath) {
            document.getElementById('previewImg').src = selectedGalleryPath;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('gallery_image_path').value = selectedGalleryPath;
            document.getElementById('image_upload').value = ''; // Clear file upload if gallery selected
            closeGalleryModal();
        }
    }
</script>
@endsection
