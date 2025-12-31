@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'الدفع' : 'Checkout')

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
                <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">{{ __('messages.products') }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white">{{ app()->getLocale() === 'ar' ? 'الدفع' : 'Checkout' }}</li>
            </ol>
        </nav>

        <div class="text-center">
            <!-- Checkout Title -->
            <h1 class="pt-3 text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 drop-shadow-lg">
                {{ app()->getLocale() === 'ar' ? 'الدفع' : 'Checkout' }}
            </h1>

            <!-- Checkout Description -->
            <p class="text-base sm:text-lg lg:text-xl mb-6 text-white/90 drop-shadow-md max-w-2xl mx-auto">
                {{ app()->getLocale() === 'ar' ? 'أكمل طلبك بسهولة وأمان' : 'Complete your order easily and securely' }}
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Checkout Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    {{ app()->getLocale() === 'ar' ? 'معلومات الطلب' : 'Order Information' }}
                </h2>

                <form id="checkout-form" method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ app()->getLocale() === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}
                        </label>
                        <input type="text" id="full_name" name="full_name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                               placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل اسمك الكامل' : 'Enter your full name' }}">
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ app()->getLocale() === 'ar' ? 'رقم الهاتف *' : 'Phone Number *' }}
                        </label>
                        <input type="tel" id="phone" name="phone" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300"
                               placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل رقم هاتفك' : 'Enter your phone number' }}">
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ app()->getLocale() === 'ar' ? 'المدينة *' : 'City *' }}
                        </label>
                        <select id="city" name="city" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300">
                            <option value="">{{ app()->getLocale() === 'ar' ? 'اختر مدينتك' : 'Select your city' }}</option>
                            @foreach($moroccanCities as $city)
                            <option value="{{ $city['en'] }}">{{ app()->getLocale() === 'ar' ? $city['ar'] : $city['en'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ app()->getLocale() === 'ar' ? 'العنوان *' : 'Address *' }}
                        </label>
                        <textarea id="address" name="address" required rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 resize-none"
                                  placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل عنوانك الكامل' : 'Enter your complete address' }}"></textarea>
                    </div>

                    <!-- Notes (Optional) -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ app()->getLocale() === 'ar' ? 'ملاحظات إضافية (اختياري)' : 'Additional Notes (Optional)' }}
                        </label>
                        <textarea id="notes" name="notes" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 resize-none"
                                  placeholder="{{ app()->getLocale() === 'ar' ? 'أي ملاحظات إضافية...' : 'Any additional notes...' }}"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submit-btn"
                            class="w-full btn-brown-gradient py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-credit-card {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        {{ app()->getLocale() === 'ar' ? 'تأكيد الطلب' : 'Confirm Order' }}
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 sticky top-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    {{ app()->getLocale() === 'ar' ? 'ملخص الطلب' : 'Order Summary' }}
                </h2>

                <!-- Cart Items -->
                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                    @foreach($cartItems as $item)
                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }} pb-4 border-b border-gray-200 last:border-b-0">
                        @php
                            $mainImage = null;
                            if ($item['color']) {
                                $mainImage = $item['product']->getMainImageForColor($item['color']->id);
                            }
                            $mainImagePath = $mainImage ? $mainImage->image_path : ($item['product']->main_image ?? null);
                        @endphp
                        <img src="{{ $mainImagePath ? asset('storage/' . $mainImagePath) : 'https://via.placeholder.com/300x375/FFC0CB/FFFFFF?text=' . urlencode($item['product']->name) }}"
                             alt="{{ $item['product']->name }}"
                             class="w-16 h-16 object-cover rounded-lg aspect-[2/3]">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $item['product']->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $item['product']->category->name }}</p>
                            @if($item['color'])
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">{{ app()->getLocale() === 'ar' ? 'اللون:' : 'Color:' }}</span> {{ $item['color']->name }}
                            </p>
                            @endif
                            @if($item['size'])
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">{{ app()->getLocale() === 'ar' ? 'المقاس:' : 'Size:' }}</span> {{ $item['size']->name }}
                            </p>
                            @endif
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">{{ app()->getLocale() === 'ar' ? 'الكمية:' : 'Quantity:' }}</span> {{ $item['quantity'] }} × {{ number_format($item['product']->current_price, 2) }} DH
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Price Breakdown -->
                <div class="space-y-3 border-t pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'المجموع الفرعي:' : 'Subtotal:' }}</span>
                        <span class="font-semibold">{{ number_format($total, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'التوصيل:' : 'Delivery:' }}</span>
                        <span class="font-semibold text-green-600">{{ app()->getLocale() === 'ar' ? 'مجاني' : 'Free' }}</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between text-lg font-bold">
                            <span>{{ app()->getLocale() === 'ar' ? 'المجموع:' : 'Total:' }}</span>
                            <span class="text-brown">{{ number_format($total, 2) }} DH</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="mt-6 p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} text-green-700">
                        <i class="fas fa-truck text-lg"></i>
                        <span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'توصيل مجاني' : 'Free Delivery' }}</span>
                    </div>
                    <p class="text-sm text-green-600 mt-1">
                        {{ app()->getLocale() === 'ar' ? 'سيتم التواصل معك خلال 24 ساعة لتأكيد الطلب' : 'We will contact you within 24 hours to confirm your order' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-brown-gradient {
        background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));
        color: white;
    }

    .btn-brown-gradient:hover {
        background: linear-gradient(135deg, var(--color-brown-darker), var(--color-brown-primary));
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "جاري المعالجة..." : "Processing..." }}';
        submitBtn.disabled = true;

        // Submit form
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                full_name: form.querySelector('input[name="full_name"]').value,
                phone: form.querySelector('input[name="phone"]').value,
                city: form.querySelector('select[name="city"]').value,
                address: form.querySelector('textarea[name="address"]').value,
                notes: form.querySelector('textarea[name="notes"]') ? form.querySelector('textarea[name="notes"]').value : ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to thank you page
                window.location.href = data.redirect_url;
            } else {
                // Show error message
                alert(data.message || '{{ app()->getLocale() === "ar" ? "حدث خطأ في معالجة الطلب" : "Error processing order" }}');
                submitBtn.innerHTML = '<i class="fas fa-credit-card {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "تأكيد الطلب" : "Confirm Order" }}';
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ app()->getLocale() === "ar" ? "حدث خطأ في معالجة الطلب" : "Error processing order" }}');
            submitBtn.innerHTML = '<i class="fas fa-credit-card {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "تأكيد الطلب" : "Confirm Order" }}';
            submitBtn.disabled = false;
        });
    });
});
</script>
@endpush

