@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol
                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} text-sm text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-brown">{{ __('messages.home') }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-brown">{{ __('messages.products') }}</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('categories.show', $product->category->slug) }}"
                            class="hover:text-brown">{{ $product->category->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-800">{{ $product->name }}</li>
                </ol>
            </nav>


            <!-- Countdown Timer for Sale -->
            @if ($product->sale_price && $product->isSaleActive())
                <div
                    class="mb-4 bg-gradient-to-r from-amber-800 to-amber-900 rounded-xl p-3 shadow-lg relative animate-pulse-glow">
                    <!-- Fire emoji in top right corner (mobile only) -->
                    <div class="absolute top-10 right-5 text-2xl animate-bounce sm:hidden">
                        🔥
                    </div>

                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-center text-amber-100 gap-3 sm:gap-24 px-8">
                        <div
                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} justify-center">
                            <!-- Fire emoji next to text (desktop only) -->
                            <div class="text-2xl animate-bounce hidden sm:block">
                                🔥
                            </div>
                            <div class="text-center">
                                <h3 class="text-sm font-bold">
                                    {{ __('messages.limited_time_offer') }}
                                </h3>
                                <p class="text-xs opacity-90">
                                    {{ __('messages.sale_ends_soon') }}
                                </p>
                            </div>
                        </div>
                        <div id="countdown-timer"
                            class="flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-1' : 'space-x-1' }} text-amber-100"
                            data-end-time="{{ $product->sale_end_date->timestamp }}">
                            <div
                                class="bg-amber-900/50 rounded-md px-2 py-1.5 text-center min-w-[35px] hover:bg-amber-800/60 transition-all duration-300">
                                <div class="text-sm font-bold text-amber-100" id="countdown-days">00</div>
                                <div class="text-xs opacity-80 text-amber-200">{{ __('messages.days') }}</div>
                            </div>
                            <div class="text-amber-200 font-bold text-xs animate-pulse">:</div>
                            <div
                                class="bg-amber-900/50 rounded-md px-2 py-1.5 text-center min-w-[35px] hover:bg-amber-800/60 transition-all duration-300">
                                <div class="text-sm font-bold text-amber-100" id="countdown-hours">00</div>
                                <div class="text-xs opacity-80 text-amber-200">{{ __('messages.hours') }}</div>
                            </div>
                            <div class="text-amber-200 font-bold text-xs animate-pulse">:</div>
                            <div
                                class="bg-amber-900/50 rounded-md px-2 py-1.5 text-center min-w-[35px] hover:bg-amber-800/60 transition-all duration-300">
                                <div class="text-sm font-bold text-amber-100" id="countdown-minutes">00</div>
                                <div class="text-xs opacity-80 text-amber-200">{{ __('messages.minutes') }}</div>
                            </div>
                            <div class="text-amber-200 font-bold text-xs animate-pulse">:</div>
                            <div
                                class="bg-amber-900/50 rounded-md px-2 py-1.5 text-center min-w-[35px] hover:bg-amber-800/60 transition-all duration-300">
                                <div class="text-sm font-bold text-amber-100" id="countdown-seconds">00</div>
                                <div class="text-xs opacity-80 text-amber-200">{{ __('messages.seconds') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <!-- Product Images -->
                <div class="space-y-6">
                    <div class="bg-gray-100 rounded-2xl shadow-lg overflow-hidden relative group" id="main-image-container">
                        <!-- Navigation Arrows -->
                        <button id="prev-image-btn" onclick="previousImage()"
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-gray-600 hover:text-brown w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 z-10 opacity-100">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button id="next-image-btn" onclick="nextImage()"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-gray-600 hover:text-brown w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 z-10 opacity-100">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <img src="{{ $mainImage ? asset('storage/' . $mainImage->image_path) : ($product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/600x750/FFC0CB/FFFFFF?text=' . urlencode($product->name)) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-[450px] sm:h-[500px] lg:h-[600px] lg:w-[600px] lg:mx-auto object-contain transition-transform duration-300 aspect-[2/3] lg:aspect-square"
                            id="main-image" onclick="openZoom(this.src)"
                            data-zoom-image="{{ $mainImage ? asset('storage/' . $mainImage->image_path) : ($product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/600x750/FFC0CB/FFFFFF?text=' . urlencode($product->name)) }}">
                    </div>
                    @if ($colorImages && count($colorImages) > 1)
                        <div class="grid grid-cols-4 sm:grid-cols-5 gap-3 sm:gap-4" id="image-thumbnails">
                            @foreach ($colorImages as $index => $image)
                                <button onclick="changeMainImage('{{ $image->image_path }}')"
                                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 {{ $image->is_main ? 'ring-2 ring-brown' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                                        class="w-full h-20 sm:h-24 lg:h-28 object-contain aspect-[2/3]">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Product Description - Hidden on mobile -->
                    <div class="border-t pt-6 hidden lg:block">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ __('messages.description') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                </div>

                <!-- Product Details -->
                <div class="space-y-4 sm:space-y-6">
                    <div>
                        <div class="mb-2">
                            <span class="text-xs sm:text-sm text-gray-500">{{ $product->category->name }}</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3 sm:mb-4">{{ $product->name }}</h1>
                        <div class="mb-4 sm:mb-6">
                            @if ($product->sale_price)
                                @php
                                    $discountPercentage = round(
                                        (($product->price - $product->sale_price) / $product->price) * 100,
                                    );
                                @endphp
                                <!-- Price with discount -->
                                <div class="space-y-3">
                                    <div
                                        class="flex flex-row items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }}">
                                        <div
                                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                                            <span
                                                class="text-2xl sm:text-3xl font-bold text-red-500">{{ number_format($product->sale_price, 2) }}
                                                DH</span>
                                            <span
                                                class="text-lg sm:text-xl text-gray-500 line-through">{{ number_format($product->price, 2) }}
                                                DH</span>
                                        </div>
                                        <span
                                            class="inline-block bg-red-500 text-white px-3 py-1.5 rounded-lg text-sm font-bold shadow-md">
                                            -{{ $discountPercentage }}% {{ __('messages.off') }}
                                        </span>
                                    </div>

                                    <!-- Countdown Timer for Sale Products -->
                                    @if (isset($activeCountdown) && $activeCountdown)
                                        <div class="product-price-countdown">
                                            <div class="flex items-center gap-2">
                                                <div class="flex items-center gap-1 text-xs text-gray-600 font-medium">
                                                    <i class="fas fa-bolt text-amber-500"></i>
                                                    <span>{{ __('messages.ends_in') }}</span>
                                                </div>
                                                <div class="flex items-center gap-1 countdown-display-inline">
                                                    <div class="countdown-box">
                                                        <span class="countdown-value-inline"
                                                            id="product-countdown-days">00</span>
                                                        <span class="countdown-label-inline">d</span>
                                                    </div>
                                                    <span class="countdown-separator-inline">:</span>
                                                    <div class="countdown-box">
                                                        <span class="countdown-value-inline"
                                                            id="product-countdown-hours">00</span>
                                                        <span class="countdown-label-inline">h</span>
                                                    </div>
                                                    <span class="countdown-separator-inline">:</span>
                                                    <div class="countdown-box">
                                                        <span class="countdown-value-inline"
                                                            id="product-countdown-minutes">00</span>
                                                        <span class="countdown-label-inline">m</span>
                                                    </div>
                                                    <span class="countdown-separator-inline">:</span>
                                                    <div class="countdown-box">
                                                        <span class="countdown-value-inline"
                                                            id="product-countdown-seconds">00</span>
                                                        <span class="countdown-label-inline">s</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="product-countdown-end-date hidden"
                                                data-end-date="{{ $activeCountdown->end_date->toIso8601String() }}"></span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span
                                    class="text-2xl sm:text-3xl font-bold text-brown">{{ number_format($product->price, 2) }}
                                    DH</span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Options -->
                    <form id="product-form" class="space-y-4 sm:space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Colors -->
                        @if ($availableColors && count($availableColors) > 0)
                            <div id="color-section">
                                <label
                                    class="block text-sm font-semibold text-gray-700 mb-2 sm:mb-3">{{ __('messages.color') }}</label>
                                <div class="flex flex-wrap gap-2 sm:gap-3">
                                    @foreach ($availableColors as $color)
                                        @php
                                            $colorMainImage = $product->getMainImageForColor($color->id);
                                        @endphp
                                        <label class="flex flex-col items-center cursor-pointer color-option group"
                                            data-color-id="{{ $color->id }}">
                                            <input type="radio" name="color" value="{{ $color->id }}"
                                                class="sr-only" {{ $color->id == $selectedColorId ? 'checked' : '' }}>
                                            <div
                                                class="relative w-14 h-16 sm:w-16 sm:h-18 lg:w-18 lg:h-20 rounded-md overflow-hidden border-2 border-gray-300 hover:border-brown transition-all duration-300 group-hover:shadow-md">
                                                @if ($colorMainImage)
                                                    <img src="{{ asset('storage/' . $colorMainImage->image_path) }}"
                                                        alt="{{ $product->name }} - {{ $color->name }}"
                                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center bg-gray-100">
                                                        <div class="w-6 h-6 rounded-full border border-gray-300"
                                                            style="background-color: {{ $color->hex_code }}"></div>
                                                    </div>
                                                @endif
                                            </div>
                                            <span
                                                class="mt-1 text-xs text-gray-700 text-center font-medium">{{ $color->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="color-error" class="hidden text-red-500 text-sm mt-2">
                                    <i
                                        class="fas fa-exclamation-circle {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                                    <span>{{ __('messages.please_select_color') }}</span>
                                </div>
                            </div>
                        @endif

                        @if ($product->stock_quantity > 0)

                            <!-- Sizes -->
                            @if ($product->sizes && count($product->sizes) > 0)
                                <div id="size-section">
                                    <label
                                        class="block text-sm font-semibold text-gray-700 mb-2 sm:mb-3">{{ __('messages.size') }}</label>
                                    <div class="flex flex-wrap gap-2 sm:gap-3">
                                        @foreach ($product->sizes as $sizeId)
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="size" value="{{ $sizeId }}"
                                                    class="sr-only" {{ count($product->sizes) === 1 ? 'checked' : '' }}>
                                                <div
                                                    class="w-10 h-10 sm:w-12 sm:h-12 border-2 border-gray-300 rounded-lg flex items-center justify-center hover:border-brown transition duration-300">
                                                    <span
                                                        class="text-xs sm:text-sm font-semibold">{{ $sizeNames[$sizeId] ?? $sizeId }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div id="size-error" class="hidden text-red-500 text-sm mt-2">
                                        <i
                                            class="fas fa-exclamation-circle {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                                        <span>{{ __('messages.please_select_size') }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Quantity -->
                            <div>
                                <label
                                    class="block text-sm font-semibold text-gray-700 mb-2 sm:mb-3">{{ __('messages.quantity') }}</label>
                                <div
                                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3 sm:space-x-reverse sm:space-x-4' : 'space-x-3 sm:space-x-4' }}">
                                    <button type="button" onclick="decreaseQuantity()"
                                        class="w-8 h-8 sm:w-10 sm:h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-minus text-xs sm:text-sm"></i>
                                    </button>
                                    <input type="number" name="quantity" value="1" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        class="w-16 sm:w-20 text-center border border-gray-300 rounded-lg py-1 sm:py-2 text-sm sm:text-base"
                                        id="quantity-input">
                                    <button type="button" onclick="increaseQuantity()"
                                        class="w-8 h-8 sm:w-10 sm:h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-plus text-xs sm:text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Delivery Info -->
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div
                                        class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-truck text-green-600 text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-sm font-semibold text-gray-900">
                                                {{ __('messages.free_delivery_title') }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($product->stock_quantity <= 0)
                            <!-- Out of Stock Message -->
                            <div class="mb-6">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                    <div
                                        class="flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-semibold text-red-800">
                                                {{ __('messages.out_of_stock') }}
                                            </h3>
                                            <p class="text-xs text-red-600 mt-1">
                                                {{ __('messages.product_unavailable') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($product->stock_quantity > 0)
                                <!-- Buy it Now Button -->
                                <button type="button" onclick="buyItNow()" id="buy-it-now-btn"
                                    class="w-full text-white py-3 sm:py-3 text-sm sm:text-base lg:text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center"
                                    style="background-color: #DB1215; border-radius: 30px;"
                                    onmouseover="this.style.backgroundColor='#b80e11'"
                                    onmouseout="this.style.backgroundColor='#DB1215'">
                                    <i
                                        class="fas fa-bolt {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                                    <span>{{ __('messages.buy_it_now') }}</span>
                                </button>
                            @endif

                            @if ($product->stock_quantity > 0)
                                <!-- Add to Cart and Wishlist Row -->
                                <div class="flex items-center gap-3 mt-3">
                                    <!-- Add to Cart Button -->
                                    <button type="button" onclick="addToCart()" id="add-to-cart-btn"
                                        class="flex-1 btn-brown-gradient py-3 sm:py-3 text-sm sm:text-base lg:text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center"
                                        style="border-radius: 30px;">
                                        <i
                                            class="fas fa-shopping-cart {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                                        <span class="add-to-cart-text">{{ __('messages.add_to_cart') }}</span>
                                        <span
                                            class="add-to-cart-price {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}"
                                            data-base-price="{{ $product->sale_price ?? $product->price }}"></span>
                                    </button>

                                    <!-- Wishlist Icon Button -->
                                    <button type="button" onclick="toggleWishlist({{ $product->id }})"
                                        id="wishlist-btn-{{ $product->id }}"
                                        class="w-12 h-12 sm:w-14 sm:h-14 border-2 border-grey text-brown hover:bg-gray-50 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center flex-shrink-0">
                                        <i class="far fa-heart text-lg sm:text-xl"
                                            id="wishlist-icon-{{ $product->id }}"></i>
                                    </button>
                                </div>
                            @endif
                        @else
                            <!-- Buy it Now Button -->
                            <button type="button" onclick="buyItNow()" id="buy-it-now-btn"
                                class="w-full text-white py-3 sm:py-3 text-sm sm:text-base lg:text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center"
                                style="background-color: #DB1215; border-radius: 30px;"
                                onmouseover="this.style.backgroundColor='#b80e11'"
                                onmouseout="this.style.backgroundColor='#DB1215'">
                                <i
                                    class="fas fa-bolt {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                                <span>{{ __('messages.buy_it_now') }}</span>
                            </button>

                            <!-- Add to Cart and Wishlist Row -->
                            <div class="flex items-center gap-3 mt-3">
                                <!-- Add to Cart Button -->
                                <button type="button" onclick="addToCart()" id="add-to-cart-btn"
                                    class="flex-1 btn-brown-gradient py-3 sm:py-3 text-sm sm:text-base lg:text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center"
                                    style="border-radius: 30px;">
                                    <i
                                        class="fas fa-shopping-cart {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                                    <span class="add-to-cart-text">{{ __('messages.add_to_cart') }}</span>
                                    <span class="add-to-cart-price {{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }}"
                                        data-base-price="{{ $product->sale_price ?? $product->price }}"></span>
                                </button>

                                <!-- Wishlist Icon Button -->
                                <button type="button" onclick="toggleWishlist({{ $product->id }})"
                                    id="wishlist-btn-{{ $product->id }}"
                                    class="w-12 h-12 sm:w-14 sm:h-14 border-2 border-grey text-brown hover:bg-gray-50 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center flex-shrink-0">
                                    <i class="far fa-heart text-lg sm:text-xl"
                                        id="wishlist-icon-{{ $product->id }}"></i>
                                </button>
                            </div>
                        @endif
                    </form>

                    <!-- Product Extra Links -->
                    <div
                        class="flex flex-wrap items-center gap-4 mt-6 pt-6 border-t border-gray-200 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <button type="button" onclick="openAskQuestionModal()"
                            class="product-extra-link-item flex items-center transition-colors font-semibold {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}"
                            style="color: #8B6F47;">
                            <span class="product-extra-icon mr-2 ">
                                <svg aria-hidden="true" role="img" focusable="false" width="20" height="20"
                                    viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 0 10 0C15.523 0 20 4.477 20 10C20 15.523 15.523 20 10 20ZM10 18C12.1217 18 14.1566 17.1571 15.6569 15.6569C17.1571 14.1566 18 12.1217 18 10C18 7.87827 17.1571 5.84344 15.6569 4.34315C14.1566 2.84285 12.1217 2 10 2C7.87827 2 5.84344 2.84285 4.34315 4.34315C2.84285 5.84344 2 7.87827 2 10C2 12.1217 2.84285 14.1566 4.34315 15.6569C5.84344 17.1571 7.87827 18 10 18ZM9 13H11V15H9V13ZM11 11.355V12H9V10.5C9 10.2348 9.10536 9.98043 9.29289 9.79289C9.48043 9.60536 9.73478 9.5 10 9.5C10.2841 9.49998 10.5623 9.4193 10.8023 9.26733C11.0423 9.11536 11.2343 8.89837 11.3558 8.64158C11.4773 8.3848 11.5234 8.0988 11.4887 7.81684C11.454 7.53489 11.34 7.26858 11.1598 7.04891C10.9797 6.82924 10.7409 6.66523 10.4712 6.57597C10.2015 6.48671 9.91204 6.47587 9.63643 6.54471C9.36081 6.61354 9.11042 6.75923 8.91437 6.96482C8.71832 7.1704 8.58468 7.42743 8.529 7.706L6.567 7.313C6.68863 6.70508 6.96951 6.14037 7.38092 5.67659C7.79233 5.2128 8.31952 4.86658 8.90859 4.67332C9.49766 4.48006 10.1275 4.44669 10.7337 4.57661C11.3399 4.70654 11.9007 4.99511 12.3588 5.41282C12.8169 5.83054 13.1559 6.36241 13.3411 6.95406C13.5263 7.54572 13.5511 8.17594 13.4129 8.78031C13.2747 9.38467 12.9785 9.9415 12.5545 10.3939C12.1306 10.8462 11.5941 11.1779 11 11.355Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <span>{{ __('messages.ask_question') }}</span>
                        </button>
                        <button type="button" onclick="openShareModal()"
                            class="product-extra-link-item flex items-center transition-colors font-semibold {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}"
                            style="color: #8B6F47;">
                            <span class="product-extra-icon mr-2">
                                <svg aria-hidden="true" role="img" focusable="false" width="17" height="20"
                                    viewBox="0 0 17 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.7498 12.1875C11.9126 12.1861 11.104 12.4919 10.4771 13.0469L7.28885 11C7.48674 10.348 7.48674 9.65196 7.28885 8.99998L10.4771 6.9531C11.0977 7.49849 11.8946 7.80112 12.7207 7.80519C13.5469 7.80925 14.3467 7.51448 14.9726 6.97522C15.5985 6.43597 16.0084 5.68859 16.1266 4.87091C16.2448 4.05323 16.0634 3.22039 15.6158 2.52595C15.1682 1.83151 14.4846 1.32231 13.6911 1.09224C12.8976 0.862169 12.0477 0.926746 11.2981 1.27406C10.5484 1.62138 9.94966 2.22801 9.61214 2.9821C9.27462 3.73619 9.22112 4.58688 9.4615 5.37732L6.27244 7.42185C5.77651 6.98357 5.16461 6.69778 4.51021 6.5988C3.85581 6.49981 3.18676 6.59184 2.58339 6.86384C1.98002 7.13583 1.46801 7.57622 1.10883 8.13212C0.749655 8.68802 0.558594 9.33579 0.558594 9.99763C0.558594 10.6595 0.749655 11.3072 1.10883 11.8631C1.46801 12.419 1.98002 12.8594 2.58339 13.1314C3.18676 13.4034 3.85581 13.4955 4.51021 13.3965C5.16461 13.2975 5.77651 13.0117 6.27244 12.5734L9.46072 14.625C9.25036 15.3168 9.26353 16.0574 9.49838 16.7413C9.73323 17.4253 10.1778 18.0177 10.7688 18.4344C11.3598 18.8511 12.0672 19.0708 12.7902 19.0622C13.5133 19.0537 14.2153 18.8173 14.7963 18.3867C15.3773 17.9562 15.8077 17.3534 16.0262 16.6641C16.2448 15.9748 16.2405 15.2341 16.0138 14.5474C15.7871 13.8607 15.3496 13.263 14.7636 12.8393C14.1776 12.4156 13.4729 12.1875 12.7498 12.1875ZM12.7498 2.81248C13.0588 2.81248 13.3609 2.90411 13.6179 3.0758C13.8748 3.24749 14.0751 3.49152 14.1933 3.77703C14.3116 4.06254 14.3426 4.37671 14.2823 4.6798C14.222 4.9829 14.0732 5.26131 13.8546 5.47983C13.6361 5.69835 13.3577 5.84716 13.0546 5.90745C12.7515 5.96774 12.4374 5.9368 12.1518 5.81854C11.8663 5.70028 11.6223 5.50001 11.4506 5.24305C11.2789 4.9861 11.1873 4.68401 11.1873 4.37498C11.1873 3.96058 11.3519 3.56315 11.6449 3.27012C11.938 2.9771 12.3354 2.81248 12.7498 2.81248ZM3.99978 11.5625C3.69075 11.5625 3.38866 11.4708 3.13171 11.2991C2.87475 11.1275 2.67448 10.8834 2.55622 10.5979C2.43796 10.3124 2.40702 9.99824 2.46731 9.69515C2.5276 9.39205 2.67641 9.11364 2.89493 8.89512C3.11345 8.6766 3.39186 8.52779 3.69496 8.4675C3.99805 8.40721 4.31222 8.43815 4.59773 8.55641C4.88324 8.67468 5.12727 8.87495 5.29896 9.1319C5.47065 9.38885 5.56228 9.69094 5.56228 9.99998C5.56228 10.4144 5.39766 10.8118 5.10464 11.1048C4.81161 11.3979 4.41419 11.5625 3.99978 11.5625ZM12.7498 17.1875C12.4408 17.1875 12.1387 17.0958 11.8817 16.9241C11.6248 16.7525 11.4245 16.5084 11.3062 16.2229C11.188 15.9374 11.157 15.6232 11.2173 15.3201C11.2776 15.0171 11.4264 14.7386 11.6449 14.5201C11.8635 14.3016 12.1419 14.1528 12.445 14.0925C12.7481 14.0322 13.0622 14.0632 13.3477 14.1814C13.6332 14.2997 13.8773 14.4999 14.049 14.7569C14.2206 15.0138 14.3123 15.3159 14.3123 15.625C14.3123 16.0394 14.1477 16.4368 13.8546 16.7298C13.5616 17.0229 13.1642 17.1875 12.7498 17.1875Z">
                                    </path>
                                </svg>
                            </span>
                            <span>{{ __('messages.share') }}</span>
                        </button>
                    </div>

                    <!-- Checkout Form (Hidden by default) -->
                    <div id="checkout-form" class="hidden mt-8 bg-gray-50 rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            {{ __('messages.order_information') }}
                        </h3>

                        <form id="order-form" class="space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="color" id="selected-color" value="">
                            <input type="hidden" name="size" id="selected-size" value="">
                            <input type="hidden" name="quantity" id="selected-quantity" value="1">

                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.full_name') }} *
                                </label>
                                <input type="text" id="full_name" name="full_name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                                    placeholder="{{ __('messages.enter_full_name') }}">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.phone_number') }} *
                                </label>
                                <input type="tel" id="phone" name="phone" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                                    placeholder="{{ __('messages.enter_phone_number') }}">
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.city') }} *
                                </label>
                                <select id="city" name="city" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300">
                                    <option value="">{{ __('messages.select_city') }}</option>
                                    @foreach ($moroccanCities as $city)
                                        <option value="{{ $city['en'] }}">
                                            {{ app()->getLocale() === 'ar' ? $city['ar'] : $city['en'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.address') }} *
                                </label>
                                <textarea id="address" name="address" required rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 resize-none"
                                    placeholder="{{ __('messages.enter_complete_address') }}"></textarea>
                            </div>

                            <!-- Notes (Optional) -->
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('messages.additional_notes_optional') }}
                                </label>
                                <textarea id="notes" name="notes" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 resize-none"
                                    placeholder="{{ __('messages.any_additional_notes') }}"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submit-order-btn"
                                class="w-full btn-brown-gradient py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-credit-card {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                                {{ __('messages.confirm_order') }}
                            </button>

                            <!-- Cancel Button -->
                            <button type="button" onclick="hideCheckoutForm()"
                                class="w-full bg-gray-500 text-white py-3 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-times {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                                {{ __('messages.cancel') }}
                            </button>
                        </form>
                    </div>

                    <!-- Thank You Section (Hidden by default) -->
                    <div id="thank-you-section" class="hidden mt-8 bg-green-50 rounded-2xl p-6 text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-check text-4xl text-green-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-green-800 mb-4">
                            {{ __('messages.your_order_confirmed') }}
                        </h3>
                        <p class="text-green-700 mb-6">
                            {{ __('messages.thank_you_trust') }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button onclick="hideThankYou()"
                                class="btn-brown-gradient py-3 px-8 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-shopping-bag {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                                {{ __('messages.continue_shopping') }}
                            </button>
                            <a href="{{ route('home') }}"
                                class="bg-gray-500 text-white py-3 px-8 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                                <i class="fas fa-home {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                                {{ __('messages.back_to_home') }}
                            </a>
                        </div>
                    </div>

                    <!-- Product Description - Mobile Only -->
                    <div class="border-t pt-6 lg:hidden">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ __('messages.description') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Section - Category Based -->
            @include('shared.reviews-section', [
                'categoryId' => $product->category_id,
                'reviews' => $reviews,
                'allReviews' => $allReviews,
                'totalReviews' => $totalReviews,
                'averageRating' => $averageRating,
                'ratingDistribution' => $ratingDistribution,
                'sectionId' => 'product-reviews',
                'containerId' => 'judgeme_product_reviews',
                'addMarginTop' => true,
            ])

            <!-- Store Reviews Data for JavaScript -->
            @if ($totalReviews > 0)
                <script>
                    window.reviewsData = {
                        @if (isset($allReviews))
                            @foreach ($allReviews as $review)
                                {{ $review->id }}: {
                                    id: {{ $review->id }},
                                    name: "{{ addslashes($review->formatted_display_name) }}",
                                    rating: {{ $review->rating }},
                                    title: "{{ $review->review_title ? addslashes($review->review_title) : '' }}",
                                    text: "{{ addslashes($review->review_text) }}",
                                    date: "{{ $review->created_at->format('M d, Y') }}",
                                    media: @if ($review->media)
                                        "{{ asset('storage/' . $review->media) }}"
                                    @else
                                        null
                                    @endif
                                },
                            @endforeach
                        @else
                            @foreach ($reviews as $review)
                                {{ $review->id }}: {
                                    id: {{ $review->id }},
                                    name: "{{ addslashes($review->formatted_display_name) }}",
                                    rating: {{ $review->rating }},
                                    title: "{{ $review->review_title ? addslashes($review->review_title) : '' }}",
                                    text: "{{ addslashes($review->review_text) }}",
                                    date: "{{ $review->created_at->format('M d, Y') }}",
                                    media: @if ($review->media)
                                        "{{ asset('storage/' . $review->media) }}"
                                    @else
                                        null
                                    @endif
                                },
                            @endforeach
                        @endif
                    };
                </script>
            @endif

            <!-- Gallery Lightbox Modal -->
            @if ($totalReviews > 0 && isset($allReviews) && $allReviews->whereNotNull('media')->count() > 0)
                @php
                    $mediaReviews = $allReviews->whereNotNull('media');
                    $mediaReviewsAll = $mediaReviews->values()->all();
                @endphp
                <div id="gallery-lightbox-modal"
                    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
                    <div
                        class="jm-mfp-main w-full max-w-[95vw] sm:max-w-[90vw] lg:max-w-7xl h-[90vh] sm:h-[85vh] lg:h-[85vh] flex flex-col lg:flex-row bg-white rounded-lg lg:rounded-2xl overflow-hidden shadow-2xl relative">
                        <!-- Close Button -->
                        <button id="close-gallery-modal"
                            class="absolute top-2 right-2 lg:top-4 lg:right-4 text-gray-700 hover:text-gray-900 transition-colors z-10 bg-white/90 hover:bg-white rounded-full p-2 shadow-lg">
                            <i class="fas fa-times text-xl lg:text-2xl"></i>
                        </button>

                        <!-- Main Content Wrapper -->
                        <div
                            class="jm-mfp-carousel-wrapper flex-1 flex flex-col items-center justify-center p-3 sm:p-4 lg:p-6 min-h-0 overflow-hidden">
                            <!-- Main Image/Video Display -->
                            <div
                                class="jm-mfp-content-wrapper flex-1 w-full flex items-center justify-center relative min-h-0">
                                <!-- Navigation Arrows -->
                                @if (count($mediaReviewsAll) > 1)
                                    <button id="lightbox-prev"
                                        class="absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center text-brown shadow-lg transition-all z-10">
                                        <i class="fas fa-chevron-left text-xl"></i>
                                    </button>
                                    <button id="lightbox-next"
                                        class="absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center text-brown shadow-lg transition-all z-10">
                                        <i class="fas fa-chevron-right text-xl"></i>
                                    </button>
                                @endif

                                <div class="jm-mfp-content w-full">
                                    <figure class="jm-mfp-figure w-full flex items-center justify-center">
                                        <img id="lightbox-main-image" src="" alt="Review image"
                                            class="jm-mfp-img max-h-[48vh] sm:max-h-[35vh] lg:max-h-[55vh] w-full sm:w-auto object-contain rounded-lg">
                                        <video id="lightbox-main-video" src="" controls
                                            class="hidden max-h-[48vh] sm:max-h-[35vh] lg:max-h-[55vh] w-full sm:w-auto object-contain rounded-lg"></video>
                                    </figure>
                                </div>
                            </div>

                            <!-- Thumbnail Carousel -->
                            <div class="jm-mfp-carousel mt-10 sm:mt-3 w-full">
                                <div id="gallery-thumbnails-container" class="flex flex-col items-stretch gap-3 w-full">
                                    <div id="jdgm-gallery-thumbnails"
                                        class="jdgm-gallery flex items-center justify-start gap-2 sm:gap-3 overflow-x-auto pb-2 sm:pb-3 w-full px-3 sm:px-4"
                                        style="scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                                        @foreach ($mediaReviewsAll as $index => $review)
                                            <div class="jdgm-gallery__thumbnail-link flex-shrink-0 cursor-pointer border-2 border-transparent hover:border-brown transition-colors rounded-lg overflow-hidden {{ $index === 0 ? 'jdgm-gallery__thumbnail-link--current border-brown' : '' }}"
                                                data-media-index="{{ $index }}"
                                                data-review-id="{{ $review->id }}"
                                                data-media-url="{{ asset('storage/' . $review->media) }}">
                                                <div
                                                    class="jdgm-gallery__thumbnail-wrapper w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24">
                                                    @if (str_contains($review->media, '.mp4') ||
                                                            str_contains($review->media, '.mov') ||
                                                            str_contains($review->media, '.m4v'))
                                                        <video src="{{ asset('storage/' . $review->media) }}"
                                                            class="jdgm-gallery__thumbnail w-full h-full object-cover"></video>
                                                    @else
                                                        <img src="{{ asset('storage/' . $review->media) }}"
                                                            alt="User picture"
                                                            class="jdgm-gallery__thumbnail w-full h-full object-cover"
                                                            data-mfp-src="{{ asset('storage/' . $review->media) }}">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Hidden container for all media reviews data -->
                                    <div id="all-media-reviews-data" style="display: none;">
                                        @foreach ($mediaReviewsAll as $index => $review)
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
                        <div
                            class="jm-mfp-review-wrapper w-full lg:w-96 xl:w-[450px] bg-white overflow-y-auto max-h-[30vh] sm:max-h-[35vh] lg:max-h-none">
                            <div id="lightbox-review-content" class="jdgm-rev p-3 sm:p-4 lg:p-5">
                                <!-- Review content will be dynamically loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8">{{ __('messages.related_products') }}</h2>
                    <div
                        class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            @php
                                // Get images for hover effect
                                $colorImages = $relatedProduct->colorImages;
                                $mainImage = $relatedProduct->main_image
                                    ? asset('storage/' . $relatedProduct->main_image)
                                    : 'https://via.placeholder.com/500x600/FFC0CB/FFFFFF?text=' .
                                        urlencode($relatedProduct->name);
                                $hoverImage =
                                    $colorImages->count() > 1
                                        ? asset('storage/' . $colorImages[1]->image_path)
                                        : $mainImage;
                            @endphp
                            <div class="product-card overflow-hidden group transition-all duration-500">
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}"
                                        class="product-image-container block">
                                        <img src="{{ $mainImage }}" alt="{{ $relatedProduct->name }}"
                                            class="{{ $colorImages->count() > 1 ? '' : 'group-hover:scale-110 transition-transform duration-700 ease-out' }}">
                                        @if ($colorImages->count() > 1)
                                            <img src="{{ $hoverImage }}" alt=""
                                                class="opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out">
                                        @endif
                                    </a>
                                    @if ($relatedProduct->sale_price)
                                        @php
                                            $discountPercentage = round(
                                                (($relatedProduct->price - $relatedProduct->sale_price) /
                                                    $relatedProduct->price) *
                                                    100,
                                            );
                                        @endphp
                                        <div
                                            class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold shadow-lg transform -rotate-3 hover:rotate-0 transition-transform duration-300 border border-white sm:border-2 border-white z-10">
                                            <span class="relative z-10">-{{ $discountPercentage }}%</span>
                                        </div>
                                    @endif

                                    <!-- Overlay Buttons - Show on mobile always, desktop on hover -->
                                    <div class="product-featured-icons product-featured-icons--primary">
                                        <button onclick="addToCart({{ $relatedProduct->id }});"
                                            class="button add_to_cart_button ecomus-button product-loop-button product-loop-button-atc flex items-center justify-center em-button-light em-button-icon em-tooltip"
                                            data-product_id="{{ $relatedProduct->id }}"
                                            aria-label="{{ __('messages.add_to_cart') }}: {{ $relatedProduct->name }}"
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
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}"
                                            class="ecomus-quickview-button button product-loop-button flex items-center justify-center em-button-icon em-tooltip em-button-light"
                                            data-id="{{ $relatedProduct->id }}"
                                            data-tooltip="{{ __('messages.quick_view') }}"
                                            aria-label="{{ __('messages.quick_view') }} {{ $relatedProduct->name }}"
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
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                        <h3
                                            class="text-base font-normal text-brown mb-2 line-clamp-2 hover:opacity-80 transition-opacity cursor-pointer">
                                            {{ $relatedProduct->name }}</h3>
                                    </a>
                                    <div
                                        class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                                        @if ($relatedProduct->sale_price)
                                            <span
                                                class="text-base font-semibold text-red-500">{{ number_format($relatedProduct->sale_price, 2) }}
                                                DH</span>
                                            <span
                                                class="text-sm text-gray-500 line-through">{{ number_format($relatedProduct->price, 2) }}
                                                DH</span>
                                        @else
                                            <span
                                                class="text-base font-semibold text-brown">{{ number_format($relatedProduct->price, 2) }}
                                                DH</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sticky Buy Now Button - Mobile Only -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg p-4 lg:hidden z-40">
            <div
                class="max-w-7xl mx-auto flex items-center justify-between gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                <div class="flex-1 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-brown"
                            id="sticky-price">{{ $product->sale_price ?? $product->price }} DH</span>
                        @if ($product->sale_price)
                            <span class="text-sm text-gray-500 line-through">{{ $product->price }} DH</span>
                        @endif
                    </div>
                </div>
                @if ($product->stock_quantity <= 0)
                    <button disabled
                        class="py-3 px-6 text-sm font-semibold transition-all duration-300 shadow-lg flex items-center justify-center text-white {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} opacity-50 cursor-not-allowed"
                        style="background-color: #9CA3AF; border-radius: 30px;">
                        <span class="sticky-add-to-cart-text">{{ __('messages.out_of_stock') }}</span>
                    </button>
                @else
                    <button onclick="buyItNow()" id="sticky-add-to-cart-btn"
                        class="py-3 px-6 text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center text-white {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}"
                        style="background-color: #DB1215; border-radius: 30px;"
                        onmouseover="this.style.backgroundColor='#b80e11'"
                        onmouseout="this.style.backgroundColor='#DB1215'">
                        <i class="fas fa-bolt {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        <span class="sticky-add-to-cart-text">{{ __('messages.buy_it_now') }}</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Zoom Modal with Controls -->
    <div class="zoom-modal" id="zoom-modal">
        <span class="zoom-close" onclick="closeZoom()">&times;</span>

        <!-- Navigation arrows -->
        <button class="zoom-nav zoom-nav-left" onclick="previousZoomImage()" id="zoom-prev-btn">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="zoom-nav zoom-nav-right" onclick="nextZoomImage()" id="zoom-next-btn">
            <i class="fas fa-chevron-right"></i>
        </button>

        <img id="zoom-image" src="" alt="">

        <!-- Zoom controls -->
        <div class="zoom-controls">
            <button class="zoom-btn" onclick="zoomIn()" title="Zoom In">
                <i class="fas fa-plus"></i>
            </button>
            <button class="zoom-btn" onclick="zoomOut()" title="Zoom Out">
                <i class="fas fa-minus"></i>
            </button>
            <button class="zoom-btn" onclick="resetZoom()" title="Reset Zoom">
                <i class="fas fa-expand-arrows-alt"></i>
            </button>
        </div>

        <!-- Thumbnail navigation -->
        <div class="zoom-thumbnails" id="zoom-thumbnails">
            <!-- Thumbnails will be populated here -->
        </div>
    </div>

    <!-- Ask a Question Modal -->
    <div id="ask-question-modal" class="product-modal-overlay hidden">
        <div class="product-modal-wrapper">
            <div class="product-modal-header">
                <h3 class="product-modal-title">{{ __('messages.ask_question') }}</h3>
                <button type="button" onclick="closeAskQuestionModal()" class="product-modal-close">
                    <svg aria-hidden="true" role="img" focusable="false" fill="currentColor" width="16"
                        height="16" viewBox="0 0 16 16">
                        <path d="M16 1.4L14.6 0L8 6.6L1.4 0L0 1.4L6.6 8L0 14.6L1.4 16L8 9.4L14.6 16L16 14.6L9.4 8L16 1.4Z"
                            fill="currentColor"></path>
                    </svg>
                </button>
            </div>
            <div class="product-modal-content">
                <form id="ask-question-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div>
                        <label for="question-name" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('messages.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="question-name" name="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                            placeholder="{{ __('messages.enter_name') }}">
                    </div>
                    <div>
                        <label for="question-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('messages.email') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="question-email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                            placeholder="{{ __('messages.enter_email') }}">
                    </div>
                    <div>
                        <label for="question-phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('messages.phone_number') }}
                        </label>
                        <input type="tel" id="question-phone" name="phone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                            placeholder="{{ __('messages.enter_phone') }}">
                    </div>
                    <div>
                        <label for="question-message" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ __('messages.message') }}
                        </label>
                        <textarea id="question-message" name="message" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 resize-none"
                            placeholder="{{ __('messages.write_message') }}">{{ __('messages.hello_want_ask_about') }} {{ $product->name }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-full btn-brown-gradient py-3 rounded-lg text-base font-semibold transition-all duration-300 transform hover:scale-105">
                        {{ __('messages.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- Share Modal -->
    <div id="share-modal" class="product-modal-overlay hidden">
        <div class="product-modal-wrapper product-modal-wrapper--small">
            <div class="product-modal-header">
                <h3 class="product-modal-title">{{ __('messages.share') }}</h3>
                <button type="button" onclick="closeShareModal()" class="product-modal-close">
                    <svg aria-hidden="true" role="img" focusable="false" fill="currentColor" width="16"
                        height="16" viewBox="0 0 16 16">
                        <path d="M16 1.4L14.6 0L8 6.6L1.4 0L0 1.4L6.6 8L0 14.6L1.4 16L8 9.4L14.6 16L16 14.6L9.4 8L16 1.4Z"
                            fill="currentColor"></path>
                    </svg>
                </button>
            </div>
            <div class="product-modal-content">
                <div class="product-share-socials mb-6">
                    <a href="#" onclick="shareOnFacebook(event)"
                        class="product-share-link product-share-link--facebook flex items-center text-gray-700 hover:text-blue-600 transition-colors mb-3 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                            class="{{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                            <path
                                d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                fill="currentColor"></path>
                        </svg>
                        <span>Facebook</span>
                    </a>
                    <a href="#" onclick="shareOnTwitter(event)"
                        class="product-share-link product-share-link--twitter flex items-center text-gray-700 hover:text-blue-400 transition-colors mb-3 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            class="{{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                            <path
                                d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"
                                fill="currentColor"></path>
                        </svg>
                        <span>Twitter</span>
                    </a>
                    <a href="#" onclick="shareOnPinterest(event)"
                        class="product-share-link product-share-link--pinterest flex items-center text-gray-700 hover:text-red-600 transition-colors mb-3 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                            class="{{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                            <path
                                d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"
                                fill="currentColor"></path>
                        </svg>
                        <span>Pinterest</span>
                    </a>
                    <a href="#" onclick="shareOnWhatsApp(event)"
                        class="product-share-link product-share-link--whatsapp flex items-center text-gray-700 hover:text-green-500 transition-colors mb-3 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"
                            viewBox="0 0 32 32" class="{{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                            <path
                                d="M23.813 6.063q-2-1.938-4.531-3t-5.281-1.063q-3.75 0-6.938 1.875t-5.063 5.063-1.875 6.938 1.875 6.938l-2 7.188 7.375-1.938q3.063 1.688 6.625 1.688v0q3.75 0 6.969-1.875t5.125-5.063 1.906-6.938q0-2.75-1.094-5.281t-3.094-4.531zM14 27.438q-3.188 0-5.875-1.625l-0.438-0.25-4.375 1.125 1.188-4.25-0.25-0.438q-1.813-2.813-1.813-6.125 0-3.125 1.563-5.781t4.219-4.219 5.781-1.563q2.313 0 4.406 0.875t3.75 2.531 2.594 3.781 0.938 4.375q0 3.125-1.594 5.781t-4.281 4.219-5.813 1.563zM20.313 18.75q-1.875-0.938-2.375-1.125-0.25-0.063-0.438-0.063t-0.313 0.25q-0.313 0.438-1.125 1.375-0.25 0.313-0.75 0.063-1.75-0.875-2.625-1.563-1.188-0.938-2.063-2.563-0.188-0.188-0.125-0.344t0.313-0.406q0.5-0.5 0.813-1.125 0.125-0.25-0.063-0.625l-1.063-2.563q-0.125-0.375-0.281-0.469t-0.406-0.094h-0.75q-0.5 0-0.938 0.438l-0.063 0.063q-1.125 1.188-1.125 2.813t1.375 3.563l0.125 0.125q2.625 3.75 5.813 5.125 1.563 0.688 2.5 0.875 0.813 0.125 1.688 0 0.563-0.063 1.344-0.594t1-1.063 0.25-1.031-0.031-0.625-0.5-0.313z"
                                fill="currentColor"></path>
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                    <a href="#" onclick="shareViaEmail(event)"
                        class="product-share-link product-share-link--email flex items-center text-gray-700 hover:text-brown transition-colors {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                        <svg width="24" height="24" aria-hidden="true" role="img" focusable="false"
                            viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            class="{{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                            <path
                                d="M20,4H4C2.895,4,2,4.895,2,6v12c0,1.105,0.895,2,2,2h16c1.105,0,2-0.895,2-2V6C22,4.895,21.105,4,20,4z M20,8.236l-8,4.882 L4,8.236V6h16V8.236z"
                                fill="currentColor"></path>
                        </svg>
                        <span>{{ __('messages.share_via_email') }}</span>
                    </a>
                </div>
                <div class="product-share-copylink">
                    <form class="flex gap-2">
                        <input type="text" id="share-link-input"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                            value="{{ url()->current() }}" readonly>
                        <button type="button" onclick="copyShareLink()"
                            class="px-4 py-2 bg-brown text-white rounded-lg hover:bg-brown-darker transition-colors font-semibold">
                            {{ __('messages.copy') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    @vite(['resources/css/product.css'])
@endpush
@push('scripts')
    <script>
        // Delivery info is now simplified - 24 hours delivery after confirmation, no timeline calculation needed

        // Zoom functionality variables
        let isDragging = false;
        let startX = 0;
        let startY = 0;
        let currentX = 0;
        let currentY = 0;
        let zoomLevel = 1;
        let minZoom = 1;
        let maxZoom = 5;
        let currentZoomImageIndex = 0;
        let zoomImages = [];

        // Swipe gesture variables
        let swipeStartX = 0;
        let swipeStartY = 0;
        let swipeEndX = 0;
        let swipeEndY = 0;

        // Simple zoom functions
        function openZoom(imageSrc) {
            const modal = document.getElementById('zoom-modal');
            const zoomImg = document.getElementById('zoom-image');

            // Get all available images
            populateZoomImages();

            // Find current image index
            currentZoomImageIndex = zoomImages.findIndex(img => img.src === imageSrc);
            if (currentZoomImageIndex === -1) currentZoomImageIndex = 0;

            zoomImg.src = imageSrc;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // Start at normal size (not zoomed in)
            zoomLevel = 1;
            currentX = 0;
            currentY = 0;
            updateZoom();

            // Update navigation visibility
            updateZoomNavigation();

            // Populate thumbnails
            populateZoomThumbnails();
        }

        function closeZoom() {
            const modal = document.getElementById('zoom-modal');
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        function zoomIn() {
            zoomLevel = Math.min(zoomLevel + 0.3, maxZoom);
            updateZoom();
        }

        function zoomOut() {
            if (zoomLevel > minZoom) {
                zoomLevel = Math.max(zoomLevel - 0.3, minZoom);
                // If we reached minimum zoom, reset position
                if (zoomLevel === minZoom) {
                    currentX = 0;
                    currentY = 0;
                }
                updateZoom();
            }
        }

        function resetZoom() {
            zoomLevel = 1;
            currentX = 0;
            currentY = 0;
            updateZoom();
        }

        function updateZoom() {
            const zoomImg = document.getElementById('zoom-image');

            // Apply consistent panning without zoom-dependent constraints
            zoomImg.style.transform = `translate(-50%, -50%) scale(${zoomLevel}) translate(${currentX}px, ${currentY}px)`;
        }

        // Navigation functions
        function populateZoomImages() {
            zoomImages = [];
            const thumbnailButtons = document.querySelectorAll('button[onclick*="changeMainImage"]');
            thumbnailButtons.forEach(btn => {
                const img = btn.querySelector('img');
                if (img) {
                    zoomImages.push({
                        src: img.src,
                        path: btn.getAttribute('onclick').match(/'([^']+)'/)[1]
                    });
                }
            });
        }

        function nextZoomImage() {
            if (zoomImages.length > 1) {
                // Check if we're in Arabic (RTL) mode
                const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

                if (isRTL) {
                    // In Arabic, right arrow should go to previous image (like left arrow in English)
                    currentZoomImageIndex = (currentZoomImageIndex - 1 + zoomImages.length) % zoomImages.length;
                } else {
                    // In English, right arrow goes to next image
                    currentZoomImageIndex = (currentZoomImageIndex + 1) % zoomImages.length;
                }

                changeZoomImage(zoomImages[currentZoomImageIndex].src);
            }
        }

        function previousZoomImage() {
            if (zoomImages.length > 1) {
                // Check if we're in Arabic (RTL) mode
                const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

                if (isRTL) {
                    // In Arabic, left arrow should go to next image (like right arrow in English)
                    currentZoomImageIndex = (currentZoomImageIndex + 1) % zoomImages.length;
                } else {
                    // In English, left arrow goes to previous image
                    currentZoomImageIndex = (currentZoomImageIndex - 1 + zoomImages.length) % zoomImages.length;
                }

                changeZoomImage(zoomImages[currentZoomImageIndex].src);
            }
        }

        function changeZoomImage(imageSrc) {
            const zoomImg = document.getElementById('zoom-image');

            // Add loading effect
            zoomImg.style.opacity = '0.5';

            // Change image source
            zoomImg.src = imageSrc;

            // Wait for image to load
            zoomImg.onload = function() {
                zoomImg.style.opacity = '1';

                // Reset zoom when changing image
                zoomLevel = 1;
                currentX = 0;
                currentY = 0;
                updateZoom();

                // Update thumbnail selection
                updateZoomThumbnailSelection();
            };
        }

        function populateZoomThumbnails() {
            const thumbnailsContainer = document.getElementById('zoom-thumbnails');
            if (zoomImages.length <= 1) {
                thumbnailsContainer.innerHTML = '';
                return;
            }

            console.log('Populating thumbnails:', zoomImages.length, 'images');

            thumbnailsContainer.innerHTML = zoomImages.map((img, index) => `
        <div class="zoom-thumbnail ${index === currentZoomImageIndex ? 'active' : ''}"
             onclick="selectZoomImage(${index})"
             style="width: 50px; height: 50px; display: inline-block;">
            <img src="${img.src}" alt="" style="width: 50px; height: 50px; object-fit: cover;">
        </div>
    `).join('');

            console.log('Thumbnails populated, current index:', currentZoomImageIndex);
        }

        function selectZoomImage(index) {
            console.log('Selecting zoom image:', index, 'of', zoomImages.length);
            currentZoomImageIndex = index;
            changeZoomImage(zoomImages[index].src);
            updateZoomThumbnailSelection();
        }

        function updateZoomThumbnailSelection() {
            const thumbnails = document.querySelectorAll('.zoom-thumbnail');
            thumbnails.forEach((thumb, index) => {
                thumb.classList.toggle('active', index === currentZoomImageIndex);
            });
        }

        function updateZoomNavigation() {
            const prevBtn = document.getElementById('zoom-prev-btn');
            const nextBtn = document.getElementById('zoom-next-btn');

            if (zoomImages.length <= 1) {
                prevBtn.classList.add('hidden');
                nextBtn.classList.add('hidden');
            } else {
                prevBtn.classList.remove('hidden');
                nextBtn.classList.remove('hidden');
            }
        }

        // Mouse events for dragging
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('zoom-modal');
            const zoomImg = document.getElementById('zoom-image');

            if (modal && zoomImg) {
                // Click outside image to close modal
                modal.addEventListener('click', function(e) {
                    // Only close if clicking on the modal background, not on the image or controls
                    if (e.target === modal) {
                        closeZoom();
                    }
                });

                // Prevent image clicks from closing the modal
                zoomImg.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                // Prevent control elements from closing the modal
                const closeBtn = document.querySelector('.zoom-close');
                const navButtons = document.querySelectorAll('.zoom-nav');
                const zoomControls = document.querySelector('.zoom-controls');
                const thumbnails = document.querySelector('.zoom-thumbnails');

                if (closeBtn) {
                    closeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }

                if (navButtons.length > 0) {
                    navButtons.forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    });
                }

                if (zoomControls) {
                    zoomControls.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }

                if (thumbnails) {
                    thumbnails.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
                // Mouse down
                zoomImg.addEventListener('mousedown', function(e) {
                    if (zoomLevel > 1) {
                        isDragging = true;
                        startX = e.clientX - currentX;
                        startY = e.clientY - currentY;
                        e.preventDefault();
                    }
                });

                // Mouse move
                document.addEventListener('mousemove', function(e) {
                    if (isDragging && zoomLevel > 1) {
                        // Consistent damping factor regardless of zoom level
                        const dampingFactor = 0.4;
                        currentX = (e.clientX - startX) * dampingFactor;
                        currentY = (e.clientY - startY) * dampingFactor;
                        updateZoom();
                    }
                });

                // Mouse up
                document.addEventListener('mouseup', function() {
                    isDragging = false;
                });

                // Mouse wheel zoom
                zoomImg.addEventListener('wheel', function(e) {
                    e.preventDefault();
                    if (e.deltaY < 0) {
                        zoomIn();
                    } else {
                        zoomOut();
                    }
                });

                // Touch events for mobile
                let startTouchX = 0;
                let startTouchY = 0;
                let touchStartX = 0;
                let touchStartY = 0;
                let initialDistance = 0;
                let initialZoom = 1;
                let isPinching = false;
                let isDragging = false;
                let lastTapTime = 0;
                let tapCount = 0;

                zoomImg.addEventListener('touchstart', function(e) {
                    e.preventDefault();

                    if (e.touches.length === 1) {
                        // Capture swipe start positions
                        swipeStartX = e.touches[0].clientX;
                        swipeStartY = e.touches[0].clientY;

                        // Single finger - check for double tap or prepare for drag
                        const currentTime = new Date().getTime();
                        const tapLength = currentTime - lastTapTime;

                        if (tapLength < 500 && tapLength > 0) {
                            // Double tap detected
                            tapCount++;
                            if (tapCount === 2) {
                                // Toggle zoom
                                if (zoomLevel === 1) {
                                    zoomLevel = 2.5; // Zoom in
                                } else {
                                    zoomLevel = 1; // Zoom out
                                    currentX = 0;
                                    currentY = 0;
                                }
                                updateZoom();
                                tapCount = 0;
                                return;
                            }
                        } else {
                            tapCount = 1;
                        }
                        lastTapTime = currentTime;

                        // Prepare for drag if zoomed in
                        if (zoomLevel > 1) {
                            isDragging = true;
                            startTouchX = e.touches[0].clientX;
                            startTouchY = e.touches[0].clientY;
                            touchStartX = currentX;
                            touchStartY = currentY;
                        }
                    } else if (e.touches.length === 2) {
                        // Two fingers - pinch to zoom
                        isPinching = true;
                        isDragging = false;
                        tapCount = 0; // Reset tap count on multi-touch
                        initialDistance = Math.sqrt(
                            Math.pow(e.touches[0].clientX - e.touches[1].clientX, 2) +
                            Math.pow(e.touches[0].clientY - e.touches[1].clientY, 2)
                        );
                        initialZoom = zoomLevel;
                    }
                });

                zoomImg.addEventListener('touchmove', function(e) {
                    e.preventDefault();

                    if (e.touches.length === 1 && isDragging && zoomLevel > 1) {
                        // Consistent damping factor for mobile panning regardless of zoom level
                        const dampingFactor = 0.5;
                        currentX = touchStartX + ((e.touches[0].clientX - startTouchX) * dampingFactor);
                        currentY = touchStartY + ((e.touches[0].clientY - startTouchY) * dampingFactor);
                        updateZoom();
                    } else if (e.touches.length === 2 && isPinching) {
                        // Two finger pinch
                        const currentDistance = Math.sqrt(
                            Math.pow(e.touches[0].clientX - e.touches[1].clientX, 2) +
                            Math.pow(e.touches[0].clientY - e.touches[1].clientY, 2)
                        );
                        const scale = currentDistance / initialDistance;
                        zoomLevel = Math.max(minZoom, Math.min(maxZoom, initialZoom * scale));

                        // Reset position when at minimum zoom
                        if (zoomLevel === minZoom) {
                            currentX = 0;
                            currentY = 0;
                        }
                        updateZoom();
                    }
                });

                // Touch end - properly handle end of touch interactions
                zoomImg.addEventListener('touchend', function(e) {
                    e.preventDefault();

                    if (e.touches.length === 0) {
                        // Capture swipe end positions for swipe detection
                        swipeEndX = e.changedTouches[0].clientX;
                        swipeEndY = e.changedTouches[0].clientY;

                        console.log('Touch end detected');
                        console.log('Zoom level:', zoomLevel, 'Is dragging:', isDragging, 'Is pinching:',
                            isPinching);

                        // Handle swipe gestures when not zoomed in or when zoomed out
                        if (zoomLevel === 1 && !isDragging && !isPinching) {
                            console.log('Conditions met for swipe gesture');
                            handleSwipeGesture();
                        } else {
                            console.log('Swipe conditions not met');
                        }

                        // Reset touch states but keep zoom level
                        isDragging = false;
                        isPinching = false;
                    }
                });

                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    const modal = document.getElementById('zoom-modal');
                    if (modal.style.display === 'block') {
                        if (e.key === 'ArrowLeft') {
                            previousZoomImage();
                        } else if (e.key === 'ArrowRight') {
                            nextZoomImage();
                        } else if (e.key === 'Escape') {
                            closeZoom();
                        }
                    }
                });
            }
        });

        // Handle swipe gestures in zoom modal
        function handleSwipeGesture() {
            console.log('Swipe gesture detected!');
            console.log('Zoom images length:', zoomImages.length);
            console.log('Swipe start:', swipeStartX, swipeStartY);
            console.log('Swipe end:', swipeEndX, swipeEndY);

            if (zoomImages.length <= 1) {
                console.log('Only one image, no swipe needed');
                return; // No need to swipe if only one image
            }

            const deltaX = swipeEndX - swipeStartX;
            const deltaY = swipeEndY - swipeStartY;

            console.log('Delta X:', deltaX, 'Delta Y:', deltaY);

            // Check if it's a horizontal swipe (not vertical scroll)
            if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                console.log('Valid horizontal swipe detected!');

                // Check if we're in Arabic (RTL) mode
                const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

                if (isRTL) {
                    // In Arabic, swipe right goes to previous, swipe left goes to next
                    if (deltaX > 0) {
                        console.log('RTL: Swiping right, going to previous image');
                        previousZoomImage();
                    } else {
                        console.log('RTL: Swiping left, going to next image');
                        nextZoomImage();
                    }
                } else {
                    // In English, swipe right goes to previous, swipe left goes to next
                    if (deltaX > 0) {
                        console.log('LTR: Swiping right, going to previous image');
                        previousZoomImage();
                    } else {
                        console.log('LTR: Swiping left, going to next image');
                        nextZoomImage();
                    }
                }
            } else {
                console.log('Not a valid horizontal swipe');
            }
        }

        // Function to set transparent background
        function setTransparentBackground(containerElement) {
            // Set transparent background
            containerElement.style.backgroundColor = 'transparent';
            containerElement.style.borderColor = 'transparent';
        }

        // Function to apply transparent background to image containers
        function applyDynamicBackground(imageElement, containerElement) {
            setTransparentBackground(containerElement);
        }

        // Global variables for image navigation
        let currentImageIndex = 0;
        let availableImages = [];

        function changeMainImage(imageSrc) {
            const mainImage = document.getElementById('main-image');
            const mainContainer = document.getElementById('main-image-container');

            mainImage.src = '{{ asset('storage/') }}/' + imageSrc;

            // Apply dynamic background when image loads
            applyDynamicBackground(mainImage, mainContainer);

            // Update active thumbnail
            document.querySelectorAll('button[onclick*="changeMainImage"]').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-brown');
            });

            // Only add active class if this was called from a thumbnail click
            if (event && event.target && event.target.closest('button[onclick*="changeMainImage"]')) {
                event.target.closest('button').classList.add('ring-2', 'ring-brown');
            }

            // Update current image index
            updateCurrentImageIndex(imageSrc);
        }

        function updateCurrentImageIndex(imageSrc) {
            const thumbnailButtons = document.querySelectorAll('button[onclick*="changeMainImage"]');
            thumbnailButtons.forEach((btn, index) => {
                if (btn.getAttribute('onclick').includes(imageSrc)) {
                    currentImageIndex = index;
                }
            });
        }

        function previousImage() {
            const thumbnailButtons = document.querySelectorAll('button[onclick*="changeMainImage"]');
            if (thumbnailButtons.length === 0) return;

            // Check if we're in Arabic (RTL) mode
            const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

            if (isRTL) {
                // In Arabic, left arrow should go to next image (like right arrow in English)
                currentImageIndex = (currentImageIndex + 1) % thumbnailButtons.length;
            } else {
                // In English, left arrow goes to previous image
                currentImageIndex = (currentImageIndex - 1 + thumbnailButtons.length) % thumbnailButtons.length;
            }

            const targetButton = thumbnailButtons[currentImageIndex];
            const imageSrc = targetButton.getAttribute('onclick').match(/'([^']+)'/)[1];

            changeMainImage(imageSrc);
            updateThumbnailSelection();
        }

        function nextImage() {
            const thumbnailButtons = document.querySelectorAll('button[onclick*="changeMainImage"]');
            if (thumbnailButtons.length === 0) return;

            // Check if we're in Arabic (RTL) mode
            const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

            if (isRTL) {
                // In Arabic, right arrow should go to previous image (like left arrow in English)
                currentImageIndex = (currentImageIndex - 1 + thumbnailButtons.length) % thumbnailButtons.length;
            } else {
                // In English, right arrow goes to next image
                currentImageIndex = (currentImageIndex + 1) % thumbnailButtons.length;
            }

            const targetButton = thumbnailButtons[currentImageIndex];
            const imageSrc = targetButton.getAttribute('onclick').match(/'([^']+)'/)[1];

            changeMainImage(imageSrc);
            updateThumbnailSelection();
        }

        function updateThumbnailSelection() {
            const thumbnailButtons = document.querySelectorAll('button[onclick*="changeMainImage"]');
            thumbnailButtons.forEach((btn, index) => {
                btn.classList.remove('ring-2', 'ring-brown');
                if (index === currentImageIndex) {
                    btn.classList.add('ring-2', 'ring-brown');
                }
            });
        }

        // Load images for selected color
        function loadColorImages(colorId) {
            const productId = {{ $product->id }};

            // Show loading state
            const mainImage = document.getElementById('main-image');
            const thumbnailsContainer = document.getElementById('image-thumbnails');

            if (thumbnailsContainer) {
                thumbnailsContainer.innerHTML =
                    '<div class="col-span-full flex justify-center items-center h-20"><div class="animate-spin rounded-full h-8 w-8 border-2 border-brown"></div></div>';
            }

            // Fetch images for the selected color
            fetch(`/api/products/${productId}/color-images/${colorId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.images.length > 0) {
                        // Update main image
                        const mainImageData = data.images.find(img => img.is_main) || data.images[0];
                        mainImage.src = mainImageData.image_url;

                        // Apply dynamic background to main image
                        const mainContainer = document.getElementById('main-image-container');
                        applyDynamicBackground(mainImage, mainContainer);

                        // Update thumbnails
                        if (data.images.length > 1 && thumbnailsContainer) {
                            thumbnailsContainer.innerHTML = data.images.map((image, index) => `
                        <button onclick="changeMainImage('${image.image_path}')"
                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 ${image.is_main ? 'ring-2 ring-brown' : ''}">
                            <img src="${image.image_url}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-20 sm:h-24 lg:h-28 object-contain aspect-[2/3]">
                        </button>
                    `).join('');

                            // Apply dynamic backgrounds to thumbnails
                            setTimeout(() => {
                                const thumbnailImages = thumbnailsContainer.querySelectorAll('img');
                                const thumbnailButtons = thumbnailsContainer.querySelectorAll('button');
                                thumbnailImages.forEach((img, index) => {
                                    applyDynamicBackground(img, thumbnailButtons[index]);
                                });
                            }, 100);
                        } else if (thumbnailsContainer) {
                            thumbnailsContainer.innerHTML = '';
                        }

                        // Reinitialize navigation for new images
                        initializeImageNavigation();
                    }
                })
                .catch(error => {
                    console.error('Error loading color images:', error);
                    if (thumbnailsContainer) {
                        thumbnailsContainer.innerHTML =
                            '<div class="col-span-full text-center text-gray-500">No images available</div>';
                    }
                });
        }


        function increaseQuantity() {
            const input = document.getElementById('quantity-input');
            const max = parseInt(input.getAttribute('max'));
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
                updateAddToCartPrice();
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateAddToCartPrice();
            }
        }

        // Update Add to Cart button price
        function updateAddToCartPrice() {
            const quantityInput = document.getElementById('quantity-input');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const stickyAddToCartBtn = document.getElementById('sticky-add-to-cart-btn');

            if (!quantityInput) return;

            const quantity = parseInt(quantityInput.value) || 1;

            // Update main Add to Cart button
            if (addToCartBtn) {
                const priceSpan = addToCartBtn.querySelector('.add-to-cart-price');
                if (priceSpan) {
                    const basePrice = parseFloat(priceSpan.getAttribute('data-base-price')) || 0;
                    const totalPrice = (basePrice * quantity).toFixed(2);
                    priceSpan.textContent = `- ${totalPrice} DH`;
                }
            }

            // Sticky button is now "Buy it Now" - no price update needed
        }

        function addToCart() {
            // Clear previous errors
            clearValidationErrors();

            // Get selected options from product form
            const productForm = document.getElementById('product-form');
            const selectedColor = productForm.querySelector('input[name="color"]:checked')?.value || null;
            const selectedSize = productForm.querySelector('input[name="size"]:checked')?.value || null;
            const quantity = parseInt(productForm.querySelector('input[name="quantity"]').value) || 1;

            // Check if colors are required and not selected
            const colorSection = document.getElementById('color-section');
            const sizeSection = document.getElementById('size-section');
            let hasErrors = false;

            if (colorSection && !selectedColor) {
                showValidationError('color-error');
                hasErrors = true;
            }

            if (sizeSection && !selectedSize) {
                showValidationError('size-error');
                hasErrors = true;
            }

            if (hasErrors) {
                // Scroll to first error section
                const firstErrorSection = colorSection && !selectedColor ? colorSection : sizeSection;
                if (firstErrorSection) {
                    firstErrorSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                return;
            }

            // Disable button and show loading
            const addToCartBtn = event.target.closest('button');
            const originalContent = addToCartBtn.innerHTML;
            addToCartBtn.disabled = true;
            addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + '{{ __('messages.adding_to_cart') }}';

            // Prepare cart data
            const cartData = {
                product_id: {{ $product->id }},
                quantity: quantity,
                color: selectedColor,
                size: selectedSize
            };

            // Send to cart
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(cartData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count if function exists
                        if (typeof updateCartCount === 'function') {
                            updateCartCount();
                        }

                        // Open cart sidebar
                        if (typeof openCartSidebar === 'function') {
                            openCartSidebar();
                        } else {
                            // Fallback to notification if sidebar function doesn't exist
                            showNotification(data.message || '{{ __('messages.added_to_cart_successfully') }}',
                                'success');
                        }

                        // Reset button
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = originalContent;
                    } else {
                        showNotification(data.message || '{{ __('messages.an_error_occurred') }}', 'error');
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = originalContent;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('{{ __('messages.error_adding_to_cart') }}', 'error');
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = originalContent;
                });
        }

        // Buy it Now function - shows checkout form
        function buyItNow() {
            // Clear previous errors
            clearValidationErrors();

            // Get selected options from product form
            const productForm = document.getElementById('product-form');
            const selectedColor = productForm.querySelector('input[name="color"]:checked')?.value || null;
            const selectedSize = productForm.querySelector('input[name="size"]:checked')?.value || null;
            const quantity = parseInt(productForm.querySelector('input[name="quantity"]').value) || 1;

            // Check if colors are required and not selected
            const colorSection = document.getElementById('color-section');
            const sizeSection = document.getElementById('size-section');
            let hasErrors = false;

            if (colorSection && !selectedColor) {
                showValidationError('color-error');
                hasErrors = true;
            }

            if (sizeSection && !selectedSize) {
                showValidationError('size-error');
                hasErrors = true;
            }

            if (hasErrors) {
                // Scroll to first error section
                const firstErrorSection = colorSection && !selectedColor ? colorSection : sizeSection;
                if (firstErrorSection) {
                    firstErrorSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                return;
            }

            // Update the hidden form fields with selected values
            document.getElementById('selected-color').value = selectedColor || '';
            document.getElementById('selected-size').value = selectedSize || '';
            document.getElementById('selected-quantity').value = quantity;

            // Show the checkout form
            const checkoutForm = document.getElementById('checkout-form');
            checkoutForm.classList.remove('hidden');

            // Scroll to the form smoothly
            checkoutForm.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Reset form fields
            document.getElementById('full_name').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('city').value = '';
            document.getElementById('address').value = '';
            document.getElementById('notes').value = '';
        }

        // Toggle Wishlist function
        function toggleWishlist(productId) {
            const wishlistBtn = document.getElementById('wishlist-btn-' + productId);
            const wishlistIcon = document.getElementById('wishlist-icon-' + productId);

            // Check if already in wishlist (filled heart means it's in wishlist)
            const isInWishlist = wishlistIcon.classList.contains('fas');

            if (isInWishlist) {
                // If already in wishlist, redirect to wishlist page
                window.location.href = '{{ route('wishlist.index') }}';
                return;
            }

            // Disable button during request
            wishlistBtn.disabled = true;

            fetch('{{ route('wishlist.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update icon state
                        if (data.in_wishlist) {
                            wishlistIcon.classList.remove('far');
                            wishlistIcon.classList.add('fas');
                            wishlistIcon.classList.add('text-black');
                            wishlistIcon.classList.remove('text-brown');
                            wishlistBtn.classList.remove('bg-brown', 'text-white');
                            wishlistBtn.classList.add('border-grey', 'text-brown', 'hover:bg-gray-50');
                        } else {
                            wishlistIcon.classList.remove('fas', 'text-black');
                            wishlistIcon.classList.add('far', 'text-brown');
                            wishlistBtn.classList.remove('bg-brown', 'text-white');
                            wishlistBtn.classList.add('border-grey', 'text-brown', 'hover:bg-gray-50');
                        }
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message || (document.documentElement.lang === 'ar' ? 'حدث خطأ' :
                            'An error occurred'), 'error');
                    }
                    wishlistBtn.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification(document.documentElement.lang === 'ar' ? 'حدث خطأ' : 'An error occurred', 'error');
                    wishlistBtn.disabled = false;
                });
        }

        // Check wishlist status on page load
        function checkWishlistStatus(productId) {
            fetch('{{ route('wishlist.check') }}?product_id=' + productId, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.in_wishlist) {
                        const wishlistBtn = document.getElementById('wishlist-btn-' + productId);
                        const wishlistIcon = document.getElementById('wishlist-icon-' + productId);

                        if (wishlistBtn && wishlistIcon) {
                            wishlistIcon.classList.remove('far', 'text-brown');
                            wishlistIcon.classList.add('fas', 'text-black');
                            wishlistBtn.classList.remove('bg-brown', 'text-white');
                            wishlistBtn.classList.add('border-grey', 'text-brown', 'hover:bg-gray-50');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking wishlist:', error);
                });
        }

        function clearValidationErrors() {
            const colorError = document.getElementById('color-error');
            const sizeError = document.getElementById('size-error');

            if (colorError) colorError.classList.add('hidden');
            if (sizeError) sizeError.classList.add('hidden');
        }

        function showValidationError(errorId) {
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.classList.remove('hidden');
            }
        }

        function hideCheckoutForm() {
            document.getElementById('checkout-form').classList.add('hidden');
        }

        function hideThankYou() {
            document.getElementById('thank-you-section').classList.add('hidden');
            document.getElementById('checkout-form').classList.add('hidden');
        }

        // Notification System
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const isRTL = document.documentElement.dir === 'rtl';
            notification.className = `fixed top-4 ${isRTL ? 'left-4' : 'right-4'} z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
            notification.innerHTML = `
        <div class="flex items-center ${isRTL ? 'flex-row-reverse' : ''}">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} ${isRTL ? 'ml-2' : 'mr-2'}"></i>
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
                notification.style.transform = `translateX(${isRTL ? '-100%' : '100%'})`;
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Promotional Countdown Timer Function (Inline in Price Section)
        function initProductPromotionalCountdown() {
            const countdownContainer = document.querySelector('.product-price-countdown');
            if (!countdownContainer) return;

            const endDateElement = countdownContainer.querySelector('.product-countdown-end-date');
            if (!endDateElement) return;

            const endDate = new Date(endDateElement.dataset.endDate).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    countdownContainer.style.display = 'none';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const daysElement = document.getElementById('product-countdown-days');
                const hoursElement = document.getElementById('product-countdown-hours');
                const minutesElement = document.getElementById('product-countdown-minutes');
                const secondsElement = document.getElementById('product-countdown-seconds');

                if (daysElement) daysElement.textContent = String(days).padStart(2, '0');
                if (hoursElement) hoursElement.textContent = String(hours).padStart(2, '0');
                if (minutesElement) minutesElement.textContent = String(minutes).padStart(2, '0');
                if (secondsElement) secondsElement.textContent = String(seconds).padStart(2, '0');

                // Pulse animation on seconds change
                if (secondsElement) {
                    secondsElement.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        secondsElement.style.transform = 'scale(1)';
                    }, 200);
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Countdown Timer Functions
        function initializeCountdownTimer() {
            const countdownTimer = document.getElementById('countdown-timer');
            if (!countdownTimer) return;

            const endTime = parseInt(countdownTimer.getAttribute('data-end-time'));
            const endDate = new Date(endTime * 1000);

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDate.getTime() - now;

                if (distance < 0) {
                    // Sale has ended
                    countdownTimer.innerHTML = '<div class="text-center text-red-500 font-bold">' +
                        '{{ __('messages.sale_ended') }}' + '</div>';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update the countdown display
                const daysElement = document.getElementById('countdown-days');
                const hoursElement = document.getElementById('countdown-hours');
                const minutesElement = document.getElementById('countdown-minutes');
                const secondsElement = document.getElementById('countdown-seconds');

                if (daysElement) daysElement.textContent = days.toString().padStart(2, '0');
                if (hoursElement) hoursElement.textContent = hours.toString().padStart(2, '0');
                if (minutesElement) minutesElement.textContent = minutes.toString().padStart(2, '0');
                if (secondsElement) secondsElement.textContent = seconds.toString().padStart(2, '0');
            }

            // Update immediately
            updateCountdown();

            // Update every second
            setInterval(updateCountdown, 1000);
        }

        // Initialize image navigation with touch support
        function initializeImageNavigation() {
            const mainContainer = document.getElementById('main-image-container');
            const prevBtn = document.getElementById('prev-image-btn');
            const nextBtn = document.getElementById('next-image-btn');

            if (!mainContainer) return;

            // Check if there are multiple images
            const thumbnailButtons = document.querySelectorAll('button[onclick*="changeMainImage"]');
            const hasMultipleImages = thumbnailButtons.length > 1;

            // Show/hide navigation buttons based on image count
            if (prevBtn && nextBtn) {
                if (hasMultipleImages) {
                    prevBtn.style.display = 'flex';
                    nextBtn.style.display = 'flex';
                } else {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                }
            }

            // Touch/swipe support
            let startX = 0;
            let startY = 0;
            let endX = 0;
            let endY = 0;

            mainContainer.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
            });

            mainContainer.addEventListener('touchend', function(e) {
                endX = e.changedTouches[0].clientX;
                endY = e.changedTouches[0].clientY;
                handleSwipe();
            });

            function handleSwipe() {
                if (!hasMultipleImages) return;

                const deltaX = endX - startX;
                const deltaY = endY - startY;

                // Check if it's a horizontal swipe (not vertical scroll)
                if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                    // Check if we're in Arabic (RTL) mode
                    const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

                    if (isRTL) {
                        // In Arabic, swipe right goes to previous, swipe left goes to next
                        if (deltaX > 0) {
                            previousImage();
                        } else {
                            nextImage();
                        }
                    } else {
                        // In English, swipe right goes to previous, swipe left goes to next
                        if (deltaX > 0) {
                            previousImage();
                        } else {
                            nextImage();
                        }
                    }
                }
            }

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (!hasMultipleImages) return;

                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    previousImage();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    nextImage();
                }
            });

            // Initialize current image index
            thumbnailButtons.forEach((btn, index) => {
                if (btn.classList.contains('ring-2')) {
                    currentImageIndex = index;
                }
            });
        }

        // Handle color and size selection visual feedback
        document.addEventListener('DOMContentLoaded', function() {
            // Apply dynamic backgrounds to initial images
            const mainImage = document.getElementById('main-image');
            const mainContainer = document.getElementById('main-image-container');
            if (mainImage && mainContainer) {
                applyDynamicBackground(mainImage, mainContainer);
            }

            // Initialize image navigation
            initializeImageNavigation();

            // Initialize countdown timer
            initializeCountdownTimer();
            initProductPromotionalCountdown();

            // Check wishlist status
            checkWishlistStatus({{ $product->id }});

            // Apply dynamic backgrounds to existing thumbnails
            const thumbnailImages = document.querySelectorAll('#image-thumbnails img');
            const thumbnailButtons = document.querySelectorAll('#image-thumbnails button');
            thumbnailImages.forEach((img, index) => {
                if (thumbnailButtons[index]) {
                    applyDynamicBackground(img, thumbnailButtons[index]);
                }
            });

            // Initialize color selection state
            function initializeColorSelection() {
                // Remove active state from all color options first
                document.querySelectorAll('.color-option').forEach(option => {
                    const imageContainer = option.querySelector('div');
                    imageContainer.classList.remove('border-brown', 'ring-2', 'ring-brown',
                        'ring-opacity-50');
                    imageContainer.classList.add('border-gray-300');

                    // Remove inline styles that override classes
                    imageContainer.style.borderColor = '';
                    imageContainer.style.boxShadow = '';
                    imageContainer.style.transform = '';

                    // Remove any existing check marks
                    const checkMark = option.querySelector('.absolute.top-0\\.5.right-0\\.5');
                    if (checkMark) {
                        checkMark.remove();
                    }
                });

                // Add active state to the actually checked color
                const checkedRadio = document.querySelector('input[name="color"]:checked');
                if (checkedRadio) {
                    const selectedOption = checkedRadio.closest('.color-option');
                    const imageContainer = selectedOption.querySelector('div');
                    imageContainer.classList.remove('border-gray-300');
                    imageContainer.classList.add('border-brown', 'ring-2', 'ring-brown', 'ring-opacity-50');

                    // Add check mark
                    const checkMark = document.createElement('div');
                    checkMark.className =
                        'absolute top-0.5 right-0.5 w-3 h-3 bg-brown rounded-full flex items-center justify-center';
                    checkMark.innerHTML = '<i class="fas fa-check text-white text-xs"></i>';
                    imageContainer.appendChild(checkMark);
                }
            }

            // Initialize on page load
            initializeColorSelection();

            // Initialize Add to Cart price display
            updateAddToCartPrice();

            // Listen for quantity input changes
            const quantityInput = document.getElementById('quantity-input');
            if (quantityInput) {
                quantityInput.addEventListener('input', function() {
                    updateAddToCartPrice();
                });
                quantityInput.addEventListener('change', function() {
                    updateAddToCartPrice();
                });
            }

            // Handle color selection changes
            document.querySelectorAll('input[name="color"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove active state from all color options
                    document.querySelectorAll('.color-option').forEach(option => {
                        const imageContainer = option.querySelector('div');
                        imageContainer.classList.remove('border-brown', 'ring-2',
                            'ring-brown', 'ring-opacity-50');
                        imageContainer.classList.add('border-gray-300');

                        // Remove inline styles that override classes
                        imageContainer.style.borderColor = '';
                        imageContainer.style.boxShadow = '';
                        imageContainer.style.transform = '';

                        // Remove check mark
                        const checkMark = option.querySelector(
                            '.absolute.top-0\\.5.right-0\\.5');
                        if (checkMark) {
                            checkMark.remove();
                        }
                    });

                    // Add active state to selected color
                    if (this.checked) {
                        const selectedOption = this.closest('.color-option');
                        const imageContainer = selectedOption.querySelector('div');
                        imageContainer.classList.remove('border-gray-300');
                        imageContainer.classList.add('border-brown', 'ring-2', 'ring-brown',
                            'ring-opacity-50');

                        // Add check mark
                        const checkMark = document.createElement('div');
                        checkMark.className =
                            'absolute top-0.5 right-0.5 w-3 h-3 bg-brown rounded-full flex items-center justify-center';
                        checkMark.innerHTML = '<i class="fas fa-check text-white text-xs"></i>';
                        imageContainer.appendChild(checkMark);

                        // Scroll to main image area on mobile when color is selected
                        if (window.innerWidth < 640) { // Only on mobile (sm breakpoint)
                            const mainImageContainer = document.getElementById(
                                'main-image-container');
                            if (mainImageContainer) {
                                // Scroll to a bit above the main image for better view
                                const rect = mainImageContainer.getBoundingClientRect();
                                const scrollTop = window.pageYOffset + rect.top -
                                    80; // 80px above the image
                                window.scrollTo({
                                    top: scrollTop,
                                    behavior: 'smooth'
                                });
                            }
                        }

                        // Load images for selected color
                        loadColorImages(this.value);
                    }
                });
            });

            // Handle size selection
            document.querySelectorAll('input[name="size"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove active state from all size options
                    document.querySelectorAll('input[name="size"]').forEach(r => {
                        r.nextElementSibling.style.backgroundColor = '';
                        r.nextElementSibling.style.color = '';
                        r.nextElementSibling.style.borderColor = '';
                        r.nextElementSibling.style.transform = '';
                    });

                    // Add active state to selected size
                    if (this.checked) {
                        this.nextElementSibling.style.backgroundColor =
                            'var(--color-brown-primary)';
                        this.nextElementSibling.style.color = 'white';
                        this.nextElementSibling.style.borderColor = 'var(--color-brown-primary)';
                        this.nextElementSibling.style.transform = 'scale(1.05)';
                    }
                });
            });

            // Initialize active states for pre-selected options
            const selectedColor = document.querySelector('input[name="color"]:checked');
            if (selectedColor) {
                selectedColor.nextElementSibling.style.borderColor = 'var(--color-brown-primary)';
                selectedColor.nextElementSibling.style.boxShadow = '0 0 0 2px var(--color-brown-light)';
                selectedColor.nextElementSibling.style.transform = 'scale(1.1)';
            }

            const selectedSize = document.querySelector('input[name="size"]:checked');
            if (selectedSize) {
                selectedSize.nextElementSibling.style.backgroundColor = 'var(--color-brown-primary)';
                selectedSize.nextElementSibling.style.color = 'white';
                selectedSize.nextElementSibling.style.borderColor = 'var(--color-brown-primary)';
                selectedSize.nextElementSibling.style.transform = 'scale(1.05)';
            }

            // Update sticky button when selections change
            function updateStickyButton() {
                const selectedColor = document.querySelector('input[name="color"]:checked');
                const selectedSize = document.querySelector('input[name="size"]:checked');
                const quantity = document.querySelector('input[name="quantity"]').value;

                // Update sticky button display (optional - could show selected options)
                const stickyButton = document.querySelector('.fixed.bottom-0 button');
                if (stickyButton) {
                    // You could add visual feedback here if needed
                }
            }

            // Add event listeners to update sticky button and clear errors
            document.querySelectorAll('input[name="color"], input[name="size"], input[name="quantity"]').forEach(
                input => {
                    input.addEventListener('change', function() {
                        updateStickyButton();
                        // Clear validation errors when user makes a selection
                        if (this.name === 'color') {
                            const colorError = document.getElementById('color-error');
                            if (colorError) colorError.classList.add('hidden');
                        }
                        if (this.name === 'size') {
                            const sizeError = document.getElementById('size-error');
                            if (sizeError) sizeError.classList.add('hidden');
                        }
                    });
                });
        });

        // Handle order form submission
        document.addEventListener('DOMContentLoaded', function() {
            const orderForm = document.getElementById('order-form');
            const submitBtn = document.getElementById('submit-order-btn');

            if (orderForm) {
                orderForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Show loading state
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.processing') }}';
                    submitBtn.disabled = true;

                    // Submit form
                    fetch('{{ route('orders.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: orderForm.querySelector('input[name="product_id"]')
                                    .value,
                                color: orderForm.querySelector('input[name="color"]').value ||
                                    null,
                                size: orderForm.querySelector('input[name="size"]').value ||
                                    null,
                                quantity: parseInt(orderForm.querySelector(
                                        'input[name="quantity"]')
                                    .value) || 1,
                                full_name: orderForm.querySelector('input[name="full_name"]')
                                    .value,
                                phone: orderForm.querySelector('input[name="phone"]').value,
                                city: orderForm.querySelector('select[name="city"]').value,
                                address: orderForm.querySelector('textarea[name="address"]')
                                    .value,
                                notes: orderForm.querySelector('textarea[name="notes"]')
                                    .value || ''
                            })
                        })
                        .then(response => {
                            return response.json().then(data => {
                                if (!response.ok) {
                                    // Handle validation errors
                                    if (response.status === 422 && data.errors) {
                                        const errorMessages = Object.values(data.errors).flat()
                                            .join('\n');
                                        throw new Error(errorMessages);
                                    }
                                    throw new Error(data.message ||
                                        '{{ __('messages.error_processing_order') }}');
                                }
                                return data;
                            });
                        })
                        .then(data => {
                            if (data.success) {
                                // Redirect to thank you page
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    // Fallback: show thank you section
                                    document.getElementById('checkout-form').classList.add('hidden');
                                    document.getElementById('thank-you-section').classList.remove(
                                        'hidden');
                                    document.getElementById('thank-you-section').scrollIntoView({
                                        behavior: 'smooth'
                                    });
                                }
                            } else {
                                // Show error message
                                showNotification(data.message ||
                                    '{{ __('messages.error_processing_order') }}', 'error');
                                submitBtn.innerHTML =
                                    '<i class="fas fa-credit-card {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.confirm_order') }}';
                                submitBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification(error.message ||
                                '{{ __('messages.error_processing_order') }}', 'error');
                            submitBtn.innerHTML =
                                '<i class="fas fa-credit-card {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.confirm_order') }}';
                            submitBtn.disabled = false;
                        });
                });
            }
        });

        // Testimonials Carousel
        document.addEventListener('DOMContentLoaded', function() {
            let currentTestimonialIndex = 0;
            let testimonialInterval;
            const testimonialSlides = document.querySelectorAll('.testimonial-slide');
            const testimonialDots = document.querySelectorAll('.testimonial-dot');
            const totalTestimonials = testimonialSlides.length;

            function showTestimonial(index) {
                if (totalTestimonials === 0) return;

                // Ensure index is within bounds
                if (index < 0) index = totalTestimonials - 1;
                if (index >= totalTestimonials) index = 0;

                currentTestimonialIndex = index;

                // Move carousel
                const carousel = document.getElementById('testimonials-carousel');
                if (carousel) {
                    carousel.style.transform = `translateX(-${index * 100}%)`;
                }

                // Update dots
                testimonialDots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.add('bg-brown', 'w-8', 'sm:w-10');
                        dot.classList.remove('bg-gray-300', 'w-2', 'sm:w-3');
                    } else {
                        dot.classList.remove('bg-brown', 'w-8', 'sm:w-10');
                        dot.classList.add('bg-gray-300', 'w-2', 'sm:w-3');
                    }
                });
            }

            function nextTestimonial() {
                showTestimonial(currentTestimonialIndex + 1);
            }

            function prevTestimonial() {
                showTestimonial(currentTestimonialIndex - 1);
            }

            function startTestimonialCarousel() {
                // Always stop any existing interval first
                stopTestimonialCarousel();

                if (totalTestimonials > 1) {
                    // Start fresh interval - wait full 8 seconds
                    testimonialInterval = setInterval(nextTestimonial, 8000);
                }
            }

            function stopTestimonialCarousel() {
                if (testimonialInterval) {
                    clearInterval(testimonialInterval);
                    testimonialInterval = null; // Clear the reference
                }
            }

            // Initialize testimonials carousel
            if (totalTestimonials > 0) {
                // Show first testimonial
                showTestimonial(0);

                // Navigation buttons
                const prevBtn = document.getElementById('testimonial-prev');
                const nextBtn = document.getElementById('testimonial-next');

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        stopTestimonialCarousel();
                        prevTestimonial();
                        // Wait a tiny bit to ensure interval is fully cleared, then restart
                        setTimeout(() => {
                            startTestimonialCarousel();
                        }, 50);
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        stopTestimonialCarousel();
                        nextTestimonial();
                        // Wait a tiny bit to ensure interval is fully cleared, then restart
                        setTimeout(() => {
                            startTestimonialCarousel();
                        }, 50);
                    });
                }

                // Dot navigation
                testimonialDots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        stopTestimonialCarousel();
                        showTestimonial(index);
                        // Wait a tiny bit to ensure interval is fully cleared, then restart
                        setTimeout(() => {
                            startTestimonialCarousel();
                        }, 50);
                    });
                });

                // Pause on hover
                const carouselContainer = document.getElementById('testimonials-carousel')?.parentElement;
                if (carouselContainer) {
                    carouselContainer.addEventListener('mouseenter', () => {
                        stopTestimonialCarousel();
                    });
                    carouselContainer.addEventListener('mouseleave', () => {
                        // Small delay to ensure clean restart
                        setTimeout(() => {
                            startTestimonialCarousel();
                        }, 50);
                    });
                }

                // Start auto-rotation
                startTestimonialCarousel();
            }
        });

        // Review Modal
        const openReviewModalBtn = document.getElementById('open-review-modal');
        const closeReviewModalBtn = document.getElementById('close-review-modal');
        const cancelReviewModalBtn = document.getElementById('cancel-review-modal');
        const reviewModal = document.getElementById('review-modal');

        function openReviewModal() {
            if (reviewModal) {
                reviewModal.classList.remove('hidden');
                reviewModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeReviewModal() {
            if (reviewModal) {
                reviewModal.classList.add('hidden');
                reviewModal.classList.remove('flex');
                document.body.style.overflow = '';
                // Reset form
                const form = document.getElementById('review-form');
                if (form) {
                    form.reset();
                    const selectedRating = document.getElementById('modal-selected-rating');
                    if (selectedRating) selectedRating.value = '';
                    // Reset stars
                    const modalStars = document.querySelectorAll('.modal-rating-star');
                    modalStars.forEach(s => {
                        s.querySelector('i').classList.remove('text-yellow-400');
                        s.querySelector('i').classList.add('text-gray-300');
                    });
                }
            }
        }

        if (openReviewModalBtn) {
            openReviewModalBtn.addEventListener('click', openReviewModal);
        }

        if (closeReviewModalBtn) {
            closeReviewModalBtn.addEventListener('click', closeReviewModal);
        }

        if (cancelReviewModalBtn) {
            cancelReviewModalBtn.addEventListener('click', closeReviewModal);
        }

        // Ask a Question Modal
        function openAskQuestionModal() {
            const modal = document.getElementById('ask-question-modal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeAskQuestionModal() {
            const modal = document.getElementById('ask-question-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                const form = document.getElementById('ask-question-form');
                if (form) form.reset();
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const askModal = document.getElementById('ask-question-modal');
            if (askModal && !askModal.classList.contains('hidden') && e.target === askModal) {
                closeAskQuestionModal();
            }

            // Delivery modal removed

            const shareModal = document.getElementById('share-modal');
            if (shareModal && !shareModal.classList.contains('hidden') && e.target === shareModal) {
                closeShareModal();
            }
        });

        // Ask Question Form Submission
        const askQuestionForm = document.getElementById('ask-question-form');
        if (askQuestionForm) {
            askQuestionForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalContent = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __('messages.submitting') }}';

                const formData = new FormData(this);

                fetch('{{ route('questions.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            closeAskQuestionModal();
                        } else {
                            showNotification(data.message || '{{ __('messages.an_error_occurred') }}',
                                'error');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalContent;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('{{ __('messages.error_submitting_question') }}', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalContent;
                    });
            });
        }

        // Delivery & Return Modal removed

        // Share Modal
        function openShareModal() {
            const modal = document.getElementById('share-modal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeShareModal() {
            const modal = document.getElementById('share-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Share Functions
        function shareOnFacebook(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $product->name }}');
            window.open(`https://www.facebook.com/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }

        function shareOnTwitter(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $product->name }}');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }

        function shareOnPinterest(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $product->name }}');
            const image = encodeURIComponent(
                '{{ $product->main_image ? asset('storage/' . $product->main_image) : '' }}');
            window.open(`https://www.pinterest.com/pin/create/button/?description=${text}&media=${image}&url=${url}`,
                '_blank', 'width=600,height=400');
        }

        function shareOnWhatsApp(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            window.open(`https://wa.me/?text=${url}`, '_blank');
        }

        function shareViaEmail(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const subject = encodeURIComponent('{{ $product->name }}');
            const body = encodeURIComponent(`Check out this site: ${window.location.href}`);
            window.location.href = `mailto:?subject=${subject}&body=${body}`;
        }

        function copyShareLink() {
            const input = document.getElementById('share-link-input');
            if (input) {
                input.select();
                input.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');
                showNotification('{{ __('messages.link_copied') }}', 'success');
            }
        }

        // Close modal when clicking outside
        if (reviewModal) {
            reviewModal.addEventListener('click', (e) => {
                if (e.target === reviewModal) {
                    closeReviewModal();
                }
            });
        }

        // Close modal on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && reviewModal && !reviewModal.classList.contains('hidden')) {
                closeReviewModal();
            }
        });

        // Review Form and Rating Selector (Modal)
        const modalRatingStars = document.querySelectorAll('.modal-rating-star');
        const modalSelectedRatingInput = document.getElementById('modal-selected-rating');

        if (modalRatingStars.length > 0 && modalSelectedRatingInput) {
            modalRatingStars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    modalSelectedRatingInput.value = rating;

                    // Update visual display - left to right (1 to 5)
                    modalRatingStars.forEach((s, i) => {
                        const starIndex = i + 1; // 1, 2, 3, 4, 5
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
                    modalRatingStars.forEach((s, i) => {
                        const starIndex = i + 1; // 1, 2, 3, 4, 5
                        if (starIndex <= rating) {
                            s.querySelector('i').classList.add('text-yellow-400');
                        }
                    });
                });

                star.addEventListener('mouseleave', function() {
                    if (!modalSelectedRatingInput.value) {
                        modalRatingStars.forEach(s => {
                            s.querySelector('i').classList.remove('text-yellow-400');
                            s.querySelector('i').classList.add('text-gray-300');
                        });
                    } else {
                        // Restore selected rating
                        const selectedRating = parseInt(modalSelectedRatingInput.value);
                        modalRatingStars.forEach((s, i) => {
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

        // Reviews Section JavaScript - Category Style Reviews
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
                reviewFormWrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
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
                            const icon = s.querySelector('i');
                            if (icon) {
                                if (starIndex <= rating) {
                                    icon.classList.remove('text-gray-300');
                                    icon.classList.add('text-yellow-400');
                                } else {
                                    icon.classList.remove('text-yellow-400');
                                    icon.classList.add('text-gray-300');
                                }
                            }
                        });
                    });

                    star.addEventListener('mouseenter', function() {
                        const rating = parseInt(this.getAttribute('data-rating'));
                        categoryRatingStars.forEach((s, i) => {
                            const starIndex = i + 1;
                            const icon = s.querySelector('i');
                            if (icon && starIndex <= rating) {
                                icon.classList.add('text-yellow-400');
                            }
                        });
                    });

                    star.addEventListener('mouseleave', function() {
                        if (!categorySelectedRating || !categorySelectedRating.value) {
                            categoryRatingStars.forEach(s => {
                                const icon = s.querySelector('i');
                                if (icon) {
                                    icon.classList.remove('text-yellow-400');
                                    icon.classList.add('text-gray-300');
                                }
                            });
                        } else {
                            const selectedRating = parseInt(categorySelectedRating.value);
                            categoryRatingStars.forEach((s, i) => {
                                const starIndex = i + 1;
                                const icon = s.querySelector('i');
                                if (icon) {
                                    if (starIndex <= selectedRating) {
                                        icon.classList.remove('text-gray-300');
                                        icon.classList.add('text-yellow-400');
                                    } else {
                                        icon.classList.remove('text-yellow-400');
                                        icon.classList.add('text-gray-300');
                                    }
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
                        alert('{{ __('messages.please_select_rating') }}');
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
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __('messages.submitting') }}...';

                    fetch('{{ route('reviews.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message ||
                                    '{{ __('messages.review_added_successfully') }}');
                                closeReviewFormFunc();
                                // Reload page to show new review
                                window.location.reload();
                            } else {
                                alert(data.message || '{{ __('messages.error_adding_review') }}');
                                submitBtn.innerHTML = originalContent;
                                submitBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('{{ __('messages.error_adding_review') }}');
                            submitBtn.innerHTML = originalContent;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Review Sorting
            if (reviewSort && reviewsList) {
                reviewSort.addEventListener('change', function() {
                    const sortValue = this.value;
                    const reviewItems = Array.from(reviewsList.querySelectorAll('.jdgm-rev.review-item'));

                    reviewItems.sort((a, b) => {
                        switch (sortValue) {
                            case 'highest-rating':
                                return parseInt(b.getAttribute('data-rating')) - parseInt(a
                                    .getAttribute('data-rating'));
                            case 'lowest-rating':
                                return parseInt(a.getAttribute('data-rating')) - parseInt(b
                                    .getAttribute('data-rating'));
                            case 'only-pictures':
                                const aHasMedia = a.getAttribute('data-has-media') === 'true';
                                const bHasMedia = b.getAttribute('data-has-media') === 'true';
                                if (aHasMedia && !bHasMedia) return -1;
                                if (!aHasMedia && bHasMedia) return 1;
                                return 0;
                            case 'most-recent':
                            default:
                                return 0; // Already sorted by most recent
                        }
                    });

                    // Clear and re-append sorted items
                    reviewsList.innerHTML = '';
                    reviewItems.forEach(item => reviewsList.appendChild(item));
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
                        // Show all reviews
                        const allReviews = reviewsList.querySelectorAll('.jdgm-rev.review-item');
                        allReviews.forEach(review => review.style.display = '');
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
                        // Filter reviews
                        const allReviews = reviewsList.querySelectorAll('.jdgm-rev.review-item');
                        allReviews.forEach(review => {
                            const reviewRating = parseInt(review.getAttribute(
                                'data-rating'));
                            if (reviewRating === selectedRating) {
                                review.style.display = '';
                            } else {
                                review.style.display = 'none';
                            }
                        });
                    }

                    // Scroll to reviews list section
                    if (reviewsList) {
                        const offset = 80; // Offset for fixed headers/navbar
                        const elementPosition = reviewsList.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - offset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Gallery Lightbox Modal Functionality
            const galleryModal = document.getElementById('gallery-lightbox-modal');
            const lightboxMainImage = document.getElementById('lightbox-main-image');
            const lightboxMainVideo = document.getElementById('lightbox-main-video');
            const lightboxReviewContent = document.getElementById('lightbox-review-content');
            const closeGalleryModal = document.getElementById('close-gallery-modal');
            const galleryThumbnailsContainer = document.getElementById('jdgm-gallery-thumbnails');
            const galleryGridContainer = document.getElementById('gallery-thumbnails-grid');
            const allMediaReviewsDataContainer = document.getElementById('all-media-reviews-data');

            let currentMediaIndex = 0;
            const mediaReviewsData = [];
            const mediaByReviewId = {};

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
                    mediaByReviewId[reviewId] = index;
                });
            }

            // Function to attach click handlers to gallery grid thumbnails
            function attachGalleryThumbnailHandlers() {
                if (!galleryGridContainer) return;
                const galleryThumbnails = galleryGridContainer.querySelectorAll('.gallery-thumbnail');
                galleryThumbnails.forEach((thumb) => {
                    if (!thumb.hasAttribute('data-handler-attached')) {
                        thumb.setAttribute('data-handler-attached', 'true');
                        thumb.addEventListener('click', function() {
                            const index = parseInt(this.getAttribute('data-media-index'));
                            if (!isNaN(index)) {
                                openGalleryFromReview(this.getAttribute('data-review-id'));
                            }
                        });
                    }
                });
            }

            // Function to load review content
            function loadReviewContent(reviewId) {
                if (window.reviewsData && window.reviewsData[reviewId]) {
                    const review = window.reviewsData[reviewId];
                    let starsHtml = '';
                    for (let i = 1; i <= 5; i++) {
                        starsHtml +=
                            `<span class="jdgm-star jdgm--${i <= review.rating ? 'on' : 'off'}"><i class="fas fa-star ${i <= review.rating ? 'text-yellow-400' : 'text-gray-300'} text-sm"></i></span>`;
                    }

                    if (lightboxReviewContent) {
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
            }

            // Function to update lightbox with selected media
            function updateLightbox(index) {
                if (index < 0 || index >= mediaReviewsData.length) return;

                currentMediaIndex = index;
                const mediaData = mediaReviewsData[index];
                const isVideo = mediaData.isVideo || (mediaData.mediaUrl && (mediaData.mediaUrl.includes('.mp4') ||
                    mediaData.mediaUrl.includes('.mov') || mediaData.mediaUrl.includes('.m4v')));

                // Update main image/video
                if (lightboxMainImage && lightboxMainVideo) {
                    if (isVideo) {
                        lightboxMainVideo.src = mediaData.mediaUrl;
                        lightboxMainVideo.classList.remove('hidden');
                        lightboxMainImage.classList.add('hidden');
                        lightboxMainVideo.load();
                    } else {
                        lightboxMainImage.src = mediaData.mediaUrl;
                        lightboxMainImage.classList.remove('hidden');
                        lightboxMainVideo.classList.add('hidden');
                        lightboxMainVideo.pause();
                    }
                }

                // Update thumbnail selection
                if (galleryThumbnailsContainer) {
                    const lightboxThumbnails = galleryThumbnailsContainer.querySelectorAll(
                        '.jdgm-gallery__thumbnail-link');
                    lightboxThumbnails.forEach((thumb) => {
                        const thumbIndex = parseInt(thumb.getAttribute('data-media-index'));
                        if (thumbIndex === index) {
                            thumb.classList.add('jdgm-gallery__thumbnail-link--current', 'border-brown');
                            thumb.classList.remove('border-transparent');
                            thumb.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest',
                                inline: 'center'
                            });
                        } else {
                            thumb.classList.remove('jdgm-gallery__thumbnail-link--current', 'border-brown');
                            thumb.classList.add('border-transparent');
                        }
                    });
                }

                // Load review content
                loadReviewContent(mediaData.reviewId);
            }

            // Function to attach click handlers to lightbox thumbnails
            function attachThumbnailHandlers() {
                if (!galleryThumbnailsContainer) return;
                const lightboxThumbnails = galleryThumbnailsContainer.querySelectorAll(
                    '.jdgm-gallery__thumbnail-link');
                lightboxThumbnails.forEach((thumb) => {
                    if (!thumb.hasAttribute('data-handler-attached')) {
                        thumb.setAttribute('data-handler-attached', 'true');
                        thumb.addEventListener('click', function() {
                            const index = parseInt(this.getAttribute('data-media-index'));
                            updateLightbox(index);
                        });
                    }
                });
            }

            // Initialize lightbox
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
                                setTimeout(function() {
                                    if (galleryThumbnailsContainer) {
                                        galleryThumbnailsContainer.scrollLeft = 0;
                                    }
                                    initializeLightbox();
                                    attachThumbnailHandlers();
                                }, 10);
                            }
                            if (!isVisible) {
                                lightboxInitialized = false;
                                if (galleryThumbnailsContainer) {
                                    galleryThumbnailsContainer.scrollLeft = 0;
                                }
                            }
                        }
                    });
                });
                observer.observe(galleryModal, {
                    attributes: true
                });
            }

            // Function to open gallery from review image
            window.openGalleryFromReview = function(reviewId) {
                const reviewIdNum = parseInt(reviewId);
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

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (galleryModal && !galleryModal.classList.contains('hidden')) {
                    if (e.key === 'ArrowLeft' && currentMediaIndex > 0) {
                        updateLightbox(currentMediaIndex - 1);
                    } else if (e.key === 'ArrowRight' && currentMediaIndex < mediaReviewsData.length - 1) {
                        updateLightbox(currentMediaIndex + 1);
                    }
                }
            });

            // Attach handlers to gallery grid thumbnails
            attachGalleryThumbnailHandlers();

            // Social Share Buttons
            document.addEventListener('click', function(e) {
                if (e.target.closest('.jdgm-rev__share-btn')) {
                    const btn = e.target.closest('.jdgm-rev__share-btn');
                    const socialMedia = btn.getAttribute('data-social-media');
                    const reviewItem = btn.closest('.jdgm-rev');
                    const reviewText = reviewItem ? reviewItem.querySelector('.jdgm-rev__body p')
                        ?.textContent : '';
                    const reviewAuthor = reviewItem ? reviewItem.querySelector('.jdgm-rev__author')
                        ?.textContent : '';

                    const url = window.location.href;
                    const text = `${reviewAuthor}: ${reviewText.substring(0, 100)}...`;
                    let shareUrl = '';

                    switch (socialMedia) {
                        case 'Facebook':
                            shareUrl =
                                `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                            break;
                        case 'Twitter':
                            shareUrl =
                                `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
                            break;
                        case 'Pinterest':
                            const imageUrl = reviewItem ? reviewItem.querySelector('.jdgm-rev__pic-img')
                                ?.src : '';
                            shareUrl =
                                `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(url)}&description=${encodeURIComponent(text)}&media=${encodeURIComponent(imageUrl || '')}`;
                            break;
                    }

                    if (shareUrl) {
                        window.open(shareUrl, '_blank', 'width=600,height=400');
                    }
                }
            });

            // Reviews AJAX Pagination
            const reviewsPaginationWrapper = document.getElementById('reviews-pagination');
            const reviewsListContainer = document.getElementById('reviews-list');
            const reviewsListSection = document.getElementById('reviews-list-section');

            if (reviewsPaginationWrapper) {
                reviewsPaginationWrapper.addEventListener('click', function(e) {
                    const link = e.target.closest('.pagination-link');
                    if (!link || link.classList.contains('pagination-link-disabled') || link.tagName ===
                        'SPAN') {
                        return;
                    }

                    e.preventDefault();

                    const url = link.getAttribute('href');
                    if (!url) return;

                    if (reviewsListContainer) {
                        reviewsListContainer.style.opacity = '0.5';
                        reviewsListContainer.style.pointerEvents = 'none';
                    }

                    const urlObj = new URL(url);
                    const page = urlObj.searchParams.get('page') || 1;

                    const ajaxUrl = new URL(window.location);
                    ajaxUrl.searchParams.set('reviews_page', page);

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
                            if (reviewsListContainer) {
                                reviewsListContainer.innerHTML = data.html;
                                reviewsListContainer.style.opacity = '1';
                                reviewsListContainer.style.pointerEvents = 'all';
                            }

                            if (reviewsPaginationWrapper && data.pagination) {
                                reviewsPaginationWrapper.innerHTML = data.pagination;
                            }

                            const reviewsCountDisplay = document.getElementById(
                                'reviews-count-display');
                            if (reviewsCountDisplay && data.count_display) {
                                reviewsCountDisplay.innerHTML = data.count_display;
                            }

                            window.history.pushState({}, '', url);

                            if (reviewsListSection) {
                                const offset = 80;
                                const elementPosition = reviewsListSection.getBoundingClientRect().top;
                                const offsetPosition = elementPosition + window.pageYOffset - offset;
                                window.scrollTo({
                                    top: offsetPosition,
                                    behavior: 'smooth'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (reviewsListContainer) {
                                reviewsListContainer.style.opacity = '1';
                                reviewsListContainer.style.pointerEvents = 'all';
                            }
                        });
                });
            }
        });
    </script>
@endpush
