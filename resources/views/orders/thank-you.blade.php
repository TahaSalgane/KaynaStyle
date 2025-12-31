@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'شكراً لك' : 'Thank You')

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
        <div class="text-center">
            <!-- Thank You Title -->
            <h1 class="pt-3 text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 drop-shadow-lg">
                {{ app()->getLocale() === 'ar' ? 'شكراً لك!' : 'Thank You!' }}
            </h1>

            <!-- Thank You Description -->
            <p class="text-base sm:text-lg lg:text-xl mb-6 text-white/90 drop-shadow-md max-w-2xl mx-auto">
                {{ app()->getLocale() === 'ar' ? 'تم استلام طلبك بنجاح وسنتواصل معك قريباً' : 'Your order has been received successfully and we will contact you soon' }}
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 mb-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <i class="fas fa-check text-4xl text-green-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    {{ app()->getLocale() === 'ar' ? 'تم تأكيد طلبك!' : 'Your Order is Confirmed!' }}
                </h2>
                <p class="text-gray-600 mb-4">
                    {{ app()->getLocale() === 'ar' ? 'شكراً لك على ثقتك بنا. سنتواصل معك عبر الهاتف خلال 24 ساعة لتأكيد طلبك.' : 'Thank you for your trust. We will call you within 24 hours to confirm your order.' }}
                </p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-blue-800 text-sm">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ app()->getLocale() === 'ar' ? 'سيتم إرسال طلبك إليك خلال 24 ساعة بعد التأكيد.' : 'Your order will be sent to you within 24 hours after confirmation.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                {{ app()->getLocale() === 'ar' ? 'تفاصيل الطلب' : 'Order Details' }}
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order Information -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-3 mb-3">
                    {{ app()->getLocale() === 'ar' ? 'معلومات الطلب' : 'Order Information' }}
                    </h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'رقم الطلب:' : 'Order Number:' }}</span>
                            <span class="font-semibold text-brown">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'التاريخ:' : 'Date:' }}</span>
                            <span class="font-semibold">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'الحالة:' : 'Status:' }}</span>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                {{ app()->getLocale() === 'ar' ? 'قيد المراجعة' : 'Pending Review' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'المجموع:' : 'Total:' }}</span>
                            <span class="font-bold text-brown text-lg">{{ number_format($order->total_amount, 2) }} DH</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-3">
                        {{ app()->getLocale() === 'ar' ? 'معلومات العميل' : 'Customer Information' }}
                    </h4>
                    <div class="space-y-2">
                        <div>
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'الاسم:' : 'Name:' }}</span>
                            <span class="font-semibold block">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'الهاتف:' : 'Phone:' }}</span>
                            <span class="font-semibold block">{{ $order->customer_phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'المدينة:' : 'City:' }}</span>
                            <span class="font-semibold block">{{ $order->customer_city }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'العنوان:' : 'Address:' }}</span>
                            <span class="font-semibold block">{{ $order->customer_address }}</span>
                        </div>
                        @if($order->customer_notes)
                        <div>
                            <span class="text-gray-600">{{ app()->getLocale() === 'ar' ? 'ملاحظات:' : 'Notes:' }}</span>
                            <span class="font-semibold block">{{ $order->customer_notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">
                {{ app()->getLocale() === 'ar' ? 'المنتجات المطلوبة' : 'Ordered Items' }}
            </h3>

            @foreach($order->items as $item)
            <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }} p-4 border border-gray-200 rounded-lg">
                <img src="{{ $item->product->main_image ? asset('storage/' . $item->product->main_image) : 'https://via.placeholder.com/300x375/FFC0CB/FFFFFF?text=' . urlencode($item->product_name) }}"
                     alt="{{ $item->product_name }}"
                     class="w-16 h-16 object-cover rounded-lg aspect-[2/3]">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">{{ $item->product_name }}</h4>
                    <p class="text-sm text-gray-600">{{ $item->product_sku }}</p>
                    @if($item->color)
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">{{ app()->getLocale() === 'ar' ? 'اللون:' : 'Color:' }}</span> {{ $item->color }}
                    </p>
                    @endif
                    @if($item->size)
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">{{ app()->getLocale() === 'ar' ? 'المقاس:' : 'Size:' }}</span> {{ $item->size }}
                    </p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-800">{{ number_format($item->unit_price, 2) }} DH</p>
                    <p class="text-sm text-gray-600">{{ app()->getLocale() === 'ar' ? 'الكمية:' : 'Qty:' }} {{ $item->quantity }}</p>
                    <p class="font-bold text-brown">{{ number_format($item->total_price, 2) }} DH</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 rounded-2xl p-6 lg:p-8 mb-8">
            <h3 class="text-xl font-bold text-blue-800 mb-4">
                {{ app()->getLocale() === 'ar' ? 'الخطوات التالية' : 'Next Steps' }}
            </h3>
            <div class="space-y-3">
                <div class="flex items-start {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-phone text-white text-xs"></i>
                    </div>
                    <p class="text-blue-700">
                        {{ app()->getLocale() === 'ar' ? 'سنقوم بالاتصال بك خلال 24 ساعة لتأكيد الطلب' : 'We will call you within 24 hours to confirm your order' }}
                    </p>
                </div>
                <div class="flex items-start {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-truck text-white text-xs"></i>
                    </div>
                    <p class="text-blue-700">
                        {{ app()->getLocale() === 'ar' ? 'سيتم إرسال طلبك إليك خلال 24 ساعة' : 'Your order will be sent to you within 24 hours' }}
                    </p>
                </div>
                <div class="flex items-start {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-gift text-white text-xs"></i>
                    </div>
                    <p class="text-blue-700">
                        {{ app()->getLocale() === 'ar' ? 'التوصيل مجاني لجميع الطلبات' : 'Free delivery for all orders' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products.index') }}"
               class="btn-brown-gradient py-3 px-8 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                <i class="fas fa-shopping-bag {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ app()->getLocale() === 'ar' ? 'متابعة التسوق' : 'Continue Shopping' }}
            </a>
            <a href="{{ route('home') }}"
               class="bg-gray-500 text-white py-3 px-8 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                <i class="fas fa-home {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ app()->getLocale() === 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
            </a>
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

