@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Slider</h1>
            <p class="text-gray-600 mt-1">Update slider settings</p>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
            <!-- Gallery Image Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Gallery Image *</label>
                
                <!-- Selected Image Preview -->
                <div id="selectedImagePreview" {{ !$slider->image_id ? 'class=hidden' : '' }} class="mb-4">
                    <img id="previewImg" src="{{ $slider->image_id ? asset('storage/' . $slider->image->image) : '' }}" 
                         alt="Selected Image" 
                         class="h-48 object-cover rounded-lg border-2 border-[#3dab8c] shadow-md">
                    <p class="mt-2 text-sm text-gray-600 flex items-center gap-1">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Image selected: <span id="selectedImageName" class="font-medium">{{ $slider->image ? $slider->image->title : '' }}</span>
                    </p>
                </div>
                
                <!-- Select Image Button -->
                <button type="button" onclick="openImageSelectorModal()" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Change Image from Gallery
                </button>
                
                <input type="hidden" name="image_id" id="image_id" value="{{ old('image_id', $slider->image_id) }}">
                @error('image_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Click button to choose a different image from your gallery</p>
            </div>

            <!-- Slider Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slider Title</label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}" 
                       placeholder="Enter slider title (optional)"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">This will be displayed over the slider image. Leave empty to use gallery image title.</p>
            </div>

            <!-- Order -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                <input type="number" name="order" value="{{ old('order', $slider->order) }}" min="0" 
                       placeholder="0"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c]">
                @error('order')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Lower numbers appear first. Current: {{ $slider->order }}</p>
            </div>

            <!-- Active Status -->
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded">
                <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                <p class="text-xs text-gray-500">Check to display this slider on the homepage</p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.sliders.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all shadow-md">
                Update Slider
            </button>
        </div>
    </form>
</div>

<!-- Image Selector Modal -->
<div id="imageSelectorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto" onclick="if(event.target === this) closeImageSelectorModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full mx-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-2xl font-bold text-gray-800">Select Gallery Image</h3>
                <button onclick="closeImageSelectorModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body - Image Grid -->
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 max-h-96 overflow-y-auto">
                    @foreach($galleries as $gallery)
                        <div onclick="selectImage({{ $gallery->id }}, '{{ addslashes($gallery->title ?? 'Image #' . $gallery->id) }}', '{{ asset('storage/' . $gallery->image) }}')"
                             class="cursor-pointer relative group border-2 rounded-lg overflow-hidden hover:border-[#3dab8c] transition-all"
                             id="gallery-card-{{ $gallery->id }}">
                            <img src="{{ asset('storage/' . $gallery->image) }}" 
                                 alt="{{ $gallery->title ?? 'Image' }}" 
                                 class="w-full h-40 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                <span class="text-white opacity-0 group-hover:opacity-100 font-medium">Click to Select</span>
                            </div>
                            <!-- Checkmark for selected image -->
                            <div class="absolute top-2 right-2 hidden" id="checkmark-{{ $gallery->id }}">
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 border-t flex justify-end gap-3">
                <button type="button" onclick="closeImageSelectorModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                    Cancel
                </button>
                <button type="button" onclick="confirmImageSelection()" 
                        class="px-4 py-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all shadow-md">
                    Confirm Selection
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
let tempSelectedImage = null;

// Open Image Selector Modal
function openImageSelectorModal() {
    console.log('Opening modal...');
    document.getElementById('imageSelectorModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close Image Selector Modal
function closeImageSelectorModal() {
    document.getElementById('imageSelectorModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    tempSelectedImage = null;
}

// Select Image from Modal
function selectImage(galleryId, title, imageUrl) {
    // Remove checkmark from all images
    document.querySelectorAll('[id^="checkmark-"]').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Remove border highlight from all cards
    document.querySelectorAll('[id^="gallery-card-"]').forEach(el => {
        el.classList.remove('border-[#3dab8c]', 'border-4');
        el.classList.add('border-2');
    });
    
    // Add checkmark to selected image
    const checkmark = document.getElementById(`checkmark-${galleryId}`);
    if (checkmark) {
        checkmark.classList.remove('hidden');
    }
    
    // Add border highlight to selected card
    const card = document.getElementById(`gallery-card-${galleryId}`);
    if (card) {
        card.classList.remove('border-2');
        card.classList.add('border-[#3dab8c]', 'border-4');
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
    document.getElementById('image_id').value = tempSelectedImage.id;
    
    // Update preview
    document.getElementById('previewImg').src = tempSelectedImage.url;
    document.getElementById('selectedImageName').textContent = tempSelectedImage.title;
    document.getElementById('selectedImagePreview').classList.remove('hidden');
    
    // Close modal
    closeImageSelectorModal();
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('imageSelectorModal').classList.contains('hidden')) {
        closeImageSelectorModal();
    }
});
</script>
