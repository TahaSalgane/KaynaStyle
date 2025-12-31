@extends('admin.layouts.app')

@section('title', 'Create Product')
@section('page-title', 'Create Product')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-4 lg:mb-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center text-gray-600 hover:text-brown transition-colors duration-300 text-sm lg:text-base">
                <i class="fas fa-arrow-left {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('Back to Products') }}
            </a>
        </div>
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mt-3 lg:mt-4">{{ __('Create New Product') }}</h1>
        <p class="mt-1 text-xs lg:text-sm text-gray-600">{{ __('Add a new product with multilingual support') }}</p>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6 lg:space-y-8">
        @csrf

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 mb-4 lg:mb-6">{{ __('Basic Information') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <!-- English Name -->
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('English Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('name_en') border-red-500 @enderror"
                           placeholder="{{ __('Enter product name in English') }}">
                    @error('name_en')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arabic Name -->
                <div>
                    <label for="name_ar" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Arabic Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('name_ar') border-red-500 @enderror"
                           placeholder="{{ __('Enter product name in Arabic') }}">
                    @error('name_ar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- English Description -->
                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('English Description') }}
                    </label>
                    <textarea id="description_en" name="description_en" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('description_en') border-red-500 @enderror"
                              placeholder="{{ __('Enter product description in English') }}">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arabic Description -->
                <div>
                    <label for="description_ar" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Arabic Description') }}
                    </label>
                    <textarea id="description_ar" name="description_ar" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('description_ar') border-red-500 @enderror"
                              placeholder="{{ __('Enter product description in Arabic') }}">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing & Inventory -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 mb-4 lg:mb-6">{{ __('Pricing & Inventory') }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Price') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('price') border-red-500 @enderror"
                           placeholder="0.00">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sale Price -->
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Sale Price') }}
                    </label>
                    <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('sale_price') border-red-500 @enderror"
                           placeholder="0.00">
                    @error('sale_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Countdown Sale -->
                <div class="lg:col-span-2">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <input type="checkbox" id="is_countdown_sale" name="is_countdown_sale" value="1"
                                   {{ old('is_countdown_sale') ? 'checked' : '' }}
                                   class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                            <label for="is_countdown_sale" class="ml-2 text-sm font-medium text-gray-700">
                                {{ __('Enable Countdown Sale') }}
                            </label>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">
                            {{ __('Enable this to show a countdown timer for the sale, creating urgency for customers.') }}
                        </p>
                        <div id="countdown-fields" class="space-y-3" style="display: {{ old('is_countdown_sale') ? 'block' : 'none' }};">
                            <div>
                                <label for="sale_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Sale End Date & Time') }}
                                </label>
                                <input type="datetime-local" id="sale_end_date" name="sale_end_date"
                                       value="{{ old('sale_end_date') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('sale_end_date') border-red-500 @enderror">
                                @error('sale_end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Stock Quantity') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('stock_quantity') border-red-500 @enderror"
                           placeholder="0">
                    @error('stock_quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Category & SKU -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Category & SKU') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Category') }} <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('SKU') }}
                    </label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('sku') border-red-500 @enderror"
                           placeholder="{{ __('Product SKU') }}">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sizes -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 mb-4 lg:mb-6">{{ __('Available Sizes') }}</h2>

            <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
                @forelse($sizes as $size)
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                               {{ in_array($size->id, old('sizes', [])) ? 'checked' : '' }}
                               class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                        <div class="w-8 h-8 bg-brown-light rounded-full flex items-center justify-center">
                            <span class="text-sm font-semibold text-brown">{{ $size->name }}</span>
                        </div>
                        <span class="text-sm text-gray-700">{{ $size->name }}</span>
                    </label>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">{{ __('No sizes available') }}</p>
                    <a href="{{ route('admin.sizes.create') }}"
                       class="text-sm text-brown hover:text-brown-hover">{{ __('Add sizes first') }}</a>
                @endforelse
            </div>
            @error('sizes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Product Main Settings -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 mb-4 lg:mb-6">{{ __('Product Main Settings') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <!-- Default Color -->
                <div>
                    <label for="default_color_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Default Color') }}
                    </label>
                    <select id="default_color_id" name="default_color_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                        <option value="">{{ __('No default color') }}</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name_en }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">{{ __('This color will be shown first on the product page and its main image will be used as the product main image') }}</p>
                </div>
            </div>
        </div>

        <!-- Color-Based Images -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 mb-4 lg:mb-6">{{ __('Product Images by Color') }}</h2>

            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">{{ __('Upload images for each color (optional). The first image for each color will be the main image for that color.') }}</p>

                <!-- Color Image Upload Sections -->
                <div id="color-images-container">
                    <!-- Color image sections will be added here dynamically -->
                </div>

                <!-- Add Color Section Button -->
                <button type="button" id="add-color-section"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Add Color Images') }}
                </button>
            </div>

            @error('color_images')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-900 mb-4 lg:mb-6">{{ __('Product Settings') }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Sort Order') }}
                    </label>
                    <input type="number" id="product_sort_order" name="product_sort_order" value="{{ old('product_sort_order', 0) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('product_sort_order') border-red-500 @enderror"
                           placeholder="0">
                    @error('product_sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                           {{ old('is_featured') ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                        {{ __('Featured Product') }}
                    </label>
                </div>

                <!-- Active -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        {{ __('Active') }}
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4 lg:pt-6">
            <a href="{{ route('admin.products.index') }}"
               class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300 text-center">
                {{ __('Cancel') }}
            </a>
            <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-brown rounded-lg hover:bg-brown-hover transition duration-300"
                    onclick="console.log('Submit button clicked')">
                {{ __('Create Product') }}
            </button>
        </div>
    </form>
</div>

<!-- Color-Based Image Upload JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorImagesContainer = document.getElementById('color-images-container');
    const addColorSectionBtn = document.getElementById('add-color-section');
    let colorSectionCount = 0;

    // Available colors from the form
    const availableColors = @json($colors->toArray());

    // Add color section button click
    addColorSectionBtn.addEventListener('click', function() {
        addColorSection();
    });

    function addColorSection() {
        const sectionId = `color-section-${colorSectionCount}`;
        const section = document.createElement('div');
        section.id = sectionId;
        section.className = 'border border-gray-200 rounded-lg p-4 mb-4';

        section.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-semibold text-gray-700">{{ __('Color Images') }}</h4>
                <button type="button" onclick="removeColorSection('${sectionId}')"
                        class="text-red-500 hover:text-red-700 text-sm">
                    <i class="fas fa-trash"></i> {{ __('Remove') }}
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Color Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Select Color') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="color_images[${colorSectionCount}][color_id]" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                        <option value="">{{ __('Choose a color') }}</option>
                        ${availableColors.map(color => `
                            <option value="${color.id}">${color.name_en}</option>
                        `).join('')}
                    </select>
                </div>

                <!-- Quantity for this Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Quantity') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="color_quantities[${colorSectionCount}][quantity]"
                           min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                           placeholder="0">
                </div>

                <!-- Main Image Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Main Image Index') }}
                    </label>
                    <select name="main_images[${colorSectionCount}]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                        <option value="0">{{ __('First image (default)') }}</option>
                    </select>
                </div>
            </div>

            <!-- Image Upload Area -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Upload Images') }}
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-brown transition-colors cursor-pointer"
                     onclick="document.getElementById('color-images-${colorSectionCount}').click()">
                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-2">{{ __('Click to select images') }}</p>
                    <p class="text-xs text-gray-500">{{ __('Recommended: 1080x1620 pixels (2:3 ratio)') }}</p>
                    <input type="file" id="color-images-${colorSectionCount}"
                           name="color_images[${colorSectionCount}][images][]"
                           multiple accept="image/*" class="hidden"
                           onchange="handleColorImages(this, ${colorSectionCount})">
                </div>

                <!-- Image Previews -->
                <div id="color-preview-${colorSectionCount}" class="mt-4 hidden">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('Image Previews') }}</h5>
                    <div id="color-preview-list-${colorSectionCount}" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <!-- Images will be added here -->
                    </div>
                </div>
            </div>
        `;

        colorImagesContainer.appendChild(section);
        colorSectionCount++;
    }

    // Global function to remove color section
    window.removeColorSection = function(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.remove();
        }
    };

    // Global function to handle color images
    window.handleColorImages = function(input, sectionIndex) {
        const files = Array.from(input.files);
        const previewContainer = document.getElementById(`color-preview-${sectionIndex}`);
        const previewList = document.getElementById(`color-preview-list-${sectionIndex}`);
        const mainImageSelect = input.closest('.border').querySelector('select[name*="main_images"]');

        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            return;
        }

        // Filter only image files
        const imageFiles = files.filter(file => file.type.startsWith('image/'));

        if (imageFiles.length === 0) {
            alert('Please select only image files.');
            return;
        }

        // Show preview container
        previewContainer.classList.remove('hidden');
        previewList.innerHTML = '';

        // Update main image select options
        mainImageSelect.innerHTML = '';
        for (let i = 0; i < imageFiles.length; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i === 0 ? '{{ __("First image (default)") }}' : `{{ __("Image") }} #${i + 1}`;
            mainImageSelect.appendChild(option);
        }

        // Create previews
        imageFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'relative group bg-white border border-gray-200 rounded-lg overflow-hidden';

                previewItem.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" alt="${file.name}" class="w-full h-24 object-cover">
                        <div class="absolute top-1 left-1">
                            <span class="inline-flex items-center px-1 py-0.5 text-xs font-semibold rounded-full ${index === 0 ? 'bg-brown text-white' : 'bg-gray-600 text-white'}">
                                ${index === 0 ? '{{ __("Main") }}' : `#${index + 1}`}
                            </span>
                        </div>
                    </div>
                    <div class="p-2">
                        <p class="text-xs text-gray-600 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(1)} MB</p>
                    </div>
                `;

                previewList.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    };

    // Form validation function
    window.validateForm = function() {
        console.log('Form validation started');

        // Check if any color sections are added
        const colorSections = document.querySelectorAll('[id^="color-section-"]');

        // If color sections exist, validate them
        if (colorSections.length > 0) {
            for (let section of colorSections) {
                const colorSelect = section.querySelector('select[name*="color_id"]');
                const quantityInput = section.querySelector('input[name*="quantity"]');
                const fileInput = section.querySelector('input[type="file"]');

                if (!colorSelect.value) {
                    alert('Please select a color for all color sections.');
                    return false;
                }

                if (!quantityInput.value || quantityInput.value < 0) {
                    alert('Please enter a valid quantity for all colors.');
                    return false;
                }

                if (!fileInput.files || fileInput.files.length === 0) {
                    alert('Please upload at least one image for each color.');
                    return false;
                }
            }
        }

        console.log('Form validation passed');
        return true;
    };

    // Countdown sale toggle functionality
    const countdownCheckbox = document.getElementById('is_countdown_sale');
    const countdownFields = document.getElementById('countdown-fields');

    if (countdownCheckbox && countdownFields) {
        countdownCheckbox.addEventListener('change', function() {
            if (this.checked) {
                countdownFields.style.display = 'block';
            } else {
                countdownFields.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
