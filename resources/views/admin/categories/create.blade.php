@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name_en" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Category Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('name_en') border-red-500 @enderror"
                           placeholder="{{ __('Enter category name') }}">
                    @error('name_en')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description_en" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Description') }}
                    </label>
                    <textarea id="description_en" name="description_en" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('description_en') border-red-500 @enderror"
                              placeholder="{{ __('Enter category description') }}">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Background Image Upload -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Hero Background Image') }} <span class="text-gray-500 font-normal">({{ __('Optional') }})</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-3">
                        {{ __('This image will be displayed as the background in the category hero section on the frontend. Recommended size: 1920x600px or larger.') }}
                    </p>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brown transition duration-300">
                        <input type="file" id="image" name="image" accept="image/*"
                               class="hidden" onchange="previewImage(this)">
                        <label for="image" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">{{ __('Click to upload background image') }}</p>
                            <p class="text-sm text-gray-500">{{ __('PNG, JPG, GIF, WebP up to 2MB') }}</p>
                        </label>
                    </div>
                    <div id="image-preview" class="hidden mt-4">
                        <p class="text-sm text-gray-600 mb-2">{{ __('Preview:') }}</p>
                        <img id="preview-img" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Sort Order') }}
                    </label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('sort_order') border-red-500 @enderror">
                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        {{ __('Active (visible to customers)') }}
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} mt-8">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-brown text-white rounded-lg hover:bg-brown-darker transition duration-300">
                    <i class="fas fa-save {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                    {{ __('Create Category') }}
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









