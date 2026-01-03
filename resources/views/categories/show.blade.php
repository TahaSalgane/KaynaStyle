@extends('layouts.app')

@section('title', $category->name)

@section('content')
<!-- Hero Section -->
<section class="relative text-white py-6 sm:py-16 lg:py-10 overflow-hidden" style="background: linear-gradient(to left, var(--color-brown-primary), var(--color-brown-darker));">
    <!-- Category Background Image -->
    @if($category->image)
    <div class="category-hero-background">
        <img src="{{ asset('storage/' . $category->image) }}"
             alt="{{ $category->name }}"
             loading="eager">
        <!-- Dark overlay for text readability -->
        <div class="category-hero-overlay"></div>
    </div>
    @endif

    <!-- Modern Background Pattern -->
    <div class="absolute inset-0 z-2">
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
                <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">{{ __('messages.categories') }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white">{{ $category->name }}</li>
            </ol>
        </nav>

        <div class="text-center category-hero-content">
            <!-- Category Title -->
            <h1 class="pt-3 text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                {{ $category->name }}
            </h1>

            <!-- Category Description -->
            <p class="text-base sm:text-lg lg:text-xl mb-6 text-white/90 max-w-2xl mx-auto">
                {{ $category->description }}
            </p>

        </div>
    </div>
</section>

<!-- Main Content -->
<div class="bg-gray-50">
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
                    <div class="flex items-center justify-between w-full sm:w-auto {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <!-- Filter Button -->
                        <button onclick="toggleFilterSidebar()" class="em-button-outline em-font-semibold catalog-toolbar__filter-button inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors sm:mr-6">
                            <span class="ecomus-svg-icon ecomus-svg-icon--filter {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}  text-brown">
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
                {{ __('messages.no_products_in_category') }}
            </h3>
            <p class="text-gray-500 mb-6">
                {{ __('messages.we_will_add_products_soon') }}
            </p>
            <a href="{{ route('products.index') }}"
                       class="btn-brown-gradient py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
                {{ __('messages.products') }}
            </a>
        </div>
        @endif
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section - Shopify Inspired -->
@include('shared.reviews-section', [
    'categoryId' => $category->id,
    'reviews' => $reviews,
    'allReviews' => $allReviews,
    'totalReviews' => $totalReviews,
    'averageRating' => $averageRating,
    'ratingDistribution' => $ratingDistribution,
    'sectionId' => 'category-reviews',
    'containerId' => 'judgeme_category_reviews',
    'addMarginTop' => false
])

<!-- Store Reviews Data for JavaScript -->
@if($totalReviews > 0)
<script>
    window.reviewsData = {
        @if(isset($allReviews))
            @foreach($allReviews as $review)
            {{ $review->id }}: {
                id: {{ $review->id }},
                name: "{{ addslashes($review->formatted_display_name) }}",
                rating: {{ $review->rating }},
                title: "{{ $review->review_title ? addslashes($review->review_title) : '' }}",
                text: "{{ addslashes($review->review_text) }}",
                date: "{{ $review->created_at->format('M d, Y') }}",
                media: @if($review->media)"{{ asset('storage/' . $review->media) }}"@else null @endif
            },
            @endforeach
        @else
            @foreach($reviews as $review)
            {{ $review->id }}: {
                id: {{ $review->id }},
                name: "{{ addslashes($review->formatted_display_name) }}",
                rating: {{ $review->rating }},
                title: "{{ $review->review_title ? addslashes($review->review_title) : '' }}",
                text: "{{ addslashes($review->review_text) }}",
                date: "{{ $review->created_at->format('M d, Y') }}",
                media: @if($review->media)"{{ asset('storage/' . $review->media) }}"@else null @endif
            },
            @endforeach
        @endif
    };
</script>
@endif

<!-- Gallery Lightbox Modal -->
@if($totalReviews > 0 && isset($allReviews) && $allReviews->whereNotNull('media')->count() > 0)
@php
    $mediaReviews = $allReviews->whereNotNull('media');
    $mediaReviewsAll = $mediaReviews->values()->all(); // Reset keys to be sequential (0, 1, 2, 3...)
@endphp
<div id="gallery-lightbox-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
    <div class="jm-mfp-main w-full max-w-[95vw] sm:max-w-[90vw] lg:max-w-7xl h-[90vh] sm:h-[85vh] lg:h-[85vh] flex flex-col lg:flex-row bg-white rounded-lg lg:rounded-2xl overflow-hidden shadow-2xl relative">
        <!-- Close Button -->
        <button id="close-gallery-modal" class="absolute top-2 right-2 lg:top-4 lg:right-4 text-gray-700 hover:text-gray-900 transition-colors z-10 bg-white/90 hover:bg-white rounded-full p-2 shadow-lg">
            <i class="fas fa-times text-xl lg:text-2xl"></i>
        </button>

        <!-- Main Content Wrapper -->
        <div class="jm-mfp-carousel-wrapper flex-1 flex flex-col items-center justify-center p-3 sm:p-4 lg:p-6 min-h-0 overflow-hidden">
            <!-- Main Image/Video Display -->
            <div class="jm-mfp-content-wrapper flex-1 w-full flex items-center justify-center relative min-h-0">
                <!-- Navigation Arrows -->
                @if(count($mediaReviewsAll) > 1)
                <button id="lightbox-prev" class="absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center text-brown shadow-lg transition-all z-10">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
                <button id="lightbox-next" class="absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center text-brown shadow-lg transition-all z-10">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>
                @endif

                <div class="jm-mfp-content w-full">
                    <figure class="jm-mfp-figure w-full flex items-center justify-center">
                        <img id="lightbox-main-image" src="" alt="Review image" class="jm-mfp-img max-h-[48vh] sm:max-h-[35vh] lg:max-h-[55vh] w-full sm:w-auto object-contain rounded-lg">
                        <video id="lightbox-main-video" src="" controls class="hidden max-h-[48vh] sm:max-h-[35vh] lg:max-h-[55vh] w-full sm:w-auto object-contain rounded-lg"></video>
                    </figure>
                </div>
            </div>

            <!-- Thumbnail Carousel -->
            <div class="jm-mfp-carousel mt-10 sm:mt-3 w-full">
                <div id="gallery-thumbnails-container" class="flex flex-col items-stretch gap-3 w-full">
                    <div id="jdgm-gallery-thumbnails" class="jdgm-gallery flex items-center justify-start gap-2 sm:gap-3 overflow-x-auto pb-2 sm:pb-3 w-full px-3 sm:px-4" style="scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                        @foreach($mediaReviewsAll as $index => $review)
                            <div class="jdgm-gallery__thumbnail-link flex-shrink-0 cursor-pointer border-2 border-transparent hover:border-brown transition-colors rounded-lg overflow-hidden {{ $index === 0 ? 'jdgm-gallery__thumbnail-link--current border-brown' : '' }}"
                                 data-media-index="{{ $index }}"
                                 data-review-id="{{ $review->id }}"
                                 data-media-url="{{ asset('storage/' . $review->media) }}">
                                <div class="jdgm-gallery__thumbnail-wrapper w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24">
                                    @if(str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v'))
                                        <video src="{{ asset('storage/' . $review->media) }}" class="jdgm-gallery__thumbnail w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $review->media) }}" alt="User picture" class="jdgm-gallery__thumbnail w-full h-full object-cover" data-mfp-src="{{ asset('storage/' . $review->media) }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Hidden container for all media reviews data -->
                    <div id="all-media-reviews-data" style="display: none;">
                        @foreach($mediaReviewsAll as $index => $review)
                            <div data-media-index="{{ $index }}"
                                 data-review-id="{{ $review->id }}"
                                 data-media-url="{{ asset('storage/' . $review->media) }}"
                                 data-is-video="{{ str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v') ? 'true' : 'false' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Sidebar -->
        <div class="jm-mfp-review-wrapper w-full lg:w-96 xl:w-[450px] bg-white overflow-y-auto max-h-[30vh] sm:max-h-[35vh] lg:max-h-none">
            <div id="lightbox-review-content" class="jdgm-rev p-3 sm:p-4 lg:p-5">
                <!-- Review content will be dynamically loaded here -->
            </div>
        </div>
    </div>
</div>
@endif

<!-- Filter Sidebar (Off-Canvas) -->
<div id="filter-sidebar-panel" class="filter-sidebar fixed inset-y-0 w-[80%] md:w-80 right-0 max-w-md bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-50 overflow-y-auto">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                {{ __('messages.filters') }}
            </h3>
            <div class="flex items-center gap-4">
                <button onclick="resetFilters()" class="text-brown hover:text-brown-hover text-sm font-medium">
                    {{ __('messages.reset') }}
                </button>
                <button onclick="toggleFilterSidebar()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Price Range Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.price_range') }}
            </h4>
            <div class="space-y-4">
                <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }}">
                    <input type="number" id="minPrice" placeholder="0" min="0" max="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                    <span class="text-gray-500">-</span>
                    <input type="number" id="maxPrice" placeholder="1000" min="0" max="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                </div>

                <!-- Dual Range Slider -->
                <div class="relative">
                    <div class="dual-range-container">
                        <input type="range" id="minRange" min="0" max="1000" value="0"
                               class="dual-range-input min-range">
                        <input type="range" id="maxRange" min="0" max="1000" value="1000"
                               class="dual-range-input max-range">
                        <div class="dual-range-track"></div>
                        <div class="dual-range-progress"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                        <span>$0</span>
                        <span>$1000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Color Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.color') }}
            </h4>
            <div class="grid grid-cols-4 gap-3">
                @foreach($availableColors->unique('name_en') as $color)
                <label class="flex flex-col items-center cursor-pointer group">
                    <input type="checkbox" name="color" value="{{ $color->name_en }}" class="hidden color-filter">
                    <div class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-gray-300 transition-all" style="background-color: {{ $color->hex_code }}"></div>
                    <span class="text-xs text-gray-600 mt-1">{{ $color->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Size Filter -->
        <div class="mb-8">
            <h4 class="text-md font-semibold text-gray-700 mb-4">
                {{ __('messages.size') }}
            </h4>
            <div class="grid grid-cols-4 gap-2">
                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                <label class="flex items-center justify-center cursor-pointer">
                    <input type="checkbox" name="size" value="{{ $size }}" class="hidden size-filter">
                    <div class="w-10 h-10 border-2 border-gray-300 rounded-lg flex items-center justify-center text-sm font-medium text-gray-600 hover:border-brown hover:text-brown transition-all size-option">
                        {{ $size }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Apply Filters Button -->
        <button onclick="applyFilters(); toggleFilterSidebar();" class="w-full btn-brown-gradient py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
            {{ __('messages.apply_filters') }}
        </button>
    </div>
</div>

<!-- Overlay -->
<div id="filter-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleFilterSidebar()"></div>

@endsection

@push('styles')
<style>
    /* Category Hero Background Image */
    .category-hero-background {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .category-hero-background img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .category-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5));
        z-index: 1;
    }

    /* Ensure decorative patterns appear above overlay */
    .z-2 {
        z-index: 2;
    }

    /* Enhanced text shadow for better readability */
    .category-hero-content {
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 0, 0, 0.5);
    }

    /* Custom Brown Color Classes */
    .bg-brown-light {
        background-color: rgba(166, 124, 90, 0.1);
    }

    .bg-brown-medium {
        background-color: rgba(166, 124, 90, 0.2);
    }

    .text-brown-primary {
        color: #a67c5a;
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

    /* Filter Sidebar Styles */
    .filter-sidebar {
        max-height: 100vh;
        z-index: 9999 !important;
    }

    .filter-sidebar.open {
        transform: translateX(0);
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

    .product-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Product Image Container  */
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
        color: #a67c5a;
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
        color: #8f6546;
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

    /* Shopify Judge.me Inspired Styles */
    .jdgm-rev-widg__title {
        color: #333333;
        margin-bottom: 1.5rem;
    }

    /* Reviews Card Styling */
    #judgeme_category_reviews > .mb-8:first-child {
        background: linear-gradient(to bottom, #ffffff, #fafafa);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease;
    }

    #judgeme_category_reviews > .mb-8:first-child:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    /* Vertical Separator Line */
    .jdgm-separator {
        width: 1px;
        background-color: #e5e7eb;
        align-self: stretch;
        min-height: 80px;
    }

    /* Center align histogram rows */
    .jdgm-histogram {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .jdgm-rev-widg__summary {
        min-width: 200px;
    }

    .jdgm-rev-widg__summary-inner {
        display: flex;
        flex-direction: column;
    }

    .jdgm-rev-widg__summary-stars {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .jdgm-star {
        display: inline-block;
        line-height: 1;
    }

    .jdgm-histogram {
        min-width: 250px;
    }

    .jdgm-histogram__row {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .jdgm-histogram__star {
        min-width: 80px;
    }

    .jdgm-histogram__bar {
        flex: 1;
        margin: 0 0.75rem;
        height: 10px;
        background-color: #e5e7eb;
        border-radius: 9999px;
        overflow: hidden;
    }

    .jdgm-histogram__bar-content {
        height: 100%;
        background-color: #fbbf24;
        transition: width 0.3s ease;
    }

    .jdgm-histogram__frequency {
        min-width: 24px;
        text-align: right;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .jdgm-histogram__row--selected {
        background-color: rgba(139, 69, 19, 0.1);
        padding: 0.25rem;
        border-radius: 0.25rem;
    }

    .jdgm-histogram__clear-filter {
        margin-top: 0.75rem;
        padding-top: 0.5rem;
        border-top: 1px solid #e5e7eb;
        cursor: pointer;
    }

    .jdgm-write-rev-link {
        color: #8b4513;
        text-decoration: underline;
        cursor: pointer;
        transition: color 0.2s ease;
        background: none;
        border: none;
        padding: 0;
        font: inherit;
    }

    .jdgm-write-rev-link:hover {
        color: #654321;
    }

    /* Mobile adjustments */
    @media (max-width: 1023px) {
        .jdgm-rev-widg__summary {
            min-width: auto;
        }

        .jdgm-histogram {
            min-width: auto;
            width: 100%;
        }
    }

    /* Gallery Lightbox Modal Styles */
    #gallery-lightbox-modal {
        backdrop-filter: blur(4px);
    }

    .jm-mfp-main {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .jm-mfp-carousel-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 0;
        overflow: hidden;
    }

    .jm-mfp-content-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 0;
        max-height: 100%;
    }

    .jm-mfp-figure {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        max-height: 100%;
    }

    .jm-mfp-img, .jm-mfp-video {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .jm-mfp-carousel {
        width: 100%;
        overflow-x: auto;
        flex-shrink: 0;
    }

    .jdgm-gallery {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-start;
        padding: 0;
        min-width: 100%;
    }

    #jdgm-gallery-thumbnails {
        justify-content: flex-start !important;
    }

    .jdgm-gallery__thumbnail-link {
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .jdgm-gallery__thumbnail-link:hover {
        transform: scale(1.05);
    }

    .jdgm-gallery__thumbnail-link--current {
        border: 2px solid #8b4513;
    }

    .jdgm-gallery__thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .jm-mfp-review-wrapper {
        background: white;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        border-top: 1px solid #e5e7eb;
    }

    .jdgm-rev {
        color: #333333;
    }

    .jdgm-rev__header {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1rem;
    }

    .jdgm-rev__content {
        padding-top: 1rem;
    }

    .jdgm-rev__body {
        color: #666666;
        line-height: 1.6;
    }

    @media (min-width: 1024px) {
        #gallery-lightbox-modal {
            padding: 2rem;
        }

        .jm-mfp-main {
            flex-direction: row;
            max-width: 1200px;
            height: 80vh;
        }

        .jm-mfp-review-wrapper {
            border-top: none;
            border-left: 1px solid #e5e7eb;
            max-height: 100%;
        }

        .jm-mfp-carousel-wrapper {
            flex: 1.5;
            min-height: 0;
            padding: 2rem;
        }

        .jm-mfp-img, #lightbox-main-video {
            max-height: 55vh;
        }
    }

    /* Mobile adjustments */
    @media (max-width: 1023px) {
        #gallery-lightbox-modal {
            padding: 0.5rem;
        }

        .jm-mfp-main {
            max-width: 95vw;
            height: 75vh;
        }

        .jm-mfp-review-wrapper {
            max-height: 28vh;
            border-top: 1px solid #e5e7eb;
        }

        .jm-mfp-carousel-wrapper {
            flex: 1;
            min-height: 0;
            padding: 0.5rem;
        }

        .jm-mfp-content-wrapper {
            max-height: 45vh;
            min-height: 40vh;
        }

        .jm-mfp-img, #lightbox-main-video {
            max-height: 42vh;
            width: 100%;
            max-width: 100%;
        }

        #lightbox-prev, #lightbox-next {
            width: 32px;
            height: 32px;
        }

        #lightbox-prev {
            left: 0.25rem;
        }

        #lightbox-next {
            right: 0.25rem;
        }

        .jdgm-rev__header {
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .jdgm-rev__content {
            padding-top: 0.5rem;
        }

        .jdgm-rev__body p {
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .jdgm-rev__header .flex.items-center.gap-3 {
            gap: 0.75rem;
        }

        .jdgm-rev__header .w-12.h-12 {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1rem;
        }
    }

    /* Smaller mobile adjustments */
    @media (max-width: 640px) {
        #gallery-lightbox-modal {
            padding: 0.5rem;
        }

        .jm-mfp-main {
            height: 85vh;
            max-width: 95vw;
        }

        .jm-mfp-review-wrapper {
            max-height: 20vh;
        }

        .jm-mfp-content-wrapper {
            max-height: 50vh;
            min-height: 45vh;
        }

        .jm-mfp-img, #lightbox-main-video {
            max-height: 48vh;
            width: 100%;
            max-width: 100%;
        }

        .jdgm-gallery__thumbnail-wrapper {
            width: 48px !important;
            height: 48px !important;
        }
    }


    /* Navigation arrows styling */
    #lightbox-prev, #lightbox-next {
        transition: all 0.3s ease;
    }

    #lightbox-prev:hover, #lightbox-next:hover {
        transform: scale(1.1);
        background: white;
    }

    /* Reviews Masonry/Column Layout Styles */
    .jdgm-rev-widg__body {
        margin-top: 2rem;
    }

    .jdgm-rev-widg__reviews {
        position: relative;
        margin-top: 1rem;
        width: 100%;
        column-count: 1;
        column-gap: 1.5rem;
        column-fill: balance;
    }

    /* Desktop: 3 Column Layout */
    @media (min-width: 1024px) {
        .jdgm-rev-widg__reviews {
            column-count: 3;
            column-gap: 1.5rem;
            column-fill: balance;
        }
    }

    /* Review Card Styles */
    .jdgm-rev {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        break-inside: avoid;
        display: inline-flex;
        flex-direction: column;
        width: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        page-break-inside: avoid;
        -webkit-column-break-inside: avoid;
    }

    .jdgm-rev:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .jdgm-divider-top {
        border-top: none;
    }

    .jdgm-rev__header {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .jdgm-row-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .jdgm-rev__rating {
        display: inline-flex;
        align-items: center;
        gap: 0.125rem;
    }

    .jdgm-star {
        display: inline-block;
        line-height: 1;
    }

    .jdgm-rev__timestamp {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .jdgm-row-profile {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .jdgm-rev__icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #8b4513, #a0522d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(139, 69, 19, 0.2);
    }

    .jdgm-rev__author-wrapper {
        display: flex;
        align-items: center;
    }

    .jdgm-rev__author {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.9375rem;
    }

    .jdgm-row-extra {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .jdgm-rev__location {
        color: #6b7280;
    }

    .jdgm-rev__br {
        height: 1px;
        background: transparent;
        margin: 0.5rem 0;
    }

    /* Review Pictures */
    .jdgm-rev__pics {
        margin: 1rem 0;
    }

    .jdgm-rev__pic-link {
        display: inline-block;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 2px solid transparent;
    }

    .jdgm-rev__pic-link:hover {
        opacity: 0.9;
        border-color: #8b4513;
        transform: scale(1.02);
    }

    .jdgm-rev__pic-img {
        max-width: 100%;
        width: 100%;
        height: auto;
        max-height: 300px;
        border-radius: 0.5rem;
        object-fit: cover;
        display: block;
    }

    /* Review Content */
    .jdgm-rev__content {
        margin: 1rem 0;
        flex: 1;
    }

    .jdgm-rev__title {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .jdgm-rev__body {
        color: #374151;
        line-height: 1.7;
        font-size: 0.9375rem;
    }

    .jdgm-rev__body p {
        margin: 0;
        word-wrap: break-word;
        white-space: pre-wrap;
    }

    /* Review Actions */
    .jdgm-rev__actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
    }

    .jdgm-rev__social {
        display: flex;
        align-items: center;
    }

    .jdgm-rev__social-inner {
        display: flex;
        gap: 0.5rem;
    }

    .jdgm-rev__share-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #6b7280;
        font-size: 0.875rem;
        background-color: #f9fafb;
    }

    .jdgm-rev__share-btn:hover {
        background-color: #f3f4f6;
        color: #8b4513;
        transform: scale(1.1);
    }

    .jdgm-rev__share-fb:hover {
        background-color: #1877f2;
        color: white;
    }

    .jdgm-rev__share-twitter:hover {
        background-color: #1da1f2;
        color: white;
    }

    .jdgm-rev__share-pinterest:hover {
        background-color: #bd081c;
        color: white;
    }

    .jdgm-rev__votes {
        display: flex;
        align-items: center;
    }

    .jdgm-rev__votes-inner {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Reviews Pagination Styles */
    .reviews-pagination-wrapper {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .reviews-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination-list {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }

    .pagination-item {
        list-style: none;
        margin: 0;
    }

    .pagination-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem 0.75rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.5rem;
        color: #4b5563;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: white;
        cursor: pointer;
    }

    .pagination-link:hover:not(.pagination-link-disabled) {
        background: #f9fafb;
        border-color: #8b4513;
        color: #8b4513;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(139, 69, 19, 0.1);
    }

    .pagination-link-number {
        min-width: 2.5rem;
    }

    .pagination-link-prev,
    .pagination-link-next {
        min-width: 2.5rem;
        padding: 0.5rem;
    }

    .pagination-item-active .pagination-link {
        background: linear-gradient(135deg, #8b4513, #a0522d);
        color: white;
        border-color: #8b4513;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(139, 69, 19, 0.3);
    }

    .pagination-item-disabled .pagination-link {
        color: #d1d5db;
        background: #f9fafb;
        border-color: #e5e7eb;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .pagination-item-disabled .pagination-link:hover {
        transform: none;
        box-shadow: none;
        border-color: #e5e7eb;
        color: #d1d5db;
    }

    .pagination-item-ellipsis .pagination-link {
        border: none;
        background: transparent;
        cursor: default;
        min-width: auto;
        padding: 0.5rem 0.25rem;
    }

    .pagination-item-ellipsis .pagination-link:hover {
        transform: none;
        box-shadow: none;
        background: transparent;
        border: none;
    }

    /* Reviews Count Display */
    .reviews-count-display {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #f9fafb;
        border-radius: 0.5rem;
    }

    .reviews-count-display span {
        display: inline-block;
    }

    .reviews-count-display .font-semibold {
        font-weight: 600;
    }

    @media (max-width: 640px) {
        .reviews-count-display {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
    }

    /* Gallery See More Button */
    .gallery-see-more-btn {
        transition: all 0.3s ease;
    }

    .gallery-see-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
    }


    .jdgm-rev__thumb-btn {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #6b7280;
        transition: all 0.2s ease;
        border-radius: 0.375rem;
        font-size: 0.8125rem;
        background-color: #f9fafb;
    }

    .jdgm-rev__thumb-btn:hover {
        background-color: #f3f4f6;
        color: #8b4513;
        transform: scale(1.1);
    }

    .jdgm-rev__thumb-btn.active {
        color: #8b4513;
        background-color: #fef3e2;
    }

    .jdgm-rev__thumb-count {
        font-size: 0.75rem;
        color: #6b7280;
        min-width: 20px;
        text-align: center;
    }

    /* Mobile adjustments */
    @media (max-width: 1023px) {
        .jdgm-rev {
            padding: 1.25rem;
        }

        .jdgm-rev__pic-img {
            max-width: 100%;
            width: 100%;
            max-height: 250px;
        }

        .jdgm-rev__actions {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .jdgm-rev__header {
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .jdgm-rev__content {
            margin: 0.75rem 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Translation variables
const translations = {
    seeMore: '{{ __("messages.see_more") }}',
    more: '{{ __("messages.more") }}',
    items: '{{ __("messages.items") }}',
    errorLoadingReviews: '{{ __("messages.error_loading_reviews") }}',
    errorLoadingProducts: '{{ __("messages.error_loading_products") }}'
};

document.addEventListener('DOMContentLoaded', function() {
    // Review Form Functionality
    const writeReviewBtn = document.getElementById('write-review-btn');
    const writeReviewBtnMobile = document.getElementById('write-review-btn-mobile');
    const reviewFormWrapper = document.getElementById('review-form-wrapper');
    const closeReviewForm = document.getElementById('close-review-form');
    const cancelReviewFormBtn = document.getElementById('cancel-review-form-btn');
    const categoryReviewForm = document.getElementById('category-review-form');
    const categoryRatingStars = document.querySelectorAll('.category-rating-star');
    const categorySelectedRating = document.getElementById('category-selected-rating');
    const reviewMediaInput = document.getElementById('review_media');
    const mediaPreview = document.getElementById('media-preview');
    const mediaPreviewImg = document.getElementById('media-preview-img');
    const reviewSort = document.getElementById('review-sort');
    const reviewsList = document.getElementById('reviews-list');
    const customerNameInput = document.getElementById('customer_name');
    const anonymousCheckbox = document.getElementById('review_anonymous');

    // Open Review Form Handler
    function openReviewForm() {
        reviewFormWrapper.classList.remove('hidden');
        reviewFormWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Open/Close Review Form
    if (writeReviewBtn) {
        writeReviewBtn.addEventListener('click', openReviewForm);
    }

    if (writeReviewBtnMobile) {
        writeReviewBtnMobile.addEventListener('click', openReviewForm);
    }

    function closeReviewFormFunc() {
        reviewFormWrapper.classList.add('hidden');
        if (categoryReviewForm) {
            categoryReviewForm.reset();
        }
        if (categorySelectedRating) {
            categorySelectedRating.value = '';
        }
        categoryRatingStars.forEach(s => {
            s.querySelector('i').classList.remove('text-yellow-400');
            s.querySelector('i').classList.add('text-gray-300');
        });
        if (mediaPreview) {
            mediaPreview.classList.add('hidden');
        }
        if (anonymousCheckbox) {
            anonymousCheckbox.checked = false;
        }
        if (customerNameInput) {
            customerNameInput.disabled = false;
            customerNameInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
            customerNameInput.value = '';
        }
    }

    if (closeReviewForm) {
        closeReviewForm.addEventListener('click', closeReviewFormFunc);
    }

    if (cancelReviewFormBtn) {
        cancelReviewFormBtn.addEventListener('click', closeReviewFormFunc);
    }

    // Rating Selection
    if (categoryRatingStars.length > 0 && categorySelectedRating) {
        categoryRatingStars.forEach((star) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                categorySelectedRating.value = rating;

                // Update visual display - left to right (1 to 5)
                categoryRatingStars.forEach((s, i) => {
                    const starIndex = i + 1;
                    if (starIndex <= rating) {
                        s.querySelector('i').classList.remove('text-gray-300');
                        s.querySelector('i').classList.add('text-yellow-400');
                    } else {
                        s.querySelector('i').classList.remove('text-yellow-400');
                        s.querySelector('i').classList.add('text-gray-300');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                categoryRatingStars.forEach((s, i) => {
                    const starIndex = i + 1;
                    if (starIndex <= rating) {
                        s.querySelector('i').classList.add('text-yellow-400');
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                if (!categorySelectedRating.value) {
                    categoryRatingStars.forEach(s => {
                        s.querySelector('i').classList.remove('text-yellow-400');
                        s.querySelector('i').classList.add('text-gray-300');
                    });
                } else {
                    const selectedRating = parseInt(categorySelectedRating.value);
                    categoryRatingStars.forEach((s, i) => {
                        const starIndex = i + 1;
                        if (starIndex <= selectedRating) {
                            s.querySelector('i').classList.remove('text-gray-300');
                            s.querySelector('i').classList.add('text-yellow-400');
                        } else {
                            s.querySelector('i').classList.remove('text-yellow-400');
                            s.querySelector('i').classList.add('text-gray-300');
                        }
                    });
                }
            });
        });
    }

    // Handle anonymous checkbox
    if (anonymousCheckbox && customerNameInput) {
        anonymousCheckbox.addEventListener('change', function() {
            if (this.checked) {
                customerNameInput.value = 'Anonymous';
                customerNameInput.disabled = true;
                customerNameInput.classList.add('bg-gray-100', 'cursor-not-allowed');
            } else {
                customerNameInput.value = '';
                customerNameInput.disabled = false;
                customerNameInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                customerNameInput.focus();
            }
        });
    }

    // Media Preview
    if (reviewMediaInput && mediaPreviewImg) {
        reviewMediaInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        mediaPreviewImg.src = e.target.result;
                        if (mediaPreview) {
                            mediaPreview.classList.remove('hidden');
                        }
                    } else if (file.type.startsWith('video/')) {
                        // Could add video preview here if needed
                        if (mediaPreview) {
                            mediaPreview.classList.add('hidden');
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form Submission
    if (categoryReviewForm) {
        categoryReviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!categorySelectedRating || !categorySelectedRating.value) {
                alert('{{ __("messages.please_select_rating") }}');
                return;
            }

            const formData = new FormData(this);

            // Handle anonymous checkbox
            if (anonymousCheckbox && anonymousCheckbox.checked) {
                formData.set('customer_name', 'Anonymous');
                formData.set('display_name', 'Anonymous');
            } else {
                // Ensure customer_name is set
                if (!formData.get('customer_name') || formData.get('customer_name').trim() === '') {
                    if (customerNameInput && customerNameInput.value) {
                        formData.set('customer_name', customerNameInput.value);
                    }
                }
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __("messages.submitting") }}...';

            fetch('{{ route("reviews.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || '{{ __("messages.review_added_successfully") }}');
                    closeReviewFormFunc();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert(data.message || '{{ __("messages.error_adding_review") }}');
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('{{ __("messages.error_adding_review") }}');
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            });
        });
    }

    // Histogram Rating Filter
    const histogramRows = document.querySelectorAll('.jdgm-histogram__row[data-rating]');
    let selectedRating = null;

    histogramRows.forEach(row => {
        row.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');

            if (rating === 'null') {
                // Clear filter
                selectedRating = null;
                histogramRows.forEach(r => {
                    r.classList.remove('jdgm-histogram__row--selected');
                });
            } else {
                // Filter by rating
                selectedRating = parseInt(rating);
                histogramRows.forEach(r => {
                    if (r.getAttribute('data-rating') === rating) {
                        r.classList.add('jdgm-histogram__row--selected');
                    } else {
                        r.classList.remove('jdgm-histogram__row--selected');
                    }
                });
            }

            // Filter reviews
            if (reviewsList) {
                const reviewItems = reviewsList.querySelectorAll('.jdgm-rev.review-item');
                reviewItems.forEach(item => {
                    if (selectedRating === null) {
                        item.style.display = '';
                    } else {
                        const itemRating = parseInt(item.getAttribute('data-rating'));
                        item.style.display = itemRating === selectedRating ? '' : 'none';
                    }
                });
            }

            // Scroll to reviews section
            const reviewsListSection = document.getElementById('reviews-list-section');
            if (reviewsListSection) {
                reviewsListSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Review Sorting
    if (reviewSort && reviewsList) {
        reviewSort.addEventListener('change', function() {
            const sortValue = this.value;
            const reviewItems = Array.from(reviewsList.querySelectorAll('.jdgm-rev.review-item'));

            reviewItems.sort((a, b) => {
                switch(sortValue) {
                    case 'highest-rating':
                        return parseInt(b.getAttribute('data-rating')) - parseInt(a.getAttribute('data-rating'));
                    case 'lowest-rating':
                        return parseInt(a.getAttribute('data-rating')) - parseInt(b.getAttribute('data-rating'));
                    case 'only-pictures':
                        const aHasMedia = a.getAttribute('data-has-media') === 'true';
                        const bHasMedia = b.getAttribute('data-has-media') === 'true';
                        if (aHasMedia && !bHasMedia) return -1;
                        if (!aHasMedia && bHasMedia) return 1;
                        // Both have media or both don't - sort by date
                        return 0;
                    case 'most-recent':
                    default:
                        return 0; // Already sorted by most recent
                }
            });

            reviewItems.forEach(item => reviewsList.appendChild(item));
        });
    }

    // Gallery Grid "See More" Functionality
    const galleryGridContainer = document.getElementById('gallery-thumbnails-grid');
    const galleryGridSeeMoreBtn = document.getElementById('gallery-grid-see-more-btn');
    const galleryGridAllMedia = document.getElementById('gallery-grid-all-media');

    if (galleryGridContainer && galleryGridSeeMoreBtn && galleryGridAllMedia) {
        let gridCurrentlyVisible = 6;
        const gridItemsPerLoad = 6;
        const allGridMediaData = [];

        // Collect all media data from hidden container
        const allGridItems = galleryGridAllMedia.querySelectorAll('div[data-review-id]');
        allGridItems.forEach((item) => {
            const reviewId = parseInt(item.getAttribute('data-review-id'));
            const mediaUrl = item.getAttribute('data-media-url');
            const isVideo = item.getAttribute('data-is-video') === 'true';
            const mediaIndex = parseInt(item.getAttribute('data-media-index'));
            allGridMediaData.push({
                reviewId: reviewId,
                mediaUrl: mediaUrl,
                mediaIndex: mediaIndex,
                isVideo: isVideo
            });
        });

        // Function to create gallery grid thumbnail HTML
        function createGridThumbnailHTML(mediaData, index) {
            const thumbnailContent = mediaData.isVideo
                ? `<video src="${mediaData.mediaUrl}" class="w-full h-full object-cover"></video>`
                : `<img src="${mediaData.mediaUrl}" alt="Review media" class="w-full h-full object-cover">`;

            return `
                <div class="aspect-square rounded-lg overflow-hidden cursor-pointer hover:opacity-80 transition-opacity border border-gray-200 hover:border-brown transition-colors gallery-thumbnail"
                     data-media-index="${index}"
                     data-review-id="${mediaData.reviewId}"
                     data-media-url="${mediaData.mediaUrl}">
                    ${thumbnailContent}
                </div>
            `;
        }

        // Function to load more grid thumbnails
        function loadMoreGridThumbnails() {
            if (!galleryGridContainer || gridCurrentlyVisible >= allGridMediaData.length) {
                if (galleryGridSeeMoreBtn) {
                    galleryGridSeeMoreBtn.style.display = 'none';
                }
                return;
            }

            const nextBatch = allGridMediaData.slice(gridCurrentlyVisible, gridCurrentlyVisible + gridItemsPerLoad);

            nextBatch.forEach((mediaData) => {
                const thumbnailHTML = createGridThumbnailHTML(mediaData, mediaData.mediaIndex);
                galleryGridContainer.insertAdjacentHTML('beforeend', thumbnailHTML);
            });

            gridCurrentlyVisible += nextBatch.length;

            // Update "See More" button
            if (galleryGridSeeMoreBtn) {
                const remaining = allGridMediaData.length - gridCurrentlyVisible;
                if (remaining > 0) {
                    galleryGridSeeMoreBtn.textContent = `${translations.seeMore} (${remaining} ${translations.more})`;
                } else {
                    galleryGridSeeMoreBtn.style.display = 'none';
                }
            }

            // Re-attach click handlers to new thumbnails for gallery modal
            attachGalleryThumbnailHandlers();
        }

        // Attach "See More" button handler
        galleryGridSeeMoreBtn.addEventListener('click', function() {
            loadMoreGridThumbnails();
        });
    }

    // Function to attach click handlers to gallery thumbnails
    function attachGalleryThumbnailHandlers() {
        const galleryThumbnails = document.querySelectorAll('.gallery-thumbnail');
        galleryThumbnails.forEach((thumb) => {
            // Remove existing click listener by cloning
            if (!thumb.hasAttribute('data-handler-attached')) {
                thumb.setAttribute('data-handler-attached', 'true');
                thumb.addEventListener('click', function() {
                    const reviewId = parseInt(this.getAttribute('data-review-id'));
                    if (window.openGalleryFromReview) {
                        window.openGalleryFromReview(reviewId);
                    }
                });
            }
        });
    }

    // Gallery Lightbox Modal Functionality
    const galleryModal = document.getElementById('gallery-lightbox-modal');
    const lightboxMainImage = document.getElementById('lightbox-main-image');
    const lightboxMainVideo = document.getElementById('lightbox-main-video');
    const lightboxReviewContent = document.getElementById('lightbox-review-content');
    const closeGalleryModal = document.getElementById('close-gallery-modal');
    const galleryThumbnailsContainer = document.getElementById('jdgm-gallery-thumbnails');
    const gallerySeeMoreBtn = document.getElementById('gallery-see-more-btn');
    const allMediaReviewsDataContainer = document.getElementById('all-media-reviews-data');

    let currentMediaIndex = 0;
    let itemsPerLoad = 8;
    let currentlyVisible = 0; // Will be set to total count after data is loaded

    // Store ALL media reviews data (not just visible ones)
    const mediaReviewsData = [];

    // Collect ALL media reviews data from hidden container
    if (allMediaReviewsDataContainer) {
        const allMediaItems = allMediaReviewsDataContainer.querySelectorAll('div[data-review-id]');
        allMediaItems.forEach((item, index) => {
            const reviewId = parseInt(item.getAttribute('data-review-id'));
            const mediaUrl = item.getAttribute('data-media-url');
            const isVideo = item.getAttribute('data-is-video') === 'true';
            mediaReviewsData.push({
                reviewId: reviewId,
                mediaUrl: mediaUrl,
                mediaIndex: index,
                isVideo: isVideo
            });
        });
        // All thumbnails are now visible at once
        currentlyVisible = mediaReviewsData.length;
    }

    // Function to create thumbnail HTML
    function createThumbnailHTML(mediaData, index, isCurrent = false) {
        const currentClass = isCurrent ? 'jdgm-gallery__thumbnail-link--current border-brown' : 'border-transparent';
        const isVideo = mediaData.isVideo || (mediaData.mediaUrl && (mediaData.mediaUrl.includes('.mp4') || mediaData.mediaUrl.includes('.mov') || mediaData.mediaUrl.includes('.m4v')));

        const thumbnailContent = isVideo
            ? `<video src="${mediaData.mediaUrl}" class="jdgm-gallery__thumbnail w-full h-full object-cover"></video>`
            : `<img src="${mediaData.mediaUrl}" alt="User picture" class="jdgm-gallery__thumbnail w-full h-full object-cover" data-mfp-src="${mediaData.mediaUrl}">`;

        return `
            <div class="jdgm-gallery__thumbnail-link flex-shrink-0 cursor-pointer border-2 ${currentClass} hover:border-brown transition-colors rounded-lg overflow-hidden"
                 data-media-index="${index}"
                 data-review-id="${mediaData.reviewId}"
                 data-media-url="${mediaData.mediaUrl}">
                <div class="jdgm-gallery__thumbnail-wrapper w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24">
                    ${thumbnailContent}
                </div>
            </div>
        `;
    }

    // Function to load more thumbnails
    function loadMoreThumbnails() {
        if (!galleryThumbnailsContainer || currentlyVisible >= mediaReviewsData.length) {
            if (gallerySeeMoreBtn) {
                gallerySeeMoreBtn.style.display = 'none';
            }
            return;
        }

        const nextBatch = mediaReviewsData.slice(currentlyVisible, currentlyVisible + itemsPerLoad);

        nextBatch.forEach((mediaData, idx) => {
            const index = currentlyVisible + idx;
            const isCurrent = index === currentMediaIndex;
            const thumbnailHTML = createThumbnailHTML(mediaData, index, isCurrent);
            galleryThumbnailsContainer.insertAdjacentHTML('beforeend', thumbnailHTML);
        });

        currentlyVisible += nextBatch.length;

        // Update "See More" button
        if (gallerySeeMoreBtn) {
            const remaining = mediaReviewsData.length - currentlyVisible;
            if (remaining > 0) {
                    gallerySeeMoreBtn.textContent = `${translations.seeMore} (${remaining} ${translations.more})`;
            } else {
                gallerySeeMoreBtn.style.display = 'none';
            }
        }

        // Re-attach click handlers to new thumbnails
        attachThumbnailHandlers();
    }

    // Function to attach click handlers to lightbox thumbnails
    function attachThumbnailHandlers() {
        const lightboxThumbnails = document.querySelectorAll('#gallery-lightbox-modal .jdgm-gallery__thumbnail-link');
        lightboxThumbnails.forEach((thumb) => {
            // Remove existing listeners by cloning
            if (!thumb.hasAttribute('data-handler-attached')) {
                thumb.setAttribute('data-handler-attached', 'true');
                thumb.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-media-index'));
                    updateLightbox(index);
                });
            }
        });
    }

    // "See More" button removed - all thumbnails are displayed at once

    // Initialize: attach handlers to initial thumbnails
    attachThumbnailHandlers();

    // Create a map for quick lookup by review ID for gallery thumbnails
    const mediaByReviewId = {};
    mediaReviewsData.forEach((item, idx) => {
        mediaByReviewId[item.reviewId] = idx;
    });

    // Function to load review content
    function loadReviewContent(reviewId) {
        if (window.reviewsData && window.reviewsData[reviewId]) {
            const review = window.reviewsData[reviewId];
            const isVideo = review.media && (review.media.includes('.mp4') || review.media.includes('.mov') || review.media.includes('.m4v'));

            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<span class="jdgm-star jdgm--${i <= review.rating ? 'on' : 'off'}"><i class="fas fa-star ${i <= review.rating ? 'text-yellow-400' : 'text-gray-300'} text-sm"></i></span>`;
            }

            lightboxReviewContent.innerHTML = `
                <div class="jdgm-rev__header mb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-brown rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                            ${review.name.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">${review.name}</div>
                            <div class="text-gray-500 text-sm">${review.date}</div>
                        </div>
                    </div>
                    <div class="jdgm-row-rating flex items-center gap-2 mb-3">
                        <span class="jdgm-rev__rating flex items-center gap-0.5" data-score="${review.rating}" aria-label="${review.rating} star review" role="img">
                            ${starsHtml}
                        </span>
                        <span class="jdgm-rev__timestamp text-gray-500 text-sm">${review.date}</span>
                    </div>
                </div>
                <div class="jdgm-rev__content">
                    ${review.title ? `<h4 class="font-semibold text-gray-900 mb-2">${review.title}</h4>` : ''}
                    <div class="jdgm-rev__body">
                        <p class="text-gray-700">${review.text}</p>
                    </div>
                </div>
            `;
        }
    }

    // Function to ensure thumbnail is visible (load if needed)
    function ensureThumbnailVisible(index) {
        if (index >= currentlyVisible) {
            // Need to load more thumbnails
            while (currentlyVisible <= index && currentlyVisible < mediaReviewsData.length) {
                loadMoreThumbnails();
            }
        }
    }

    // Function to update lightbox with selected media
    function updateLightbox(index) {
        if (index < 0 || index >= mediaReviewsData.length) return;

        // Ensure thumbnail is loaded
        ensureThumbnailVisible(index);

        currentMediaIndex = index;
        const mediaData = mediaReviewsData[index];
        const isVideo = mediaData.isVideo || (mediaData.mediaUrl && (mediaData.mediaUrl.includes('.mp4') || mediaData.mediaUrl.includes('.mov') || mediaData.mediaUrl.includes('.m4v')));

        // Update main image/video
        if (isVideo) {
            lightboxMainVideo.src = mediaData.mediaUrl;
            lightboxMainVideo.classList.remove('hidden');
            lightboxMainImage.classList.add('hidden');
            lightboxMainVideo.load(); // Reload video
        } else {
            lightboxMainImage.src = mediaData.mediaUrl;
            lightboxMainImage.classList.remove('hidden');
            lightboxMainVideo.classList.add('hidden');
            lightboxMainVideo.pause(); // Pause video if switching to image
        }

        // Update thumbnail selection
        const lightboxThumbnails = document.querySelectorAll('#gallery-lightbox-modal .jdgm-gallery__thumbnail-link');
        lightboxThumbnails.forEach((thumb) => {
            const thumbIndex = parseInt(thumb.getAttribute('data-media-index'));
            if (thumbIndex === index) {
                thumb.classList.add('jdgm-gallery__thumbnail-link--current', 'border-brown');
                thumb.classList.remove('border-transparent');
                // Scroll thumbnail into view
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                thumb.classList.remove('jdgm-gallery__thumbnail-link--current', 'border-brown');
                thumb.classList.add('border-transparent');
            }
        });

        // Load review content
        loadReviewContent(mediaData.reviewId);
    }

    // Initialize lightbox with first image when modal is first opened
    let lightboxInitialized = false;
    function initializeLightbox() {
        if (!lightboxInitialized && mediaReviewsData.length > 0) {
            updateLightbox(0);
            lightboxInitialized = true;
        }
    }

    // Initialize when modal opens
    if (galleryModal) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const isVisible = !galleryModal.classList.contains('hidden');
                    if (isVisible && !lightboxInitialized) {
                        // Use setTimeout to ensure DOM is ready
                        setTimeout(function() {
                            // Reset scroll position to start from the left
                            if (galleryThumbnailsContainer) {
                                galleryThumbnailsContainer.scrollLeft = 0;
                            }
                            initializeLightbox();
                            // Re-attach handlers to ensure all thumbnails are clickable
                            attachThumbnailHandlers();
                        }, 10);
                    }
                    if (!isVisible) {
                        lightboxInitialized = false; // Reset on close
                        // Reset scroll position when modal closes
                        if (galleryThumbnailsContainer) {
                            galleryThumbnailsContainer.scrollLeft = 0;
                        }
                    }
                }
            });
        });
        observer.observe(galleryModal, { attributes: true });
    }

    // Attach handlers to initial gallery thumbnails
    attachGalleryThumbnailHandlers();

    // Open lightbox when clicking lightbox thumbnails
    // Thumbnail click handlers are now attached via attachThumbnailHandlers()

    // Close lightbox
    function closeLightbox() {
        if (galleryModal) {
            galleryModal.classList.add('hidden');
            galleryModal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    if (closeGalleryModal) {
        closeGalleryModal.addEventListener('click', closeLightbox);
    }

    // Close on background click
    if (galleryModal) {
        galleryModal.addEventListener('click', function(e) {
            if (e.target === galleryModal) {
                closeLightbox();
            }
        });
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && galleryModal && !galleryModal.classList.contains('hidden')) {
            closeLightbox();
        }
    });

    // Navigation arrows
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');

    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function() {
            if (currentMediaIndex > 0) {
                updateLightbox(currentMediaIndex - 1);
            }
        });
    }

    if (lightboxNext) {
        lightboxNext.addEventListener('click', function() {
            if (currentMediaIndex < mediaReviewsData.length - 1) {
                updateLightbox(currentMediaIndex + 1);
            }
        });
    }

    // Keyboard navigation (arrow keys)
    document.addEventListener('keydown', function(e) {
        if (galleryModal && !galleryModal.classList.contains('hidden')) {
            if (e.key === 'ArrowLeft' && currentMediaIndex > 0) {
                updateLightbox(currentMediaIndex - 1);
            } else if (e.key === 'ArrowRight' && currentMediaIndex < mediaReviewsData.length - 1) {
                updateLightbox(currentMediaIndex + 1);
            }
        }
    });

    // Function to open gallery from review image
    window.openGalleryFromReview = function(reviewId) {
        const reviewIdNum = parseInt(reviewId);
        // Find the review's media index using mediaByReviewId map
        const mediaIndex = mediaByReviewId[reviewIdNum];

        if (mediaIndex !== undefined) {
            currentMediaIndex = mediaIndex;
            if (galleryModal) {
                galleryModal.classList.remove('hidden');
                galleryModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    updateLightbox(mediaIndex);
                }, 50);
            }
        }
    };

    // Re-attach handlers when new grid thumbnails are loaded
    if (galleryGridContainer) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length > 0) {
                    attachGalleryThumbnailHandlers();
                }
            });
        });
        observer.observe(galleryGridContainer, { childList: true });
    }

    // Social Share Buttons (delegated event listener for dynamically loaded reviews)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.jdgm-rev__share-btn')) {
            const btn = e.target.closest('.jdgm-rev__share-btn');
            const socialMedia = btn.getAttribute('data-social-media');
            const reviewItem = btn.closest('.jdgm-rev');
            const reviewText = reviewItem ? reviewItem.querySelector('.jdgm-rev__body p')?.textContent : '';
            const reviewAuthor = reviewItem ? reviewItem.querySelector('.jdgm-rev__author')?.textContent : '';

            const url = window.location.href;
            const text = `${reviewAuthor}: ${reviewText.substring(0, 100)}...`;
            let shareUrl = '';

            switch(socialMedia) {
                case 'Facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                    break;
                case 'Twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
                    break;
                case 'Pinterest':
                    const imageUrl = reviewItem ? reviewItem.querySelector('.jdgm-rev__pic-img')?.src : '';
                    shareUrl = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(url)}&description=${encodeURIComponent(text)}&media=${encodeURIComponent(imageUrl || '')}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }
    });

    // Thumbs Up/Down Voting (delegated event listener)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.jdgm-rev__thumb-btn')) {
            const btn = e.target.closest('.jdgm-rev__thumb-btn');
            const voteType = btn.getAttribute('data-thumb-vote');
            const reviewItem = btn.closest('.jdgm-rev');
            const countElement = voteType === 'up'
                ? reviewItem.querySelector('.jdgm-rev_thump-up-count')
                : reviewItem.querySelector('.jdgm-rev_thump-down-count');

            // Toggle active state
            const isActive = btn.classList.contains('active');
            if (isActive) {
                btn.classList.remove('active');
                const currentCount = parseInt(countElement.textContent) || 0;
                countElement.textContent = Math.max(0, currentCount - 1);
            } else {
                // Remove active from opposite button
                const oppositeBtn = voteType === 'up'
                    ? reviewItem.querySelector('.jdgm-rev_thumb-down')
                    : reviewItem.querySelector('.jdgm-rev_thumb-up');
                if (oppositeBtn) {
                    oppositeBtn.classList.remove('active');
                    const oppositeCountElement = voteType === 'up'
                        ? reviewItem.querySelector('.jdgm-rev_thump-down-count')
                        : reviewItem.querySelector('.jdgm-rev_thump-up-count');
                    if (oppositeCountElement) {
                        const oppositeCount = parseInt(oppositeCountElement.textContent) || 0;
                        oppositeCountElement.textContent = Math.max(0, oppositeCount - 1);
                    }
                }

                btn.classList.add('active');
                const currentCount = parseInt(countElement.textContent) || 0;
                countElement.textContent = currentCount + 1;
            }

            // Here you could make an AJAX call to save the vote
            // const reviewId = reviewItem.getAttribute('data-review-id');
            // fetch('/api/reviews/' + reviewId + '/vote', { ... });
        }
    });
    });

    // Reviews AJAX Pagination
    const reviewsPaginationWrapper = document.getElementById('reviews-pagination');
    const reviewsListContainer = document.getElementById('reviews-list');
    const reviewsListSection = document.getElementById('reviews-list-section');

    if (reviewsPaginationWrapper) {
        // Handle pagination clicks
        reviewsPaginationWrapper.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination-link');
            if (!link || link.classList.contains('pagination-link-disabled') || link.tagName === 'SPAN') {
                return;
            }

            e.preventDefault();

            const url = link.getAttribute('href');
            if (!url) return;

            // Show loading state
            reviewsListContainer.style.opacity = '0.5';
            reviewsListContainer.style.pointerEvents = 'none';

            // Extract page number from URL
            const urlObj = new URL(url);
            const page = urlObj.searchParams.get('page') || 1;

            // Build AJAX URL
            const ajaxUrl = new URL(window.location);
            ajaxUrl.searchParams.set('reviews_page', page);

            // Make AJAX request
            fetch(ajaxUrl.toString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Update reviews list
                reviewsListContainer.innerHTML = data.html;

                // Update pagination
                if (reviewsPaginationWrapper) {
                    reviewsPaginationWrapper.innerHTML = data.pagination;
                }

                // Update reviews count display
                const reviewsCountDisplay = document.getElementById('reviews-count-display');
                if (reviewsCountDisplay && data.count_display) {
                    reviewsCountDisplay.innerHTML = data.count_display;
                }

                // Update URL without reload
                window.history.pushState({}, '', url);

                // Scroll to reviews section smoothly with offset
                if (reviewsListSection) {
                    const offset = 80; // Offset for fixed headers/navbar
                    const elementPosition = reviewsListSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }

                // Restore opacity
                reviewsListContainer.style.opacity = '1';
                reviewsListContainer.style.pointerEvents = 'auto';

                // Update reviews data for JavaScript (if needed for gallery)
                // This might need to be re-initialized if gallery uses review data
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
                reviewsListContainer.style.opacity = '1';
                reviewsListContainer.style.pointerEvents = 'auto';
                alert(translations.errorLoadingReviews);
            });
        });
    }
</script>
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
        const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';
        const min = parseInt(minRange.value);
        const max = parseInt(maxRange.value);
        const minPercent = (min / 1000) * 100;
        const maxPercent = (max / 1000) * 100;

        if (isRTL) {
            // In RTL, use right instead of left
            progress.style.right = minPercent + '%';
            progress.style.left = 'auto';
            progress.style.width = (maxPercent - minPercent) + '%';
        } else {
            // In LTR, use left
            progress.style.left = minPercent + '%';
            progress.style.right = 'auto';
            progress.style.width = (maxPercent - minPercent) + '%';
        }
    }
}

// Toggle filter sidebar
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
    const selectedColors = Array.from(document.querySelectorAll('.color-filter:checked')).map(cb => cb.value);
    const selectedSizes = Array.from(document.querySelectorAll('.size-filter:checked')).map(cb => cb.value);
    const sortBy = document.getElementById('sortBy').value;

    // Build URL with filters
    const url = new URL(window.location);
    url.searchParams.set('min_price', minPrice);
    url.searchParams.set('max_price', maxPrice);
    url.searchParams.set('sort', sortBy);

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
        showNotification(translations.errorLoadingProducts + ': ' + error.message, 'error');
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
        countElement.textContent = count + ' ' + translations.items;
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
            // Open cart sidebar after adding to cart
            if (typeof openCartSidebar === 'function') {
                openCartSidebar();
            }
        } else {
            showNotification(data.message || 'Error adding to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart', 'error');
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
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
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
