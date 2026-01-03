@extends('admin.layouts.app')

@section('title', 'Edit Hero Image')
@section('page-title', 'Edit Hero Image')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 lg:p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Edit Hero Image') }}</h2>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.hero-images.update', $heroImage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Current Image Preview -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Current Image') }}
                    </label>
                    <div class="relative w-full h-64 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $heroImage->image_path) }}"
                             alt="Hero Image"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://via.placeholder.com/800x400/cccccc/666666?text=Image+Not+Found';">
                    </div>
                </div>

                <!-- New Image (Optional) -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('New Image') }} ({{ __('Leave empty to keep current image') }})
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-2">{{ __('Max file size: 2MB. Allowed formats: JPEG, PNG, JPG, GIF, WebP') }}</p>
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Display Order') }}
                    </label>
                    <input type="number" id="order" name="order" value="{{ old('order', $heroImage->order) }}" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', $heroImage->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        {{ __('Active (visible on homepage)') }}
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.hero-images.index') }}"
                   class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-brown text-white rounded-lg hover:bg-brown-darker transition duration-300">
                    {{ __('Update Hero Image') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

