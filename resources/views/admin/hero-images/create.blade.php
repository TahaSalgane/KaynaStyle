@extends('admin.layouts.app')

@section('title', 'Create Hero Image')
@section('page-title', 'Create Hero Image')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.hero-images.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Image') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brown transition duration-300">
                        <input type="file" id="image" name="image" accept="image/*" required
                               class="hidden" onchange="previewImage(this)">
                        <label for="image" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">{{ __('Click to upload image') }}</p>
                            <p class="text-sm text-gray-500">{{ __('PNG, JPG, GIF, WebP up to 2MB') }}</p>
                        </label>
                    </div>
                    <div id="image-preview" class="hidden mt-4">
                        <img id="preview-img" class="w-full h-48 object-cover rounded-lg">
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Display Order') }}
                    </label>
                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        {{ __('Active (visible on homepage)') }}
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} mt-8">
                <a href="{{ route('admin.hero-images.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-brown text-white rounded-lg hover:bg-brown-darker transition duration-300">
                    <i class="fas fa-save {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                    {{ __('Create Image') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection









