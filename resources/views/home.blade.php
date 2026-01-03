@extends('layouts.app')

@section('title', __('messages.welcome'))

@section('content')
    <!-- Enhanced Hero Section with Parallax -->
    <section
        class="relative h-[60vh] min-h-[450px] sm:h-[60vh] flex items-center justify-center overflow-hidden hero-section">
        <!-- Background Images Carousel with Parallax -->
        <div class="absolute inset-0 z-0 hero-background">
            @if ($heroImages->count() > 0)
                @foreach ($heroImages as $index => $image)
                    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                        style="background-image: url('{{ asset('storage/' . $image->image_path) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    </div>
                @endforeach
            @else
                <!-- Fallback images if no hero images are configured -->
                <div class="hero-slide active"
                    style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>
                <div class="hero-slide"
                    style="background-image: url('https://images.unsplash.com/photo-1469334031218-e382a71b716b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>
                <div class="hero-slide"
                    style="background-image: url('https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>
                <div class="hero-slide"
                    style="background-image: url('https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                </div>
            @endif
        </div>

        <!-- Animated Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/60 z-10 hero-overlay"></div>

        <!-- Animated Particles Background -->
        <div class="absolute inset-0 z-5 particles-container">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <!-- Content with Enhanced Animations -->
        <div class="absolute bottom-16 sm:bottom-28 left-0 right-0 z-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="hero-content animate-fade-in-up">
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 text-white drop-shadow-lg hero-title">
                    <span class="inline-block animate-slide-in-left">{{ __('messages.business_name') }}</span>
                </h1>
                <p class="text-white/90 text-lg sm:text-xl mb-6 drop-shadow-md">
                    {{ __('messages.business_name_full') }}
                </p>
                <!-- CTA Buttons with Stagger Animation -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center hero-buttons">
                    <a href="{{ route('products.index') }}"
                        class="group hero-btn-primary inline-flex items-center bg-white text-brown px-8 py-3 lg:px-10 lg:py-4 rounded-full text-base lg:text-lg font-bold hover:bg-brown hover:text-white transition-all duration-300 transform hover:scale-110 shadow-2xl hover:shadow-brown/50">
                        <i
                            class="fas fa-shopping-bag {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }} group-hover:animate-bounce"></i>
                        {{ __('messages.shop_now') }}
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="group hero-btn-secondary inline-flex items-center bg-transparent border-2 border-white text-white px-8 py-3 lg:px-10 lg:py-4 rounded-full text-base lg:text-lg font-bold hover:bg-white hover:text-brown transition-all duration-300 transform hover:scale-110 backdrop-blur-sm">
                        <i
                            class="fas fa-th-large {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }} group-hover:rotate-12 transition-transform duration-300"></i>
                        {{ __('messages.categories') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern Carousel Indicators -->
        <div
            class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-20 flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
            @if ($heroImages->count() > 0)
                @foreach ($heroImages as $index => $image)
                    <button
                        class="carousel-dot {{ $index === 0 ? 'active' : '' }} w-8 h-1 rounded-full transition-all duration-300"
                        data-slide="{{ $index }}"
                        style="opacity: {{ $index === 0 ? '1' : '0.5' }}; background-color: {{ $index === 0 ? 'white' : 'rgba(255, 255, 255, 0.5)' }};"></button>
                @endforeach
            @else
                <!-- Fallback indicators -->
                <button class="carousel-dot active w-8 h-1 rounded-full transition-all duration-300" data-slide="0"
                    style="opacity: 1; background-color: white;"></button>
                <button class="carousel-dot w-8 h-1 rounded-full transition-all duration-300" data-slide="1"
                    style="opacity: 0.5; background-color: rgba(255, 255, 255, 0.5);"></button>
                <button class="carousel-dot w-8 h-1 rounded-full transition-all duration-300" data-slide="2"
                    style="opacity: 0.5; background-color: rgba(255, 255, 255, 0.5);"></button>
                <button class="carousel-dot w-8 h-1 rounded-full transition-all duration-300" data-slide="3"
                    style="opacity: 0.5; background-color: rgba(255, 255, 255, 0.5);"></button>
            @endif
        </div>
    </section>

    <!-- Categories Section with Scroll Animation -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brown/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-brown/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12 scroll-fade-in">
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 gradient-text animate-title-in">
                    {{ __('messages.categories') }}
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto animate-subtitle-in">
                    {{ __('messages.choose_from_collection') }}
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10">
                @foreach ($categories as $index => $category)
                    <div class="group cursor-pointer category-item" data-index="{{ $index }}">
                        <a href="{{ route('categories.show', $category->slug) }}">
                            <div
                                class="category-card bg-white rounded-3xl overflow-hidden group-hover:shadow-2xl transition-all duration-500 border border-gray-100 relative">
                                <!-- Category Image -->
                                <div class="relative h-48 sm:h-56 overflow-hidden">
                                    <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/600x750/FFC0CB/FFFFFF?text=' . urlencode($category->name) }}"
                                        alt="{{ $category->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 aspect-[2/3]">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <h3
                                            class="text-xl sm:text-2xl font-bold text-white mb-2 group-hover:text-brown/70 transition-colors duration-300">
                                            {{ $category->name }}
                                        </h3>
                                        <p class="text-white/90 text-sm sm:text-base leading-relaxed">
                                            {{ $category->description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Category Content -->
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                                            <div
                                                class="w-8 h-8 bg-circle-gradient rounded-full flex items-center justify-center">
                                                <i class="fas fa-tshirt text-white text-sm"></i>
                                            </div>
                                            <span class="text-sm text-gray-500 font-medium">
                                                {{ $category->products->count() }} {{ __('messages.products_count') }}
                                            </span>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <span class="inline-flex items-center text-brown font-semibold text-sm">
                                                {{ __('messages.explore_now') }}
                                                <i
                                                    class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }} group-hover:translate-x-{{ app()->getLocale() === 'ar' ? '-1' : '1' }} transition-transform duration-300"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products with Scroll Animation -->
    <section class="py-16 sm:py-20 lg:py-24 bg-white relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-1/2 left-0 w-72 h-72 bg-brown/5 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2">
        </div>
        <div class="absolute top-1/2 right-0 w-72 h-72 bg-brown/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header with Navigation -->
            <div class="flex items-center justify-between mb-8 scroll-fade-in">
                <div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold mb-2 gradient-text animate-title-in">
                        {{ __('messages.featured_products') }}
                    </h2>
                </div>
                <div
                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                    <a href="{{ route('products.index', ['featured' => 'true']) }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 bg-brown text-white rounded-lg hover:bg-brown-darker transition-all duration-300 transform hover:scale-105 text-sm font-semibold">
                        {{ __('messages.show_more') }}
                        <i
                            class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}"></i>
                    </a>
                    <div class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                        <button id="featuredPrev"
                            class="featured-carousel-nav w-8 h-8 sm:w-10 sm:h-10 bg-brown text-white rounded-full flex items-center justify-center hover:bg-brown-darker transition-all duration-300 transform hover:scale-110 opacity-80 hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed"
                            aria-label="Previous">
                            <i
                                class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs sm:text-sm"></i>
                        </button>
                        <button id="featuredNext"
                            class="featured-carousel-nav w-8 h-8 sm:w-10 sm:h-10 bg-brown text-white rounded-full flex items-center justify-center hover:bg-brown-darker transition-all duration-300 transform hover:scale-110 opacity-80 hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed"
                            aria-label="Next">
                            <i
                                class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} text-xs sm:text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Carousel Container -->
            <div class="products-carousel-container overflow-x-hidden overflow-y-hidden">
                <div id="featuredCarousel" class="flex transition-transform duration-500 ease-in-out gap-4 sm:gap-6">
                    @foreach ($featuredProducts as $index => $product)
                        @php
                            // Get images for hover effect
                            $colorImages = $product->colorImages;
                            $mainImage = $product->main_image
                                ? asset('storage/' . $product->main_image)
                                : 'https://via.placeholder.com/500x600/FFC0CB/FFFFFF?text=' . urlencode($product->name);
                            $hoverImage =
                                $colorImages->count() > 1
                                    ? asset('storage/' . $colorImages[1]->image_path)
                                    : $mainImage;
                        @endphp
                        <div class="product-card flex-shrink-0 overflow-hidden group transition-all duration-500 product-item featured-product-card"
                            data-index="{{ $index }}">
                            <div class="relative overflow-hidden">
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="product-image-container block">
                                    <img src="{{ $mainImage }}" alt="{{ $product->name }}"
                                        class="{{ $colorImages->count() > 1 ? '' : 'group-hover:scale-110 transition-transform duration-700 ease-out' }}">
                                    @if ($colorImages->count() > 1)
                                        <img src="{{ $hoverImage }}" alt=""
                                            class="opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out">
                                    @endif
                                </a>
                                @if ($product->sale_price)
                                    @php
                                        $discountPercentage = round(
                                            (($product->price - $product->sale_price) / $product->price) * 100,
                                        );
                                    @endphp
                                    <div
                                        class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold shadow-lg transform -rotate-3 hover:rotate-0 transition-transform duration-300 border border-white sm:border-2 border-white z-10">
                                        <span class="relative z-10">-{{ $discountPercentage }}%</span>
                                    </div>
                                @endif

                                @if ($product->stock_quantity <= 0)
                                    <div
                                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-gray-800 text-white px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold shadow-lg transform rotate-3 hover:rotate-0 transition-transform duration-300 border border-white sm:border-2 border-white z-10">
                                        <span class="relative z-10">{{ __('messages.out_of_stock') }}</span>
                                    </div>
                                @endif

                                <!-- Overlay Buttons - Show on mobile always, desktop on hover -->
                                <div class="product-featured-icons product-featured-icons--primary">
                                    <button
                                        onclick="{{ $product->stock_quantity <= 0 ? 'javascript:void(0)' : 'addToCart(' . $product->id . ')' }}"
                                        class="button add_to_cart_button ecomus-button product-loop-button product-loop-button-atc flex items-center justify-center em-button-light em-button-icon em-tooltip {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}
                                        data-product_id="{{ $product->id }}"
                                        aria-label="{{ __('messages.add_to_cart') }}: {{ $product->name }}"
                                        data-tooltip="{{ __('messages.add_to_cart') }}">
                                        <span
                                            class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--shopping-bag">
                                            <svg width="20" height="20" aria-hidden="true" role="img"
                                                focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <a href="{{ route('products.show', $product->slug) }}"
                                        class="ecomus-quickview-button button product-loop-button flex items-center justify-center em-button-icon em-tooltip em-button-light"
                                        data-id="{{ $product->id }}" data-tooltip="{{ __('messages.quick_view') }}"
                                        aria-label="{{ __('messages.quick_view') }} {{ $product->name }}"
                                        rel="nofollow">
                                        <span class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--eye">
                                            <svg width="20" height="20" aria-hidden="true" role="img"
                                                focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <h3
                                        class="text-base font-normal text-brown mb-2 line-clamp-2 hover:opacity-80 transition-opacity cursor-pointer">
                                        {{ $product->name }}</h3>
                                </a>
                                <div
                                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                                    @if ($product->sale_price)
                                        <span
                                            class="text-base font-semibold text-red-500">{{ number_format($product->sale_price, 2) }}
                                            DH</span>
                                        <span
                                            class="text-sm text-gray-500 line-through">{{ number_format($product->price, 2) }}
                                            DH</span>
                                    @else
                                        <span
                                            class="text-base font-semibold text-brown">{{ number_format($product->price, 2) }}
                                            DH</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals with Scroll Animation -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-1/2 w-96 h-96 bg-brown/5 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header with Navigation -->
            <div class="flex items-center justify-between mb-8 scroll-fade-in">
                <div>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold mb-2 gradient-text animate-title-in">
                        {{ __('messages.new_arrivals') }}
                    </h2>
                </div>
                <div
                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                    <a href="{{ route('products.index', ['new' => 'true']) }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 bg-brown text-white rounded-lg hover:bg-brown-darker transition-all duration-300 transform hover:scale-105 text-sm font-semibold">
                        {{ __('messages.show_more') }}
                        <i
                            class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}"></i>
                    </a>
                    <div class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                        <button id="newArrivalsPrev"
                            class="new-arrivals-carousel-nav w-8 h-8 sm:w-10 sm:h-10 bg-brown text-white rounded-full flex items-center justify-center hover:bg-brown-darker transition-all duration-300 transform hover:scale-110 opacity-80 hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed"
                            aria-label="Previous">
                            <i
                                class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs sm:text-sm"></i>
                        </button>
                        <button id="newArrivalsNext"
                            class="new-arrivals-carousel-nav w-8 h-8 sm:w-10 sm:h-10 bg-brown text-white rounded-full flex items-center justify-center hover:bg-brown-darker transition-all duration-300 transform hover:scale-110 opacity-80 hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed"
                            aria-label="Next">
                            <i
                                class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} text-xs sm:text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Carousel Container -->
            <div class="products-carousel-container overflow-x-hidden overflow-y-hidden">
                <div id="newArrivalsCarousel" class="flex transition-transform duration-500 ease-in-out gap-4 sm:gap-6">
                    @foreach ($newProducts as $index => $product)
                        @php
                            // Get images for hover effect
                            $colorImages = $product->colorImages;
                            $mainImage = $product->main_image
                                ? asset('storage/' . $product->main_image)
                                : 'https://via.placeholder.com/500x600/FFC0CB/FFFFFF?text=' . urlencode($product->name);
                            $hoverImage =
                                $colorImages->count() > 1
                                    ? asset('storage/' . $colorImages[1]->image_path)
                                    : $mainImage;
                        @endphp
                        <div class="product-card flex-shrink-0 overflow-hidden group transition-all duration-500 product-item new-arrivals-product-card"
                            data-index="{{ $index }}">
                            <div class="relative overflow-hidden">
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="product-image-container block">
                                    <img src="{{ $mainImage }}" alt="{{ $product->name }}"
                                        class="{{ $colorImages->count() > 1 ? '' : 'group-hover:scale-110 transition-transform duration-700 ease-out' }}">
                                    @if ($colorImages->count() > 1)
                                        <img src="{{ $hoverImage }}" alt=""
                                            class="opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out">
                                    @endif
                                </a>
                                @if ($product->sale_price)
                                    @php
                                        $discountPercentage = round(
                                            (($product->price - $product->sale_price) / $product->price) * 100,
                                        );
                                    @endphp
                                    <div
                                        class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold shadow-lg transform -rotate-3 hover:rotate-0 transition-transform duration-300 border border-white sm:border-2 border-white z-10">
                                        <span class="relative z-10">-{{ $discountPercentage }}%</span>
                                    </div>
                                @endif
                                @if ($product->stock_quantity <= 0)
                                    <div
                                        class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-gray-800 text-white px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold shadow-lg transform rotate-3 hover:rotate-0 transition-transform duration-300 border border-white sm:border-2 border-white z-10">
                                        <span class="relative z-10">{{ __('messages.out_of_stock') }}</span>
                                    </div>
                                @endif
                                <!-- Overlay Buttons - Show on mobile always, desktop on hover -->
                                <div class="product-featured-icons product-featured-icons--primary">
                                    <button
                                        onclick="{{ $product->stock_quantity <= 0 ? 'javascript:void(0)' : 'addToCart(' . $product->id . ')' }}"
                                        class="button add_to_cart_button ecomus-button product-loop-button product-loop-button-atc flex items-center justify-center em-button-light em-button-icon em-tooltip {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}
                                        data-product_id="{{ $product->id }}"
                                        aria-label="{{ __('messages.add_to_cart') }}: {{ $product->name }}"
                                        data-tooltip="{{ __('messages.add_to_cart') }}">
                                        <span
                                            class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--shopping-bag">
                                            <svg width="20" height="20" aria-hidden="true" role="img"
                                                focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <a href="{{ route('products.show', $product->slug) }}"
                                        class="ecomus-quickview-button button product-loop-button flex items-center justify-center em-button-icon em-tooltip em-button-light"
                                        data-id="{{ $product->id }}" data-tooltip="{{ __('messages.quick_view') }}"
                                        aria-label="{{ __('messages.quick_view') }} {{ $product->name }}"
                                        rel="nofollow">
                                        <span class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--eye">
                                            <svg width="20" height="20" aria-hidden="true" role="img"
                                                focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <h3
                                        class="text-base font-normal text-brown mb-2 line-clamp-2 hover:opacity-80 transition-opacity cursor-pointer">
                                        {{ $product->name }}</h3>
                                </a>
                                <div
                                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                                    @if ($product->sale_price)
                                        <span
                                            class="text-base font-semibold text-red-500">{{ number_format($product->sale_price, 2) }}
                                            DH</span>
                                        <span
                                            class="text-sm text-gray-500 line-through">{{ number_format($product->price, 2) }}
                                            DH</span>
                                    @else
                                        <span
                                            class="text-base font-semibold text-brown">{{ number_format($product->price, 2) }}
                                            DH</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Show More Button (Mobile) -->
            <div class="text-center mt-8 sm:hidden">
                <a href="{{ route('products.index', ['new' => 'true']) }}"
                    class="inline-flex items-center px-6 py-3 bg-brown text-white rounded-lg hover:bg-brown-darker transition-all duration-300 transform hover:scale-105 font-semibold">
                    {{ __('messages.show_more') }}
                    <i
                        class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- <!-- About/Our Story Section -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50 relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brown/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-brown/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center scroll-fade-in">
                <div>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 gradient-text animate-title-in">
                        {{ __('messages.our_story') }}
                    </h2>
                    <div class="space-y-4 text-gray-700 text-lg leading-relaxed">
                        <p class="animate-subtitle-in">
                            {{ __('messages.our_story_text_1') }}
                        </p>
                        <p class="animate-subtitle-in" style="animation-delay: 0.2s;">
                            {{ __('messages.our_story_text_2') }}
                        </p>
                        <p class="animate-subtitle-in" style="animation-delay: 0.4s;">
                            {{ __('messages.our_story_text_3') }}
                        </p>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <div
                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} bg-white px-4 py-3 rounded-lg shadow-md">
                            <i class="fas fa-tshirt text-brown text-xl"></i>
                            <span class="text-gray-700 font-medium">{{ __('messages.handmade') }}</span>
                        </div>
                        <div
                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} bg-white px-4 py-3 rounded-lg shadow-md">
                            <i class="fas fa-heart text-brown text-xl"></i>
                            <span class="text-gray-700 font-medium">{{ __('messages.authentic') }}</span>
                        </div>
                        <div
                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} bg-white px-4 py-3 rounded-lg shadow-md">
                            <i class="fas fa-globe text-brown text-xl"></i>
                            <span class="text-gray-700 font-medium">{{ __('messages.worldwide_shipping') }}</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <!-- 3-Image Staggered Vertical Layout (Memories Style) -->
                    <div class="flex flex-col gap-4 sm:gap-5 relative">
                        <!-- Image 1: Right Position -->
                        <div
                            class="relative ml-auto w-[70%] sm:w-[65%] transform rotate-2 hover:rotate-3 hover:scale-105 transition-all duration-500">
                            <div class="relative rounded-lg overflow-hidden shadow-2xl border-4 border-white">
                                <img src="https://images.unsplash.com/photo-1583241804226-9a9e0a0a8b5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                                    alt="Handmade Workshop" class="w-full h-40 sm:h-52 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                        </div>

                        <!-- Image 2: Left Position -->
                        <div
                            class="relative mr-auto w-[70%] sm:w-[65%] transform -rotate-2 hover:-rotate-3 hover:scale-105 transition-all duration-500">
                            <div class="relative rounded-lg overflow-hidden shadow-2xl border-4 border-white">
                                <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                    alt="Artisan Crafting" class="w-full h-40 sm:h-52 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                        </div>

                        <!-- Image 3: Right Position -->
                        <div
                            class="relative ml-auto w-[70%] sm:w-[65%] transform rotate-1 hover:rotate-2 hover:scale-105 transition-all duration-500">
                            <div class="relative rounded-lg overflow-hidden shadow-2xl border-4 border-white">
                                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                    alt="Traditional Craftsmanship" class="w-full h-40 sm:h-52 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Badge -->
                    <div
                        class="absolute -bottom-6 -left-6 bg-brown text-white p-6 rounded-2xl shadow-xl transform rotate-3 hover:rotate-0 transition-transform duration-300 z-10">
                        <div class="text-4xl font-bold">15+</div>
                        <div class="text-sm">{{ __('messages.years_experience') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Customer Testimonials Section -->
    {{-- <section class="py-16 sm:py-20 lg:py-24 bg-white relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-1/2 w-96 h-96 bg-brown/5 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12 scroll-fade-in">
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 gradient-text animate-title-in">
                {{ __('messages.customer_testimonials') }}
            </h2>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto animate-subtitle-in">
                {{ __('messages.what_our_customers_say') }}
            </p>
        </div>

        @if ($testimonials->count() > 0)
        <!-- Testimonials Carousel -->
        <div class="relative">
            <!-- Navigation Arrows -->
            <button id="testimonialPrev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 sm:-translate-x-8 z-20 w-12 h-12 sm:w-14 sm:h-14 bg-brown text-white rounded-full flex items-center justify-center shadow-lg hover:bg-brown-darker transition-all duration-300 transform hover:scale-110 opacity-80 hover:opacity-100">
                <i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-lg sm:text-xl"></i>
            </button>
            <button id="testimonialNext" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 sm:translate-x-8 z-20 w-12 h-12 sm:w-14 sm:h-14 bg-brown text-white rounded-full flex items-center justify-center shadow-lg hover:bg-brown-darker transition-all duration-300 transform hover:scale-110 opacity-80 hover:opacity-100">
                <i class="fas fa-chevron-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} text-lg sm:text-xl"></i>
            </button>

            <!-- Carousel Container -->
            <div class="testimonials-carousel-container overflow-x-hidden overflow-y-visible py-2">
                <div id="testimonialsCarousel" class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(0);">
                    @foreach ($testimonials as $index => $testimonial)
                    <div class="testimonial-slide flex-shrink-0 px-3 sm:px-4" style="width: calc(100% / 1);">
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 h-full">
                            <!-- Product Image -->
                            @if (isset($testimonial['product']) && $testimonial['product'] && $testimonial['product']->main_image)
                            <div class="rounded-t-2xl overflow-hidden">
                                <a href="{{ route('products.show', $testimonial['product']->slug) }}">
                                    <img src="{{ asset('storage/' . $testimonial['product']->main_image) }}"
                                         alt="{{ $testimonial['product']->name }}"
                                         class="w-full h-48 sm:h-56 object-cover hover:scale-105 transition-transform duration-500">
                                </a>
                            </div>
                            @elseif(isset($testimonial['product']) && $testimonial['product'])
                            <div class="rounded-t-2xl overflow-hidden bg-gray-100">
                                <a href="{{ route('products.show', $testimonial['product']->slug) }}">
                                    <div class="w-full h-48 sm:h-56 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                </a>
                            </div>
                            @else
                            <div class="rounded-t-2xl overflow-hidden bg-gray-100">
                                <div class="w-full h-48 sm:h-56 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            </div>
                            @endif

                            <!-- Review Content -->
                            <div class="flex items-center justify-center py-3">
                                <div class="flex text-yellow-400 text-sm sm:text-base">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star {{ $i < $testimonial['rating'] ? '' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            <p class="text-gray-700 px-4 pb-4 leading-relaxed italic text-base sm:text-lg text-center">
                                "@php
                                    $words = explode(' ', $testimonial['review_text']);
                                    $truncated = implode(' ', array_slice($words, 0, 8));
                                    echo count($words) > 8 ? $truncated . '...' : $truncated;
                                @endphp"
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">{{ __('messages.no_testimonials_yet') }}</p>
        </div>
        @endif
    </div>
</section> --}}

    <!-- Trust & Social Proof Section with Animated Counters -->
    <section class="py-14 bg-gradient-to-br from-white via-gray-50 to-white relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-30">
            <div
                class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(128,89,60,0.1),transparent_50%)]">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Trust Badges -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.free_shipping') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.free_shipping_text') }}</p>
                </div>
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-transfer text-blue-600 text-2xl"></i>                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.cash_on_delivery') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.cash_on_delivery_text') }}</p>
                </div>
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.good_quality') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.good_quality_text') }}</p>
                </div>
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.customer_support') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.customer_support_text') }}</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Newsletter Signup Section -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-white via-gray-50 to-white relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-30">
            <div
                class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(128,89,60,0.1),transparent_50%)]">
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center scroll-fade-in">
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 gradient-text animate-title-in">
                    {{ __('messages.stay_updated') }}
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto animate-subtitle-in">
                    {{ __('messages.newsletter_text') }}
                </p>
                <form id="newsletterForm" class="max-w-md mx-auto mt-3">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="email" id="newsletterEmail" name="email"
                            placeholder="{{ __('messages.your_email_address') }}" required
                            class="flex-1 px-6 py-4 rounded-full text-gray-900 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-brown focus:border-brown text-base sm:text-lg shadow-md">
                        <button type="submit"
                            class="px-8 py-4 bg-brown text-white rounded-full font-semibold text-base sm:text-lg hover:bg-brown-darker transition-all duration-300 transform hover:scale-105 shadow-lg">
                            {{ __('messages.subscribe') }}
                        </button>
                    </div>
                    <p class="text-gray-600 text-sm mt-4">{{ __('messages.newsletter_privacy') }}</p>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transform: scale(1);
            will-change: transform, opacity;
        }

        .hero-slide.active {
            opacity: 1;
            animation: continuousZoomIn 7s linear forwards;
            transition: opacity 0.15s ease-in;
            z-index: 1;
        }

        /* When slide becomes inactive, hide instantly - no visible zoom out */
        .hero-slide:not(.active) {
            opacity: 0;
            animation: none !important;
            transition: opacity 0.15s ease-out;
            /* Reset transform instantly - fast fade makes it invisible */
            transform: scale(1) !important;
            z-index: 0;
        }

        @keyframes continuousZoomIn {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.15);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .carousel-dot {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            opacity: 1 !important;
            transform: scale(1.2);
        }

        /* Enhanced product cards */
        .product-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Product Image Container -*/
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

            0%,
            100% {
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

        /* Category cards enhancement */
        .category-card {
            transition: all 0.3s ease;
            border-radius: 20px;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Gradient text effect */
        .gradient-text {
            background: linear-gradient(135deg, #80593c, #5d4037);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2 !important;
        }

        /* Floating animations */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 6s ease-in-out infinite 2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Enhanced category cards */
        .category-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(128, 89, 60, 0.15), rgba(93, 64, 55, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        /* Category image overlay */
        .category-card .relative {
            position: relative;
        }

        .category-card img {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        /* CTA Section - No hover effects */
        .cta-section {
            background: linear-gradient(to right, var(--color-brown-primary), var(--color-brown-darker)) !important;
        }

        .cta-section:hover {
            background: linear-gradient(to right, var(--color-brown-primary), var(--color-brown-darker)) !important;
        }

        /* Enhanced Hero Section Styles */
        .hero-section {
            position: relative;
        }

        .hero-background {
            will-change: transform;
        }

        .hero-overlay {
            animation: overlayPulse 4s ease-in-out infinite;
        }

        @keyframes overlayPulse {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 0.6;
            }
        }

        /* Animated Particles */
        .particles-container {
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            opacity: 0.6;
            animation: floatParticle 15s infinite ease-in-out;
        }

        .particle:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 12s;
        }

        .particle:nth-child(2) {
            left: 30%;
            animation-delay: 2s;
            animation-duration: 15s;
        }

        .particle:nth-child(3) {
            left: 50%;
            animation-delay: 4s;
            animation-duration: 18s;
        }

        .particle:nth-child(4) {
            left: 70%;
            animation-delay: 1s;
            animation-duration: 14s;
        }

        .particle:nth-child(5) {
            left: 90%;
            animation-delay: 3s;
            animation-duration: 16s;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(0) scale(0);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-100px) translateX(100px) scale(1);
                opacity: 0;
            }
        }

        /* Hero Content Animations */

        @keyframes titleGlow {

            0%,
            100% {
                text-shadow: 0 0 20px rgba(255, 255, 255, 0.5), 0 0 40px rgba(255, 255, 255, 0.3);
            }

            50% {
                text-shadow: 0 0 30px rgba(255, 255, 255, 0.7), 0 0 60px rgba(255, 255, 255, 0.5);
            }
        }

        .hero-btn-primary,
        .hero-btn-secondary {
            position: relative;
            overflow: hidden;
        }

        .hero-btn-primary::before,
        .hero-btn-secondary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .hero-btn-primary:hover::before,
        .hero-btn-secondary:hover::before {
            width: 300px;
            height: 300px;
        }

        .animate-slide-in-left {
            animation: slideInLeft 1s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Scroll Animation Classes */
        .scroll-fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-title-in {
            animation: titleSlideIn 0.8s ease-out 0.2s backwards;
        }

        .animate-subtitle-in {
            animation: subtitleSlideIn 0.8s ease-out 0.4s backwards;
        }

        @keyframes titleSlideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes subtitleSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Category and Product Item Animations */
        .category-item,
        .product-item {
            opacity: 0;
            transform: translateY(50px) scale(0.9);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .category-item.visible,
        .product-item.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Enhanced Category Cards */
        .category-card {
            position: relative;
            overflow: hidden;
        }

        .category-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .category-card:hover::after {
            left: 100%;
        }

        /* Stat Counter Animations */
        .stat-item {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .stat-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-number {
            background: linear-gradient(135deg, #80593c, #a0522d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Parallax Effect */
        @media (min-width: 768px) {
            .hero-background {
                transform: translateZ(0);
            }
        }

        /* Smooth Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Enhanced Gradient Text */
        .gradient-text {
            position: relative;
            background: linear-gradient(135deg, #80593c, #5d4037, #80593c);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* Testimonial Item Animations */
        .testimonial-item {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .testimonial-item.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Products Carousel Container */
        .products-carousel-container {
            position: relative;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        /* Responsive product card widths for carousel */
        .featured-product-card,
        .new-arrivals-product-card {
            flex-shrink: 0;
        }

        @media (min-width: 1024px) {

            .featured-product-card,
            .new-arrivals-product-card {
                width: calc((100% - (3 * 1.5rem)) / 4);
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) {

            .featured-product-card,
            .new-arrivals-product-card {
                width: calc((100% - (2 * 1.5rem)) / 3);
            }
        }

        @media (min-width: 640px) and (max-width: 767px) {

            .featured-product-card,
            .new-arrivals-product-card {
                width: calc((100% - (1 * 1.5rem)) / 2);
            }
        }

        /* @media (max-width: 639px) {

            .featured-product-card,
            .new-arrivals-product-card {
                width: calc((100% - 1rem) / 2.5);
                min-width: calc((100% - 1rem) / 2.5);
            }
        } */

        /* Testimonials Carousel */
        .testimonials-carousel-container {
            padding: 0 50px;
            overflow-x: hidden;
            overflow-y: visible;
        }

        @media (max-width: 640px) {
            .testimonials-carousel-container {
                padding: 0 40px;
            }
        }

        .testimonial-slide {
            transition: all 0.3s ease;
        }

        @media (min-width: 1024px) {
            .testimonial-slide {
                width: calc(100% / 4) !important;
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) {
            .testimonial-slide {
                width: calc(100% / 3) !important;
            }
        }

        @media (min-width: 640px) and (max-width: 767px) {
            .testimonial-slide {
                width: calc(100% / 2) !important;
            }
        }

        @media (max-width: 639px) {
            .testimonial-slide {
                width: calc(100% / 1) !important;
            }
        }

        .testimonial-indicator {
            cursor: pointer;
        }

        .testimonial-indicator.active {
            background-color: #80593c;
            width: 2rem;
        }

        @media (min-width: 640px) {
            .testimonial-indicator.active {
                width: 2.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Hero Carousel Functionality
        let currentSlide = 0;
        let carouselInterval;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => {
                slide.classList.remove('active');
                // Stop animation and reset transform immediately
                slide.style.animation = 'none';
                slide.style.transform = 'scale(1)';
            });
            dots.forEach(dot => {
                dot.classList.remove('active');
                dot.style.opacity = '0.5';
                dot.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
            });

            // Add active class to current slide and dot - start zooming immediately from scale(1)
            const currentSlide = slides[index];
            // Force reflow to ensure animation restarts fresh
            void currentSlide.offsetWidth;
            currentSlide.style.transform = 'scale(1)';
            currentSlide.style.animation = 'continuousZoomIn 7s linear forwards';
            currentSlide.classList.add('active');
            dots[index].classList.add('active');
            dots[index].style.opacity = '1';
            dots[index].style.backgroundColor = 'white';
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function startCarousel() {
            carouselInterval = setInterval(nextSlide, 7000);
        }

        function stopCarousel() {
            clearInterval(carouselInterval);
        }

        // Initialize carousel immediately
        function initializeCarousel() {
            // Ensure dots are visible immediately
            showSlide(0);

            // Start carousel
            startCarousel();

            // Dot click handlers
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    showSlide(currentSlide);
                    stopCarousel();
                    startCarousel(); // Restart the carousel
                });
            });

            // Pause on hover
            const heroSection = document.querySelector('.hero-slide').parentElement;
            if (heroSection) {
                heroSection.addEventListener('mouseenter', stopCarousel);
                heroSection.addEventListener('mouseleave', startCarousel);
            }
        }

        // Initialize immediately when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initializeCarousel();
                initScrollAnimations();
                initParallax();
                initCounterAnimations();
            });
        } else {
            initializeCarousel();
            initScrollAnimations();
            initParallax();
            initCounterAnimations();
        }

        // Scroll-triggered Animations
        function initScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe scroll fade-in elements
            document.querySelectorAll('.scroll-fade-in').forEach(el => {
                observer.observe(el);
            });

            // Observe category items with stagger
            document.querySelectorAll('.category-item').forEach((el, index) => {
                observer.observe(el);
                el.style.transitionDelay = `${index * 0.1}s`;
            });

            // Observe product items with stagger
            document.querySelectorAll('.product-item').forEach((el, index) => {
                observer.observe(el);
                el.style.transitionDelay = `${index * 0.05}s`;
            });

            // Observe stat items
            document.querySelectorAll('.stat-item').forEach((el, index) => {
                observer.observe(el);
                el.style.transitionDelay = `${index * 0.15}s`;
            });

            // Observe testimonial items
            document.querySelectorAll('.testimonial-item').forEach((el, index) => {
                observer.observe(el);
                el.style.transitionDelay = `${index * 0.1}s`;
            });
        }

        // Parallax Effect for Hero Section
        function initParallax() {
            const heroBackground = document.querySelector('.hero-background');
            if (!heroBackground) return;

            let ticking = false;

            function updateParallax() {
                const scrolled = window.pageYOffset;
                const rate = scrolled * 0.5;

                if (scrolled < window.innerHeight) {
                    heroBackground.style.transform = `translateY(${rate}px)`;
                }

                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    window.requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick);
        }

        // Animated Counter for Stats
        function initCounterAnimations() {
            const statItems = document.querySelectorAll('.stat-item');
            const statObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                        entry.target.classList.add('counted');
                        animateCounter(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            statItems.forEach(item => {
                statObserver.observe(item);
            });
        }

        function animateCounter(element) {
            const numberEl = element.querySelector('.stat-number');
            if (!numberEl) return;

            const value = parseInt(element.getAttribute('data-value'));
            const suffix = element.getAttribute('data-suffix') || '';
            const duration = 2000; // 2 seconds
            const steps = 60;
            const increment = value / steps;
            const stepDuration = duration / steps;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= value) {
                    numberEl.textContent = value + suffix;
                    clearInterval(timer);
                } else {
                    numberEl.textContent = Math.floor(current) + suffix;
                }
            }, stepDuration);
        }


        function addToCart(productId) {
            fetch('{{ route('cart.add') }}', {
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
                        // Show success message with better styling
                        showNotification(data.message, 'success');
                        // Update cart count
                        if (typeof updateCartCount === 'function') {
                            updateCartCount();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error adding to cart', 'error');
                });
        }

        // Enhanced notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-semibold transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' :
        'bg-blue-500'
    }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Newsletter Form Handler
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterForm = document.getElementById('newsletterForm');
            if (newsletterForm) {
                const submitBtn = newsletterForm.querySelector('button[type="submit"]');
                const originalText = submitBtn ? submitBtn.innerHTML : '';

                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = document.getElementById('newsletterEmail').value;

                    if (submitBtn) {
                        submitBtn.disabled = true;
                        const submittingText = @json(__('messages.submitting'));
                        submitBtn.innerHTML = submittingText + '...';
                    }

                    // Submit to backend
                    fetch('{{ route('newsletter.subscribe') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                email: email
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const successMessage = @json(__('messages.newsletter_success'));
                                showNotification(successMessage, 'success');
                                newsletterForm.reset();
                            } else {
                                showNotification(data.message || 'An error occurred', 'error');
                            }
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('An error occurred. Please try again.', 'error');
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        });
                });
            }

            // Testimonials Carousel
            initTestimonialsCarousel();

            // Products Carousels
            initProductsCarousel('featured', 'featuredCarousel', 'featuredPrev', 'featuredNext');
            initProductsCarousel('newArrivals', 'newArrivalsCarousel', 'newArrivalsPrev', 'newArrivalsNext');
        });

        // Testimonials Carousel Functionality
        function initTestimonialsCarousel() {
            const carousel = document.getElementById('testimonialsCarousel');
            const prevBtn = document.getElementById('testimonialPrev');
            const nextBtn = document.getElementById('testimonialNext');

            if (!carousel || !prevBtn || !nextBtn) return;

            let currentIndex = 0;
            const slides = carousel.querySelectorAll('.testimonial-slide');
            const totalSlides = slides.length;

            // Ensure we have slides
            if (totalSlides === 0) return;

            // Get number of slides to show based on screen width
            function getSlidesToShow() {
                if (window.innerWidth >= 1024) return 4; // lg screens
                if (window.innerWidth >= 768) return 3; // md screens
                if (window.innerWidth >= 640) return 2; // sm screens
                return 1; // mobile
            }

            function updateCarousel() {
                const slidesToShow = getSlidesToShow();
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                currentIndex = Math.min(currentIndex, maxIndex);

                // Calculate slide width (each slide takes 100% / slidesToShow of container)
                const slideWidth = 100 / slidesToShow;
                // Move one slide at a time
                const translateX = -(currentIndex * slideWidth);

                carousel.style.transform = `translateX(${translateX}%)`;

                // Update button states
                prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
                prevBtn.style.pointerEvents = currentIndex === 0 ? 'none' : 'auto';
                nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
                nextBtn.style.pointerEvents = currentIndex >= maxIndex ? 'none' : 'auto';
            }

            function nextSlide() {
                const slidesToShow = getSlidesToShow();
                const maxIndex = Math.max(0, totalSlides - slidesToShow);
                // Move one slide at a time
                if (currentIndex < maxIndex) {
                    currentIndex += 1;
                    updateCarousel();
                }
            }

            function prevSlide() {
                // Move one slide at a time
                if (currentIndex > 0) {
                    currentIndex -= 1;
                    updateCarousel();
                }
            }

            // Event listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    updateCarousel();
                }, 250);
            });

            // Initialize
            updateCarousel();
        }

        // Products Carousel Functionality
        function initProductsCarousel(carouselId, carouselElementId, prevBtnId, nextBtnId) {
            const carousel = document.getElementById(carouselElementId);
            const prevBtn = document.getElementById(prevBtnId);
            const nextBtn = document.getElementById(nextBtnId);

            if (!carousel || !prevBtn || !nextBtn) return;

            let currentIndex = 0;
            const slides = carousel.querySelectorAll('.product-card');
            const totalSlides = slides.length;

            if (totalSlides === 0) return;

            // Get number of slides to show based on screen width
            function getSlidesToShow() {
                if (window.innerWidth >= 1024) return 4; // lg screens - 4 products
                if (window.innerWidth >= 768) return 3; // md screens - 3 products
                if (window.innerWidth >= 640) return 2; // sm screens - 2 products
                return 2.5; // mobile - 2.5 products (2 full + half)
            }

            function updateCarousel() {
                const slidesToShow = getSlidesToShow();
                // For fractional slides (like 2.5), round down for maxIndex calculation
                const maxIndex = Math.max(0, totalSlides - Math.ceil(slidesToShow));
                currentIndex = Math.min(currentIndex, maxIndex);

                // Check if RTL (Arabic)
                const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

                // Get the first slide to calculate its width including gap
                if (slides.length > 0) {
                    const firstSlide = slides[0];
                    const slideWidth = firstSlide.offsetWidth;
                    const gap = window.getComputedStyle(carousel).gap;
                    const gapValue = parseFloat(gap) || 0;
                    // Reverse translateX direction for RTL
                    const translateX = isRTL ? (currentIndex * (slideWidth + gapValue)) : -(currentIndex * (slideWidth + gapValue));
                    carousel.style.transform = `translateX(${translateX}px)`;
                } else {
                    carousel.style.transform = `translateX(0)`;
                }

                // Update button states
                prevBtn.disabled = currentIndex === 0;
                prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
                nextBtn.disabled = currentIndex >= maxIndex;
                nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
            }

            function nextSlide() {
                const slidesToShow = getSlidesToShow();
                const maxIndex = Math.max(0, totalSlides - Math.ceil(slidesToShow));
                if (currentIndex < maxIndex) {
                    currentIndex += 1;
                    updateCarousel();
                }
            }

            function prevSlide() {
                if (currentIndex > 0) {
                    currentIndex -= 1;
                    updateCarousel();
                }
            }

            // Event listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    updateCarousel();
                }, 250);
            });

            // Initialize
            updateCarousel();
        }
    </script>
@endpush
