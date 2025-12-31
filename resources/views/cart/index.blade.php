@extends('layouts.app')

@section('title', __('messages.shopping_cart'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('messages.shopping_cart') }}</h1>

        @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    @foreach($cartItems as $item)
                    <div class="p-4 sm:p-6 border-b border-gray-200 last:border-b-0" data-cart-item>
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 {{ app()->getLocale() === 'ar' ? 'sm:space-x-reverse sm:space-x-6' : 'sm:space-x-6' }}">
                            <!-- Product Image -->
                            <div class="flex-shrink-0 mx-auto sm:mx-0">
                                @php
                                    $mainImage = null;
                                    if ($item['color']) {
                                        $mainImage = $item['product']->getMainImageForColor($item['color']->id);
                                    }
                                    if (!$mainImage && $item['product']->main_image) {
                                        $mainImagePath = $item['product']->main_image;
                                    } else {
                                        $mainImagePath = $mainImage ? $mainImage->image_path : null;
                                    }
                                @endphp
                                <img src="{{ $mainImagePath ? asset('storage/' . $mainImagePath) : 'https://via.placeholder.com/150x150/FFC0CB/FFFFFF?text=' . urlencode($item['product']->name) }}"
                                     alt="{{ $item['product']->name }}"
                                     class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">
                                    <a href="{{ route('products.show', $item['product']->slug) }}" class="hover:text-brown">
                                        {{ $item['product']->name }}
                                    </a>
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-600 mb-2">{{ $item['product']->category->name }}</p>

                                @if($item['color'])
                                <p class="text-xs sm:text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('messages.color') }}:</span> {{ $item['color']->name }}
                                </p>
                                @endif

                                @if($item['size'])
                                <p class="text-xs sm:text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('messages.size') }}:</span> {{ $item['size']->name }}
                                </p>
                                @endif
                            </div>

                            <!-- Quantity Controls and Price -->
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 {{ app()->getLocale() === 'ar' ? 'sm:space-x-reverse sm:space-x-4' : 'sm:space-x-4' }}">
                                <div class="flex items-center justify-center border border-gray-300 rounded-lg">
                                    <button onclick="updateQuantity({{ $loop->index }}, {{ $item['quantity'] - 1 }})"
                                            class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-minus text-xs sm:text-sm"></i>
                                    </button>
                                    <span class="px-3 sm:px-4 py-2 min-w-[2rem] sm:min-w-[3rem] text-center text-sm sm:text-base">{{ $item['quantity'] }}</span>
                                    <button onclick="updateQuantity({{ $loop->index }}, {{ $item['quantity'] + 1 }})"
                                            class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-plus text-xs sm:text-sm"></i>
                                    </button>
                                </div>

                                <!-- Price -->
                                <div class="text-center sm:text-right">
                                    <div class="text-base sm:text-lg font-semibold text-brown">
                                        {{ number_format($item['subtotal'], 2) }} DH
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-500">
                                        {{ number_format($item['product']->current_price, 2) }} DH {{ app()->getLocale() === 'ar' ? 'لكل قطعة' : 'each' }}
                                    </div>
                                </div>

                                <!-- Remove Button -->
                                <button onclick="removeItem({{ $loop->index }})"
                                        class="text-red-500 hover:text-red-700 p-2 mx-auto sm:mx-0">
                                    <i class="fas fa-trash text-sm sm:text-base"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Cart Actions -->
                <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ route('products.index') }}"
                       class="flex-1 bg-gray-500 text-white py-2 sm:py-3 px-4 sm:px-6 rounded-lg text-center hover:bg-gray-600 transition duration-300 text-sm sm:text-base">
                        <i class="fas fa-arrow-left {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                        {{ app()->getLocale() === 'ar' ? 'متابعة التسوق' : 'Continue Shopping' }}
                    </a>
                    <button onclick="clearCart()"
                            class="bg-red-500 text-white py-2 sm:py-3 px-4 sm:px-6 rounded-lg hover:bg-red-600 transition duration-300 text-sm sm:text-base">
                        <i class="fas fa-trash {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                        {{ app()->getLocale() === 'ar' ? 'مسح السلة' : 'Clear Cart' }}
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 sticky top-8">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">{{ __('messages.order_summary') }}</h2>

                    <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6">
                        <div class="flex justify-between">
                            <span class="text-sm sm:text-base text-gray-600">{{ __('messages.subtotal') }}</span>
                            <span class="font-semibold text-sm sm:text-base">{{ number_format($total, 2) }} DH</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm sm:text-base text-gray-600">{{ app()->getLocale() === 'ar' ? 'التوصيل' : 'Delivery' }}</span>
                            <span class="font-semibold text-green-600 text-sm sm:text-base">{{ app()->getLocale() === 'ar' ? 'مجاني' : 'Free' }}</span>
                        </div>
                        <div class="border-t pt-3 sm:pt-4">
                            <div class="flex justify-between text-base sm:text-lg font-bold">
                                <span>{{ __('messages.total') }}</span>
                                <span class="text-brown">{{ number_format($total, 2) }} DH</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}"
                       class="w-full btn-brown-gradient py-3 sm:py-4 rounded-lg text-sm sm:text-base lg:text-lg font-semibold text-center transition duration-300 block">
                        <i class="fas fa-credit-card {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                        {{ __('messages.checkout') }}
                    </a>

                    <!-- Estimated Delivery -->
                    <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200">
                        <div class="text-xs sm:text-sm text-gray-700 text-center">
                            <span class="font-semibold" id="estimated-arrival-range-cart">-</span>
                            <span class="ml-1">{{ __('messages.estimated_arrival') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="bg-white rounded-2xl shadow-lg p-12 max-w-md mx-auto">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-6"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-4">
                    {{ app()->getLocale() === 'ar' ? 'سلة التسوق فارغة' : 'Your cart is empty' }}
                </h3>
                <p class="text-gray-500 mb-6">
                    {{ app()->getLocale() === 'ar' ? 'ابدأي التسوق الآن' : 'Start shopping now' }}
                </p>
                <a href="{{ route('products.index') }}"
                   class="bg-brown text-white py-3 px-8 rounded-lg hover:bg-brown-hover transition duration-300">
                    {{ __('messages.products') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(index, newQuantity) {
    if (newQuantity < 1) return;

    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch('{{ route("cart.update") }}', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            cart_key: index.toString(),
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count before reloading
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
            location.reload();
        } else {
            alert('{{ app()->getLocale() === "ar" ? "حدث خطأ في تحديث الكمية" : "Error updating quantity" }}');
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ app()->getLocale() === "ar" ? "حدث خطأ في تحديث الكمية" : "Error updating quantity" }}');
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

function removeItem(index) {
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch('{{ route("cart.remove") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            cart_key: index.toString()
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count before reloading
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
            location.reload();
        } else {
            alert('{{ app()->getLocale() === "ar" ? "حدث خطأ في إزالة المنتج" : "Error removing item" }}');
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ app()->getLocale() === "ar" ? "حدث خطأ في إزالة المنتج" : "Error removing item" }}');
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

function clearCart() {
    if (confirm('{{ app()->getLocale() === "ar" ? "هل أنت متأكدة من مسح السلة بالكامل؟" : "Are you sure you want to clear the entire cart?" }}')) {
        // Show loading state
        const button = event.target;
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "جاري المسح..." : "Clearing..." }}';
        button.disabled = true;

        fetch('{{ route("cart.clear") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ app()->getLocale() === "ar" ? "حدث خطأ في مسح السلة" : "Error clearing cart" }}');
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }
}

// Calculate and display estimated delivery time
function calculateEstimatedDelivery() {
    // Business Days Calculation
    function addBusinessDays(date, days) {
        let result = new Date(date);
        let addedDays = 0;

        while (addedDays < days) {
            result.setDate(result.getDate() + 1);
            // Skip weekends (Saturday = 6, Sunday = 0)
            if (result.getDay() !== 0 && result.getDay() !== 6) {
                addedDays++;
            }
        }

        return result;
    }

    function formatDate(date) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[date.getMonth()] + ' ' + date.getDate();
    }

    const today = new Date();
    const deliveryStartDate = addBusinessDays(today, 7);
    const deliveryEndDate = addBusinessDays(today, 12);

    const estimatedArrivalEl = document.getElementById('estimated-arrival-range-cart');
    if (estimatedArrivalEl) {
        estimatedArrivalEl.textContent = formatDate(deliveryStartDate) + '-' + formatDate(deliveryEndDate) + '.';
    }
}

// Calculate delivery on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateEstimatedDelivery();
});
</script>
@endpush
