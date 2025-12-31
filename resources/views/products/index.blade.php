@extends('layouts.app')

@section('title', __('messages.products'))

@section('content')
<!-- Hero Section -->
<section class="relative text-white py-6 sm:py-16 lg:py-10 overflow-hidden" style="background: linear-gradient(to left, var(--color-brown-primary), var(--color-brown-darker));">
    <!-- Modern Background Pattern -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
        <div class="absolute top-0 right-0 w-48 h-48 sm:w-96 sm:h-96 bg-white/10 rounded-full -translate-y-24 translate-x-24 sm:-translate-y-48 sm:translate-x-48"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 sm:w-80 sm:h-80 bg-white/5 rounded-full translate-y-20 -translate-x-20 sm:translate-y-40 sm:-translate-x-40"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} text-sm text-white/80">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('messages.home') }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white">{{ __('messages.products') }}</li>
            </ol>
        </nav>

        <div class="text-center">
            <!-- Products Title -->
            <h1 class="pt-3 text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 drop-shadow-lg">
                {{ __('messages.products') }}
            </h1>

            <!-- Products Description -->
            <p class="text-base sm:text-lg lg:text-xl mb-6 text-white/90 drop-shadow-md max-w-2xl mx-auto">
                {{ __('messages.choose_from_collection') }}
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Products Grid -->
            <div class="flex-1">
                @if($products->count() > 0)
                <!-- Results Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }}">
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ __('messages.products') }}
                        </h2>
                        <span class="bg-brown-light text-brown-primary px-3 py-1 rounded-full text-sm font-medium">
                            {{ $products->total() }} {{ __('messages.items') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between w-full sm:w-auto">
                        <!-- Filter Button -->
                        <button onclick="toggleFilterSidebar()" class="em-button-outline em-font-semibold catalog-toolbar__filter-button inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors {{ app()->getLocale() === 'ar' ? 'sm:ml-6' : 'sm:mr-6' }} ">
                            <span class="ecomus-svg-icon ecomus-svg-icon--filter {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-brown">
                                <svg aria-hidden="true" role="img" focusable="false" width="20" height="12" viewBox="0 0 20 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 1C0 0.734784 0.105357 0.48043 0.292893 0.292893C0.48043 0.105357 0.734784 0 1 0H19C19.2652 0 19.5196 0.105357 19.7071 0.292893C19.8946 0.48043 20 0.734784 20 1C20 1.26522 19.8946 1.51957 19.7071 1.70711C19.5196 1.89464 19.2652 2 19 2H1C0.734784 2 0.48043 1.89464 0.292893 1.70711C0.105357 1.51957 0 1.26522 0 1ZM3 6C3 5.73478 3.10536 5.48043 3.29289 5.29289C3.48043 5.10536 3.73478 5 4 5H16C16.2652 5 16.5196 5.10536 16.7071 5.29289C16.8946 5.48043 17 5.73478 17 6C17 6.26522 16.8946 6.51957 16.7071 6.70711C16.5196 6.89464 16.2652 7 16 7H4C3.73478 7 3.48043 6.89464 3.29289 6.70711C3.10536 6.51957 3 6.26522 3 6ZM8 10C7.73478 10 7.48043 10.1054 7.29289 10.2929C7.10536 10.4804 7 10.7348 7 11C7 11.2652 7.10536 11.5196 7.29289 11.7071C7.48043 11.8946 7.73478 12 8 12H12C12.2652 12 12.5196 11.8946 12.7071 11.7071C12.8946 11.5196 13 11.2652 13 11C13 10.7348 12.8946 10.4804 12.7071 10.2929C12.5196 10.1054 12.2652 10 12 10H8Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            {{ __('messages.filter') }}
                        </button>
                        <!-- Sort Dropdown -->
                        <select id="sortBy" class="px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brown focus:border-transparent text-sm">
                            <option value="newest">{{ __('messages.newest') }}</option>
                            <option value="price_low">{{ __('messages.price_low_to_high') }}</option>
                            <option value="price_high">{{ __('messages.price_high_to_low') }}</option>
                            <option value="name">{{ __('messages.name') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="relative">
                    <!-- Loading Overlay for Products Section Only -->
                    <div id="loadingSpinner" class="hidden absolute inset-0 bg-white bg-opacity-80 z-10 flex items-center justify-center rounded-2xl">
                        <div class="flex flex-col items-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-2 border-brown mb-2"></div>
                            <p class="text-gray-600 text-sm font-medium">{{ __('messages.loading') }}</p>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                        @include('categories.partials.products-grid', ['products' => $products])
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
                @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-tshirt text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">
                        {{ __('messages.no_products') }}
                    </h3>
                    <p class="text-gray-500 mb-6">
                        {{ __('messages.try_different_keywords') }}
                    </p>
                    <button onclick="resetFilters()" class="btn-brown-gradient py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
                        {{ __('messages.reset_filters') }}
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Filter Sidebar (Off-Canvas) -->
@include('shared.filter-sidebar', [
    'showCategoryFilter' => true,
    'categories' => $categories,
    'availableColors' => $availableColors
])
@endsection

@push('styles')
<style>
    /* Custom Brown Color Classes */
    .bg-brown-light {
        background-color: rgba(128, 89, 60, 0.1);
    }

    .bg-brown-medium {
        background-color: rgba(128, 89, 60, 0.2);
    }

    .text-brown-primary {
        color: #80593c;
    }

    /* Dual Range Slider Styles */
    .dual-range-container {
        position: relative;
        height: 20px;
        margin: 20px 0;
    }

    .dual-range-input {
        position: absolute;
        width: 100%;
        height: 20px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        appearance: none;
    }

    .dual-range-input::-webkit-slider-track {
        background: transparent;
        height: 20px;
    }

    .dual-range-input::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));
        cursor: pointer;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        pointer-events: all;
        position: relative;
        z-index: 2;
    }

    .dual-range-input::-moz-range-track {
        background: transparent;
        height: 20px;
        border: none;
    }

    .dual-range-input::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));
        cursor: pointer;
        border-radius: 50%;
        border: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        pointer-events: all;
    }

    .dual-range-track {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        transform: translateY(-50%);
    }

    .dual-range-progress {
        position: absolute;
        top: 50%;
        height: 4px;
        background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));
        border-radius: 2px;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }

    .min-range {
        z-index: 1;
    }

    .max-range {
        z-index: 0;
    }

    .color-filter:checked + div {
        border-color: var(--color-brown-primary) !important;
        box-shadow: 0 0 0 2px var(--color-brown-light);
    }

    .size-filter:checked + div {
        background-color: var(--color-brown-primary) !important;
        color: white !important;
        border-color: var(--color-brown-primary) !important;
    }

    .category-filter:checked + div {
        background-color: var(--color-brown-primary) !important;
        border-color: var(--color-brown-primary) !important;
    }

    .category-filter:checked + div i {
        opacity: 1 !important;
    }

    .product-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Product Image Container */
    .product-image-container {
        position: relative;
        width: 100%;
        overflow: hidden;
        background-color: #ffffff;
        padding-top: 120%;
        border-radius: 12px;
    }

    .product-image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 12px;
    }

    /* Product Title with Ellipsis */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Product Featured Icons - Overlay Buttons */
    .product-featured-icons {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        z-index: 20;
        pointer-events: none;
        width: 100%;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Animation: Slide up and fade in */
    .product-card:hover .product-featured-icons,
    .product-featured-icons.mobile-visible {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .product-featured-icons a,
    .product-featured-icons button {
        pointer-events: all;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: #80593c;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border: none;
        cursor: pointer;
        padding: 0;
        animation: buttonFadeIn 0.5s ease-out backwards;
    }

    /* Stagger animation for buttons */
    .product-featured-icons a:nth-child(1),
    .product-featured-icons button:nth-child(1) {
        animation-delay: 0.1s;
    }

    .product-featured-icons a:nth-child(2),
    .product-featured-icons button:nth-child(2) {
        animation-delay: 0.2s;
    }

    /* Button hover animation with bounce */
    .product-featured-icons a:hover,
    .product-featured-icons button:hover {
        background: white;
        transform: scale(1.15) translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
        color: #6b4a2f;
        animation: buttonPulse 0.6s ease-out;
    }

    /* Active/press animation */
    .product-featured-icons a:active,
    .product-featured-icons button:active {
        transform: scale(1.05) translateY(0);
    }

    .product-featured-icons svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
        transition: transform 0.3s ease;
    }

    .product-featured-icons a:hover svg,
    .product-featured-icons button:hover svg {
        transform: scale(1.1);
    }

    /* Keyframe animations */
    @keyframes buttonFadeIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes buttonPulse {
        0%, 100% {
            transform: scale(1.15) translateY(-2px);
        }
        50% {
            transform: scale(1.25) translateY(-4px);
        }
    }

    /* Desktop: Show on hover with animation */
    @media (min-width: 768px) {
        .product-featured-icons {
            opacity: 0;
            transform: translateX(-50%) translateY(20px);
        }

        .product-card:hover .product-featured-icons {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    /* Mobile: Always visible, smaller buttons */
    @media (max-width: 767px) {
        .product-featured-icons {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
            bottom: 12px;
            gap: 6px;
        }

        .product-featured-icons a,
        .product-featured-icons button {
            width: 36px;
            height: 36px;
        }

        .product-featured-icons svg {
            width: 16px;
            height: 16px;
        }

        .product-featured-icons a:hover,
        .product-featured-icons button:hover {
            transform: scale(1.1) translateY(-2px);
        }
    }

    /* Filter Sidebar Styles */
    .filter-sidebar {
        max-height: 100vh;
    }

    .filter-sidebar.open {
        transform: translateX(0);
    }

    @media (max-width: 640px) {
        .filter-sidebar {
            max-width: 100%;
        }
    }


    .color-filter:checked + div {
        border-color: var(--color-brown-primary) !important;
        box-shadow: 0 0 0 2px var(--color-brown-light);
    }

    .size-filter:checked + div {
        background-color: var(--color-brown-primary) !important;
        color: white !important;
        border-color: var(--color-brown-primary) !important;
    }

    .category-filter:checked + div {
        background-color: var(--color-brown-primary) !important;
        border-color: var(--color-brown-primary) !important;
    }

    .category-filter:checked + div i {
        opacity: 1 !important;
    }
</style>
@endpush

<script>
let filterTimeout;
let currentRequest = null;

// Global function for updating progress bar
function updateProgress() {
    const minRange = document.getElementById('minRange');
    const maxRange = document.getElementById('maxRange');
    const progress = document.querySelector('.dual-range-progress');

    if (minRange && maxRange && progress) {
        const min = parseInt(minRange.value);
        const max = parseInt(maxRange.value);
        const minPercent = (min / 1000) * 100;
        const maxPercent = (max / 1000) * 100;

        progress.style.left = minPercent + '%';
        progress.style.width = (maxPercent - minPercent) + '%';
    }
}

// Toggle Filter Sidebar
function toggleFilterSidebar() {
    const sidebar = document.getElementById('filter-sidebar-panel');
    const overlay = document.getElementById('filter-sidebar-overlay');

    if (sidebar.classList.contains('open')) {
        // Close sidebar
        sidebar.classList.remove('open');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    } else {
        // Open sidebar
        sidebar.classList.add('open');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

// Apply Filters with delay to avoid too many requests
function applyFiltersWithDelay() {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(applyFilters, 300);
}

// Apply Filters with AJAX
function applyFilters() {
    // Cancel previous request if it's still pending
    if (currentRequest) {
        currentRequest.abort();
    }

    showLoading();

    const minPrice = document.getElementById('minPrice').value || 0;
    const maxPrice = document.getElementById('maxPrice').value || 1000;
    const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
    const selectedColors = Array.from(document.querySelectorAll('.color-filter:checked')).map(cb => cb.value);
    const selectedSizes = Array.from(document.querySelectorAll('.size-filter:checked')).map(cb => cb.value);
    const sortBy = document.getElementById('sortBy').value;

    // Build URL with filters
    const url = new URL(window.location);
    url.searchParams.set('min_price', minPrice);
    url.searchParams.set('max_price', maxPrice);
    url.searchParams.set('sort', sortBy);

    if (selectedCategories.length > 0) {
        url.searchParams.set('categories', selectedCategories.join(','));
    } else {
        url.searchParams.delete('categories');
    }

    if (selectedColors.length > 0) {
        url.searchParams.set('colors', selectedColors.join(','));
    } else {
        url.searchParams.delete('colors');
    }

    if (selectedSizes.length > 0) {
        url.searchParams.set('sizes', selectedSizes.join(','));
    } else {
        url.searchParams.delete('sizes');
    }

    // Create abort controller for request cancellation
    const controller = new AbortController();
    currentRequest = controller;

    // Make AJAX request
    fetch(url.toString(), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        signal: controller.signal
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('productsGrid').innerHTML = data.html;
        updateProductCount(data.count);
        hideLoading();
        currentRequest = null;
    })
    .catch(error => {
        if (error.name === 'AbortError') {
            // Request was cancelled, don't show error
            return;
        }
        console.error('Error:', error);
        hideLoading();
        const errorMsg = '{{ __("messages.error_loading_products") }}';
        showNotification(errorMsg + ': ' + error.message, 'error');
        currentRequest = null;
    });
}

// Reset Filters
function resetFilters() {
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '';
    document.getElementById('minRange').value = 0;
    document.getElementById('maxRange').value = 1000;
    document.getElementById('sortBy').value = 'newest';

    // Update progress bar
    updateProgress();

    // Uncheck all category filters
    document.querySelectorAll('.category-filter').forEach(checkbox => {
        checkbox.checked = false;
        const categoryDiv = checkbox.nextElementSibling;
        categoryDiv.style.backgroundColor = 'transparent';
        categoryDiv.style.borderColor = '#d1d5db';
        const icon = categoryDiv.querySelector('i');
        icon.style.opacity = '0';
    });

    // Uncheck all color filters
    document.querySelectorAll('.color-filter').forEach(checkbox => {
        checkbox.checked = false;
        const colorDiv = checkbox.nextElementSibling;
        colorDiv.style.borderColor = 'transparent';
        colorDiv.style.boxShadow = 'none';
    });

    // Uncheck all size filters
    document.querySelectorAll('.size-filter').forEach(checkbox => {
        checkbox.checked = false;
        const sizeDiv = checkbox.nextElementSibling;
        sizeDiv.style.backgroundColor = 'transparent';
        sizeDiv.style.color = '#6b7280';
        sizeDiv.style.borderColor = '#d1d5db';
    });

    // Apply filters immediately
    applyFilters();
}

// Show Loading
function showLoading() {
    document.getElementById('loadingSpinner').classList.remove('hidden');
}

// Hide Loading
function hideLoading() {
    document.getElementById('loadingSpinner').classList.add('hidden');
}

// Update Product Count
function updateProductCount(count) {
    const countElement = document.querySelector('.bg-brown-light');
    if (countElement) {
        // Get translation from Laravel
        const itemsText = '{{ __("messages.items") }}';
        countElement.textContent = count + ' ' + itemsText;
    }
}

// Initialize grid view by default
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('productsGrid');
    if (grid) {
        grid.className = 'grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6';
    }
});

// Add to Cart
function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        } else {
            const errorMsg = '{{ __("messages.error_adding_to_cart") }}';
            showNotification(data.message || errorMsg, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const errorMsg = '{{ __("messages.error_adding_to_cart") }}';
        showNotification(errorMsg, 'error');
    });
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Dual Range Slider
    const minRange = document.getElementById('minRange');
    const maxRange = document.getElementById('maxRange');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const progress = document.querySelector('.dual-range-progress');

    // Min range slider
    minRange.addEventListener('input', function() {
        const min = parseInt(this.value);
        const max = parseInt(maxRange.value);

        if (min >= max) {
            this.value = max - 1;
        }

        minPrice.value = this.value;
        updateProgress();
        applyFiltersWithDelay();
    });

    // Max range slider
    maxRange.addEventListener('input', function() {
        const min = parseInt(minRange.value);
        const max = parseInt(this.value);

        if (max <= min) {
            this.value = min + 1;
        }

        maxPrice.value = this.value;
        updateProgress();
        applyFiltersWithDelay();
    });

    // Price inputs
    minPrice.addEventListener('input', function() {
        const min = parseInt(this.value) || 0;
        const max = parseInt(maxRange.value);

        if (min >= max) {
            this.value = max - 1;
        }

        minRange.value = this.value;
        updateProgress();
        applyFiltersWithDelay();
    });

    maxPrice.addEventListener('input', function() {
        const min = parseInt(minRange.value);
        const max = parseInt(this.value) || 1000;

        if (max <= min) {
            this.value = min + 1;
        }

        maxRange.value = this.value;
        updateProgress();
        applyFiltersWithDelay();
    });

    // Initialize progress bar
    updateProgress();

    // Category Filter
    document.querySelectorAll('.category-filter').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const categoryDiv = this.nextElementSibling;
            const icon = categoryDiv.querySelector('i');
            if (this.checked) {
                categoryDiv.style.backgroundColor = 'var(--color-brown-primary)';
                categoryDiv.style.borderColor = 'var(--color-brown-primary)';
                icon.style.opacity = '1';
            } else {
                categoryDiv.style.backgroundColor = 'transparent';
                categoryDiv.style.borderColor = '#d1d5db';
                icon.style.opacity = '0';
            }
            applyFiltersWithDelay();
        });
    });

    // Color Filter
    document.querySelectorAll('.color-filter').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const colorDiv = this.nextElementSibling;
            if (this.checked) {
                colorDiv.style.borderColor = 'var(--color-brown-primary)';
                colorDiv.style.boxShadow = '0 0 0 2px var(--color-brown-light)';
            } else {
                colorDiv.style.borderColor = 'transparent';
                colorDiv.style.boxShadow = 'none';
            }
            applyFiltersWithDelay();
        });
    });

    // Size Filter
    document.querySelectorAll('.size-filter').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const sizeDiv = this.nextElementSibling;
            if (this.checked) {
                sizeDiv.style.backgroundColor = 'var(--color-brown-primary)';
                sizeDiv.style.color = 'white';
                sizeDiv.style.borderColor = 'var(--color-brown-primary)';
            } else {
                sizeDiv.style.backgroundColor = 'transparent';
                sizeDiv.style.color = '#6b7280';
                sizeDiv.style.borderColor = '#d1d5db';
            }
            applyFiltersWithDelay();
        });
    });

    // Sort Filter
    document.getElementById('sortBy').addEventListener('change', applyFiltersWithDelay);
});
</script>
