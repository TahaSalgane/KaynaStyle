@extends('admin.layouts.app')

@section('title', 'Add Color')
@section('page-title', 'Add New Color')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <a href="{{ route('admin.colors.index') }}"
               class="inline-flex items-center text-gray-600 hover:text-brown transition-colors duration-300">
                <i class="fas fa-arrow-left {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('Back to Colors') }}
            </a>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">{{ __('Add New Color') }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ __('Create a new color with multilingual support') }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.colors.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Color Preview -->
            <div class="text-center">
                <div class="w-24 h-24 rounded-full border-4 border-gray-200 shadow-lg mx-auto mb-4"
                     id="colorPreview" style="background-color: #000000;"></div>
                <p class="text-sm text-gray-600">{{ __('Color Preview') }}</p>
            </div>

            <!-- Name -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Color Name') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('name_en') border-red-500 @enderror"
                       placeholder="{{ __('Enter color name') }}" required>
                @error('name_en')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hex Code -->
            <div>
                <label for="hex_code" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Hex Code') }} <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="color" id="colorPicker"
                           class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 border border-gray-300 rounded cursor-pointer">
                    <input type="text" id="hex_code" name="hex_code" value="{{ old('hex_code', '#000000') }}"
                           class="w-full px-3 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('hex_code') border-red-500 @enderror"
                           placeholder="#000000" pattern="^#[0-9A-Fa-f]{6}$" required>
                </div>
                @error('hex_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-600 mt-1">{{ __('Enter a valid hex color code (e.g., #FF5733)') }}</p>
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                    {{ __('Active') }}
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.colors.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-brown rounded-lg hover:bg-brown-hover transition duration-300">
                    {{ __('Create Color') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('colorPicker');
    const hexInput = document.getElementById('hex_code');
    const colorPreview = document.getElementById('colorPreview');

    // Update color picker when hex input changes
    hexInput.addEventListener('input', function() {
        const hex = this.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
            colorPicker.value = hex;
            colorPreview.style.backgroundColor = hex;
        }
    });

    // Update hex input when color picker changes
    colorPicker.addEventListener('input', function() {
        hexInput.value = this.value;
        colorPreview.style.backgroundColor = this.value;
    });

    // Initialize color preview
    colorPreview.style.backgroundColor = hexInput.value;
    colorPicker.value = hexInput.value;
});
</script>
@endsection








