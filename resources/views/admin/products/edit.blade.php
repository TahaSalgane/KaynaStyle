@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<style>
    .dragging {
        opacity: 0.5;
        transform: rotate(5deg);
        z-index: 1000;
    }

    .drag-over {
        border: 2px dashed #8B4513;
        background-color: #F5F5DC;
    }

    .image-container {
        transition: all 0.3s ease;
        position: relative;
    }

    .image-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .image-container[draggable="true"]:hover {
        cursor: grab;
    }

    .image-container[draggable="true"]:active {
        cursor: grabbing;
    }
</style>
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center text-gray-600 hover:text-brown transition-colors duration-300">
                <i class="fas fa-arrow-left {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('Back to Products') }}
            </a>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">{{ __('Edit Product') }}: {{ $product->name }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ __('Update product information and settings') }}</p>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-8" onsubmit="updateAllSortOrders()">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Basic Information') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Product Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('name_en') border-red-500 @enderror"
                           placeholder="{{ __('Enter product name') }}">
                    @error('name_en')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Description') }}
                    </label>
                    <textarea id="description_en" name="description_en" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('description_en') border-red-500 @enderror"
                              placeholder="{{ __('Enter product description') }}">{{ old('description_en', $product->description_en) }}</textarea>
                    @error('description_en')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing & Inventory -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Pricing & Inventory') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Price') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
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
                    <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
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
                                   {{ old('is_countdown_sale', $product->is_countdown_sale) ? 'checked' : '' }}
                                   class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                            <label for="is_countdown_sale" class="ml-2 text-sm font-medium text-gray-700">
                                {{ __('Enable Countdown Sale') }}
                            </label>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">
                            {{ __('Enable this to show a countdown timer for the sale, creating urgency for customers.') }}
                        </p>
                        <div id="countdown-fields" class="space-y-3" style="display: {{ old('is_countdown_sale', $product->is_countdown_sale) ? 'block' : 'none' }};">
                            <div>
                                <label for="sale_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Sale End Date & Time') }}
                                </label>
                                <input type="datetime-local" id="sale_end_date" name="sale_end_date"
                                       value="{{ old('sale_end_date', $product->sale_end_date ? $product->sale_end_date->format('Y-m-d\TH:i') : '') }}"
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
                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
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
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('sku') border-red-500 @enderror"
                           placeholder="{{ __('Product SKU') }}">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sizes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Available Sizes') }}</h2>

                    <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
                        @forelse($sizes as $size)
                            <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded cursor-pointer">
                                <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                       {{ in_array($size->id, old('sizes', $product->sizes)) ? 'checked' : '' }}
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
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Product Main Settings') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Default Color -->
                <div>
                    <label for="default_color_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Default Color') }}
                    </label>
                    <select id="default_color_id" name="default_color_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                        <option value="">{{ __('No default color') }}</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ $product->default_color_id == $color->id ? 'selected' : '' }}>
                                {{ $color->name_en }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">{{ __('This color will be shown first on the product page and its main image will be used as the product main image') }}</p>
                </div>

            </div>
        </div>

        <!-- Color-Based Images -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Product Images by Color') }}</h2>

            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">{{ __('Manage images for each color. Upload new images or remove existing ones.') }}</p>

                <!-- Existing Color Images -->
                @if($colorImages && $colorImages->count() > 0)
                    @foreach($colorImages as $colorId => $images)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <h4 class="text-sm font-semibold text-gray-700">
                                        {{ $images->first()->color->name }} {{ __('Images') }}
                                    </h4>
                                    <div class="w-6 h-6 rounded-full border border-gray-300"
                                         style="background-color: {{ $images->first()->color->hex_code }}"></div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-gray-600">{{ __('Quantity') }}:</label>
                                    <input type="number" name="color_quantities[{{ $colorId }}][quantity]"
                                           value="{{ $product->getQuantityForColor($colorId) }}"
                                           min="0" class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-brown focus:border-brown">
                                </div>
                            </div>

                            <!-- Existing Images -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-2">{{ __('Drag to reorder images. First image is the main image.') }}</p>
                                <button type="button" onclick="updateSortOrder(document.getElementById('color-images-{{ $colorId }}'))" class="text-xs bg-blue-500 text-white px-2 py-1 rounded">Update Sort Order</button>
                            </div>
                            <div id="color-images-{{ $colorId }}" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-4" data-color-id="{{ $colorId }}">
                                @foreach($images->sortBy('sort_order') as $image)
                                    <div class="relative group bg-white border border-gray-200 rounded-lg overflow-hidden cursor-move image-container"
                                         data-image-id="{{ $image->id }}"
                                         data-sort-order="{{ $image->sort_order }}"
                                         draggable="true"
                                         ondrop="drop(event)"
                                         ondragover="allowDrop(event)"
                                         ondragstart="drag(event)"
                                         ondragend="dragEnd(event)">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-24 object-cover">

                                        <!-- Sort Order Indicator -->
                                        <div class="absolute top-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                            {{ $loop->iteration }}
                                        </div>

                                        @if($image->is_main)
                                            <div class="absolute top-1 right-8">
                                                <span class="inline-flex items-center px-1 py-0.5 text-xs font-semibold rounded-full bg-brown text-white">
                                                    {{ __('Main') }}
                                        </span>
                                    </div>
                                        @endif

                                        <!-- Remove Button -->
                                        <button type="button" onclick="removeColorImage({{ $image->id }})"
                                                class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>

                                        <!-- Drag Handle -->
                                        <div class="absolute bottom-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-grip-vertical"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Hidden input to store sort order -->
                            <input type="hidden" id="sort-order-{{ $colorId }}" name="image_sort_order[{{ $colorId }}]" value="">
                            <div id="sort-order-debug-{{ $colorId }}" class="text-xs text-gray-500 mt-1">Sort Order: <span id="sort-order-value-{{ $colorId }}"></span></div>

                            <!-- Add New Images for this Color -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-brown transition-colors cursor-pointer"
                                 onclick="document.getElementById('new-color-images-{{ $colorId }}').click()">
                                <i class="fas fa-plus text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">{{ __('Add more images for') }} {{ $images->first()->color->name }}</p>
                                <input type="file" id="new-color-images-{{ $colorId }}"
                                       name="new_color_images[{{ $colorId }}][images][]"
                                       multiple accept="image/*" class="hidden"
                                       onchange="handleNewColorImages(this, {{ $colorId }})">
                            </div>

                            <!-- New Image Previews -->
                            <div id="new-color-preview-{{ $colorId }}" class="mt-4 hidden">
                                <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('New Images') }}</h5>
                                <div id="new-color-preview-list-{{ $colorId }}" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                    <!-- New images will be added here -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-image text-2xl mb-2"></i>
                        <p>{{ __('No color images found') }}</p>
                    </div>
                @endif

                <!-- Add New Color Section -->
                <div class="mt-6">
                    <button type="button" id="add-new-color-section"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                            <i class="fas fa-plus mr-2"></i>
                        {{ __('Add Images for New Color') }}
                        </button>
                </div>

                <!-- New Color Sections Container -->
                <div id="new-color-sections-container" class="mt-4">
                    <!-- New color sections will be added here -->
                </div>
            </div>

            @error('color_images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Product Settings') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Sort Order') }}
                    </label>
                    <input type="number" id="product_sort_order" name="product_sort_order" value="{{ old('product_sort_order', $product->sort_order) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('product_sort_order') border-red-500 @enderror"
                           placeholder="0">
                    @error('product_sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                        {{ __('Featured Product') }}
                    </label>
                </div>

                <!-- Active -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        {{ __('Active') }}
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-3 pt-6">
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300">
                {{ __('Cancel') }}
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-brown rounded-lg hover:bg-brown-hover transition duration-300">
                {{ __('Update Product') }}
            </button>
        </div>
    </form>
</div>

<!-- Color-Based Image Management System -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newColorSectionsContainer = document.getElementById('new-color-sections-container');
    const addNewColorSectionBtn = document.getElementById('add-new-color-section');
    let newColorSectionCount = 0;

    // Available colors from the form
    const availableColors = @json($colors->toArray());

    // Add new color section button click
    addNewColorSectionBtn.addEventListener('click', function() {
        addNewColorSection();
    });

    function addNewColorSection() {
        const sectionId = `new-color-section-${newColorSectionCount}`;
        const section = document.createElement('div');
        section.id = sectionId;
        section.className = 'border border-gray-200 rounded-lg p-4 mb-4';

        section.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-semibold text-gray-700">{{ __('New Color Images') }}</h4>
                <button type="button" onclick="removeNewColorSection('${sectionId}')"
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
                    <select name="color_images[new_${newColorSectionCount}][color_id]" required
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
                    <input type="number" name="color_quantities[new_${newColorSectionCount}][quantity]"
                           min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                           placeholder="0">
                </div>

                <!-- Main Image Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Main Image Index') }}
                    </label>
                    <select name="main_images[new_${newColorSectionCount}]"
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
                     onclick="document.getElementById('new-color-images-${newColorSectionCount}').click()">
                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-2">{{ __('Click to select images') }}</p>
                    <p class="text-xs text-gray-500">{{ __('Recommended: 1080x1620 pixels (2:3 ratio)') }}</p>
                    <input type="file" id="new-color-images-${newColorSectionCount}"
                           name="color_images[new_${newColorSectionCount}][images][]"
                           multiple accept="image/*" class="hidden"
                           onchange="handleNewColorImages(this, ${newColorSectionCount})">
                </div>

                <!-- Image Previews -->
                <div id="new-color-preview-${newColorSectionCount}" class="mt-4 hidden">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('Image Previews') }}</h5>
                    <div id="new-color-preview-list-${newColorSectionCount}" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <!-- Images will be added here -->
                    </div>
                </div>
            </div>
        `;

        newColorSectionsContainer.appendChild(section);
        newColorSectionCount++;
    }

    // Global function to remove new color section
    window.removeNewColorSection = function(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.remove();
        }
    };

    // Global function to remove existing color image
    window.removeColorImage = function(imageId) {
        if (confirm('Are you sure you want to remove this image?')) {
            // Create hidden input for form submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_color_images[]';
            hiddenInput.value = imageId;
            document.body.appendChild(hiddenInput);

            // Remove the image element from DOM
            const imageElement = document.querySelector(`button[onclick="removeColorImage(${imageId})"]`).closest('.relative');
            if (imageElement) {
                imageElement.remove();
            }
        }
    };

    // Drag and Drop functionality for image sorting
    let draggedElement = null;
    let draggedIndex = -1;

    // Make functions global
    window.allowDrop = function(ev) {
        ev.preventDefault();
    };

    window.drag = function(ev) {
        draggedElement = ev.target.closest('[data-image-id]');
        if (draggedElement) {
            draggedElement.style.opacity = '0.5';
            draggedElement.style.transform = 'rotate(5deg)';

            // Find the index of the dragged element
            const container = draggedElement.parentElement;
            const children = Array.from(container.children);
            draggedIndex = children.indexOf(draggedElement);
        }
    };

    window.drop = function(ev) {
        ev.preventDefault();

        if (draggedElement) {
            // Find the drop target
            let dropTarget = ev.target;
            while (dropTarget && !dropTarget.hasAttribute('data-image-id')) {
                dropTarget = dropTarget.parentElement;
            }

            if (dropTarget && dropTarget !== draggedElement) {
                const container = dropTarget.parentElement;
                const children = Array.from(container.children);
                const dropIndex = children.indexOf(dropTarget);

                console.log('Dropping element at index:', dropIndex, 'from index:', draggedIndex);

                // Move the element
                if (draggedIndex < dropIndex) {
                    container.insertBefore(draggedElement, dropTarget.nextSibling);
            } else {
                    container.insertBefore(draggedElement, dropTarget);
                }

                // Update sort order
                updateSortOrder(container);
            }

            // Reset dragged element
            draggedElement.style.opacity = '1';
            draggedElement.style.transform = 'rotate(0deg)';
            draggedElement = null;
            draggedIndex = -1;
        }
    };

    window.dragEnd = function(ev) {
        if (draggedElement) {
            draggedElement.style.opacity = '1';
            draggedElement.style.transform = 'rotate(0deg)';
            draggedElement = null;
            draggedIndex = -1;
        }
    };

    window.updateSortOrder = function(container) {
        const colorId = container.getAttribute('data-color-id');
        const images = container.querySelectorAll('[data-image-id]');
        const sortOrderInput = document.getElementById(`sort-order-${colorId}`);

        if (!sortOrderInput) {
            console.error('Sort order input not found for color:', colorId);
            return;
        }

        let sortOrder = [];
        images.forEach((image, index) => {
            const imageId = image.getAttribute('data-image-id');
            sortOrder.push(imageId);

            // Update the visual sort order indicator to show sequential position
            const orderIndicator = image.querySelector('.absolute.top-1.left-1');
            if (orderIndicator) {
                orderIndicator.textContent = index + 1; // Show 1, 2, 3, etc.
            }

            // Update the first image as main
            const mainBadge = image.querySelector('.absolute.top-1.right-8');
            if (index === 0) {
                if (!mainBadge) {
                    const badge = document.createElement('div');
                    badge.className = 'absolute top-1 right-8';
                    badge.innerHTML = '<span class="inline-flex items-center px-1 py-0.5 text-xs font-semibold rounded-full bg-brown text-white">Main</span>';
                    image.appendChild(badge);
                }
            } else {
                if (mainBadge) {
                    mainBadge.remove();
                }
            }
        });

        sortOrderInput.value = sortOrder.join(',');
        console.log('Updated sort order for color', colorId, ':', sortOrderInput.value);

        // Update debug display
        const debugSpan = document.getElementById(`sort-order-value-${colorId}`);
        if (debugSpan) {
            debugSpan.textContent = sortOrderInput.value;
        }
    };

    // Function to update all sort orders before form submission
    window.updateAllSortOrders = function() {
        const colorContainers = document.querySelectorAll('[data-color-id]');
        colorContainers.forEach(container => {
            updateSortOrder(container);
        });
        return true; // Allow form submission
    };

    // Initialize sort order on page load
    document.addEventListener('DOMContentLoaded', function() {
        const colorContainers = document.querySelectorAll('[data-color-id]');
        colorContainers.forEach(container => {
            updateSortOrder(container);
        });
    });

    // Global function to handle new color images
    window.handleNewColorImages = function(input, sectionIndex) {
        const files = Array.from(input.files);
        const previewContainer = document.getElementById(`new-color-preview-${sectionIndex}`);
        const previewList = document.getElementById(`new-color-preview-list-${sectionIndex}`);
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
