@extends('admin.layouts.app')

@section('title', 'Add Size')
@section('page-title', 'Add New Size')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center">
            <a href="{{ route('admin.sizes.index') }}"
               class="inline-flex items-center text-gray-600 hover:text-brown transition-colors duration-300">
               <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Back to Sizes') }}
            </a>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">{{ __('Add New Size') }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ __('Create a new size with multilingual support') }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.sizes.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Size Name') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('name_en') border-red-500 @enderror"
                       placeholder="{{ __('Enter size name (e.g., Small, Medium, Large)') }}" required>
                @error('name_en')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Sort Order') }}
                </label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('sort_order') border-red-500 @enderror"
                       placeholder="0" min="0">
                @error('sort_order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-600 mt-1">{{ __('Lower numbers appear first in lists') }}</p>
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
                <a href="{{ route('admin.sizes.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-brown rounded-lg hover:bg-brown-hover transition duration-300">
                    {{ __('Create Size') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection








