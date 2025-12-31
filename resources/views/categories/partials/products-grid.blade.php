@if($products->count() > 0)
    @foreach($products as $product)
    @php
        // Get images for hover effect
        $colorImages = $product->colorImages;
        $mainImage = $product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/500x600/FFC0CB/FFFFFF?text=' . urlencode($product->name);
        $hoverImage = $colorImages->count() > 1 ? asset('storage/' . $colorImages[1]->image_path) : $mainImage;
    @endphp
    <div class="product-card overflow-hidden group transition-all duration-500">
        <div class="relative overflow-hidden">
            <a href="{{ route('products.show', $product->slug) }}" class="product-image-container block">
                <img src="{{ $mainImage }}"
                     alt="{{ $product->name }}"
                     class="{{ $colorImages->count() > 1 ? '' : 'group-hover:scale-110 transition-transform duration-700 ease-out' }}">
                @if($colorImages->count() > 1)
                <img src="{{ $hoverImage }}"
                     alt=""
                     class="opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 ease-out">
                @endif
            </a>
            @if($product->sale_price)
            @php
                $discountPercentage = round((($product->price - $product->sale_price) / $product->price) * 100);
            @endphp
            <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-500 text-white px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold shadow-lg transform -rotate-3 hover:rotate-0 transition-transform duration-300 border border-white sm:border-2 border-white z-10">
                <span class="relative z-10">-{{ $discountPercentage }}%</span>
            </div>
            @endif

            <!-- Overlay Buttons - Show on mobile always, desktop on hover -->
            <div class="product-featured-icons product-featured-icons--primary">
                <button onclick="addToCart({{ $product->id }});"
                   class="button add_to_cart_button ecomus-button product-loop-button product-loop-button-atc flex items-center justify-center em-button-light em-button-icon em-tooltip"
                   data-product_id="{{ $product->id }}"
                   aria-label="{{ __('messages.add_to_cart') }}: {{ $product->name }}"
                   data-tooltip="{{ __('messages.add_to_cart') }}">
                    <span class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--shopping-bag">
                        <svg width="20" height="20" aria-hidden="true" role="img" focusable="false" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                        </svg>
                    </span>
                </button>
                <a href="{{ route('products.show', $product->slug) }}"
                   class="ecomus-quickview-button button product-loop-button flex items-center justify-center em-button-icon em-tooltip em-button-light"
                   data-id="{{ $product->id }}"
                   data-tooltip="{{ __('messages.quick_view') }}"
                   aria-label="{{ __('messages.quick_view') }} {{ $product->name }}"
                   rel="nofollow">
                    <span class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--eye">
                        <svg width="20" height="20" aria-hidden="true" role="img" focusable="false" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('products.show', $product->slug) }}">
                <h3 class="text-base font-normal text-brown mb-2 line-clamp-2 hover:opacity-80 transition-opacity cursor-pointer">{{ $product->name }}</h3>
            </a>
            <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                @if($product->sale_price)
                <span class="text-base font-semibold text-red-500">${{ number_format($product->sale_price, 2) }}</span>
                <span class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                @else
                <span class="text-base font-semibold text-brown">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="col-span-full text-center py-16">
        <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
            <i class="fas fa-tag text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">
            {{ __('messages.no_products_match_filters') }}
        </h3>
        <p class="text-gray-500 mb-6">
            {{ __('messages.try_changing_filters') }}
        </p>
        <button onclick="resetFilters()" class="btn-brown-gradient py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105">
            {{ __('messages.reset_filters') }}
        </button>
    </div>
@endif
