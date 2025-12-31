@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'قائمة الأمنيات' : 'Wishlist')

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
                <li class="text-white">{{ app()->getLocale() === 'ar' ? 'قائمة الأمنيات' : 'Wishlist' }}</li>
            </ol>
        </nav>

        <div class="text-center">
            <!-- Page Title -->
            <h1 class="pt-3 text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 drop-shadow-lg">
                {{ app()->getLocale() === 'ar' ? 'قائمة الأمنيات' : 'Wishlist' }}
            </h1>

            <!-- Page Description -->
            <p class="text-base sm:text-lg lg:text-xl mb-6 text-white/90 drop-shadow-md max-w-2xl mx-auto">
                {{ app()->getLocale() === 'ar' ? 'منتجاتك المفضلة' : 'Your favorite products' }}
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($products->count() > 0)
        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }}">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Products' }}
                </h2>
                <span class="bg-brown-light text-brown-primary px-3 py-1 rounded-full text-sm font-medium">
                    {{ $products->count() }} {{ app()->getLocale() === 'ar' ? 'منتج' : 'items' }}
                </span>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @foreach($products as $product)
            @php
                // Get images for hover effect
                $colorImages = $product->colorImages;
                $mainImage = $product->main_image ? asset('storage/' . $product->main_image) : 'https://via.placeholder.com/500x600/FFC0CB/FFFFFF?text=' . urlencode($product->name);
                $hoverImage = $colorImages->count() > 1 ? asset('storage/' . $colorImages[1]->image_path) : $mainImage;
            @endphp
            <div class="product-card overflow-hidden group transition-all duration-500" data-product-id="{{ $product->id }}">
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
                           aria-label="Add to cart: {{ $product->name }}"
                           data-tooltip="Add to cart">
                            <span class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--shopping-bag">
                                <svg width="20" height="20" aria-hidden="true" role="img" focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                </svg>
                            </span>
                        </button>
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="ecomus-quickview-button button product-loop-button flex items-center justify-center em-button-icon em-tooltip em-button-light"
                           data-id="{{ $product->id }}"
                           data-tooltip="Quick View"
                           aria-label="Quick View for {{ $product->name }}"
                           rel="nofollow">
                            <span class="ecomus-svg-icon ecomus-svg-icon__inline ecomus-svg-icon--eye">
                                <svg width="20" height="20" aria-hidden="true" role="img" focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </span>
                        </a>
                        <button onclick="removeFromWishlist({{ $product->id }});"
                           class="button wishlist-button flex items-center justify-center em-button-light em-button-icon em-tooltip"
                           data-product_id="{{ $product->id }}"
                           aria-label="Remove from wishlist: {{ $product->name }}"
                           data-tooltip="Remove from wishlist">
                            <span class="ecomus-svg-icon ecomus-svg-icon__inline">
                                <svg width="20" height="20" aria-hidden="true" role="img" focusable="false" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <h3 class="text-base font-normal text-brown mb-2 line-clamp-2 hover:opacity-80 transition-opacity cursor-pointer">{{ $product->name }}</h3>
                    </a>
                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                        @if($product->sale_price)
                        <span class="text-base font-semibold text-red-500">{{ number_format($product->sale_price, 2) }} DH</span>
                        <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 2) }} DH</span>
                    @else
                        <span class="text-base font-semibold text-brown">{{ number_format($product->price, 2) }} DH</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty Wishlist -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                <i class="far fa-heart text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">
                {{ app()->getLocale() === 'ar' ? 'قائمة الأمنيات فارغة' : 'Your wishlist is empty' }}
            </h3>
            <p class="text-gray-500 mb-6">
                {{ app()->getLocale() === 'ar' ? 'ابدأ بإضافة المنتجات التي تحبها إلى قائمة الأمنيات' : 'Start adding products you love to your wishlist' }}
            </p>
            <a href="{{ route('categories.index') }}" class="btn-brown-gradient py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 inline-block">
                {{ app()->getLocale() === 'ar' ? 'تصفح المنتجات' : 'Browse Products' }}
            </a>
        </div>
        @endif
    </div>
</div>

<style>
.product-card {
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

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

.product-featured-icons {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    z-index: 20;
    pointer-events: none;
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-featured-icons a,
.product-featured-icons button {
    pointer-events: all;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
    color: var(--color-brown-primary);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    border: none;
    cursor: pointer;
    padding: 0;
}

.product-featured-icons a:hover,
.product-featured-icons button:hover {
    background: white;
    transform: scale(1.1) translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    color: var(--color-brown-darker);
}

.product-featured-icons svg {
    width: 20px;
    height: 20px;
    fill: currentColor;
}

@media (max-width: 767px) {
    .product-featured-icons {
        opacity: 1;
        pointer-events: all;
        bottom: 12px;
        gap: 6px;
        transform: translateX(-50%) translateY(0);
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
}

@media (min-width: 768px) {
    .product-card:hover .product-featured-icons {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}
</style>

<script>
// Add to Cart function
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
            showNotification(data.message || '{{ app()->getLocale() === "ar" ? "تمت الإضافة بنجاح" : "Added to cart successfully" }}', 'success');
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
            if (typeof openCartSidebar === 'function') {
                openCartSidebar();
            }
        } else {
            showNotification(data.message || '{{ app()->getLocale() === "ar" ? "حدث خطأ" : "An error occurred" }}', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('{{ app()->getLocale() === "ar" ? "حدث خطأ في الإضافة للسلة" : "Error adding to cart" }}', 'error');
    });
}

// Remove from Wishlist function
function removeFromWishlist(productId) {
    fetch('{{ route("wishlist.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || '{{ app()->getLocale() === "ar" ? "تمت الإزالة بنجاح" : "Removed from wishlist" }}', 'success');
            // Remove product card from DOM
            const productCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
            if (productCard) {
                productCard.style.transition = 'opacity 0.3s, transform 0.3s';
                productCard.style.opacity = '0';
                productCard.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    productCard.remove();
                    // Check if wishlist is empty
                    const remainingProducts = document.querySelectorAll('.product-card');
                    if (remainingProducts.length === 0) {
                        location.reload();
                    }
                }, 300);
            } else {
                // Fallback: reload page
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        } else {
            showNotification(data.message || '{{ app()->getLocale() === "ar" ? "حدث خطأ" : "An error occurred" }}', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('{{ app()->getLocale() === "ar" ? "حدث خطأ" : "An error occurred" }}', 'error');
    });
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

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = `translateX(${isRTL ? '-' : ''}100%)`;
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endsection

