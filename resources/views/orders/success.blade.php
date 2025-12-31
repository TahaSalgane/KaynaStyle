@extends('layouts.app')

@section('title', __('messages.order_success'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-3xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ __('messages.order_success') }}</h1>
            <p class="text-lg text-gray-600 mb-6">{{ __('messages.order_success_message') }}</p>
            <div class="bg-brown-light border border-brown-light rounded-lg p-4 max-w-md mx-auto">
                <p class="text-brown font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'رقم الطلب: ' : 'Order Number: ' }}{{ $order->order_number }}
                </p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="btn-brown-gradient p-6">
                <h2 class="text-2xl font-bold mb-2">{{ app()->getLocale() === 'ar' ? 'تفاصيل الطلب' : 'Order Details' }}</h2>
                <p class="text-brown/80">{{ app()->getLocale() === 'ar' ? 'تم إنشاء الطلب في: ' : 'Order created on: ' }}{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="p-6">
                <!-- Customer Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('messages.customer_info') }}</h3>
                        <div class="space-y-2">
                            <p><span class="font-semibold">{{ __('messages.name') }}:</span> {{ $order->customer_name }}</p>
                            <p><span class="font-semibold">{{ __('messages.phone') }}:</span> {{ $order->customer_phone }}</p>
                            <p><span class="font-semibold">{{ __('messages.address') }}:</span> {{ $order->customer_address }}</p>
                            <p><span class="font-semibold">{{ __('messages.city') }}:</span> {{ $order->customer_city }}</p>
                            @if($order->notes)
                            <p><span class="font-semibold">{{ __('messages.notes') }}:</span> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ app()->getLocale() === 'ar' ? 'معلومات التوصيل' : 'Delivery Information' }}</h3>
                        <div class="space-y-2">
                            <p><span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'الحالة: ' : 'Status: ' }}</span>
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm font-semibold">
                                    {{ app()->getLocale() === 'ar' ? 'في الانتظار' : 'Pending' }}
                                </span>
                            </p>
                            <p><span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'تاريخ التوصيل المتوقع: ' : 'Expected Delivery: ' }}</span>
                                {{ $order->delivery_date->format('M d, Y') }}
                            </p>
                            <p><span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع: ' : 'Payment Method: ' }}</span>
                                {{ app()->getLocale() === 'ar' ? 'الدفع عند التوصيل' : 'Cash on Delivery' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t pt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">{{ app()->getLocale() === 'ar' ? 'المنتجات المطلوبة' : 'Ordered Items' }}</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }} p-4 bg-gray-50 rounded-lg">
                            <img src="https://via.placeholder.com/80x80/FFC0CB/FFFFFF?text={{ urlencode($item->product_name) }}"
                                 alt="{{ $item->product_name }}"
                                 class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $item->product_name }}</h4>
                                @if($item->product_color)
                                <p class="text-sm text-gray-600">{{ __('messages.color') }}: {{ $item->product_color }}</p>
                                @endif
                                @if($item->product_size)
                                <p class="text-sm text-gray-600">{{ __('messages.size') }}: {{ $item->product_size }}</p>
                                @endif
                                <p class="text-sm text-gray-600">{{ __('messages.quantity') }}: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-brown">{{ number_format($item->total, 2) }} DH</p>
                                <p class="text-sm text-gray-500">{{ number_format($item->price, 2) }} DH {{ app()->getLocale() === 'ar' ? 'لكل قطعة' : 'each' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Total -->
                <div class="border-t pt-6 mt-8">
                    <div class="flex justify-between items-center text-2xl font-bold">
                        <span>{{ __('messages.total') }}</span>
                        <span class="text-brown">{{ number_format($order->total_amount, 2) }} DH</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-8 space-y-4">
            <a href="{{ route('products.index') }}"
               class="inline-block bg-brown text-white py-3 px-8 rounded-lg hover:bg-brown-hover transition duration-300">
                <i class="fas fa-shopping-bag {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ app()->getLocale() === 'ar' ? 'متابعة التسوق' : 'Continue Shopping' }}
            </a>
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-500 text-white py-3 px-8 rounded-lg hover:bg-gray-600 transition duration-300 ml-4">
                <i class="fas fa-home {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                {{ __('messages.home') }}
            </a>
        </div>

        <!-- Console Log (as requested) -->
        <script>
            console.log('Order Details:', {
                orderNumber: '{{ $order->order_number }}',
                customerName: '{{ $order->customer_name }}',
                customerPhone: '{{ $order->customer_phone }}',
                customerAddress: '{{ $order->customer_address }}',
                customerCity: '{{ $order->customer_city }}',
                totalAmount: {{ $order->total_amount }},
                items: [
                    @foreach($order->items as $item)
                    {
                        productName: '{{ $item->product_name }}',
                        color: '{{ $item->product_color }}',
                        size: '{{ $item->product_size }}',
                        quantity: {{ $item->quantity }},
                        price: {{ $item->price }},
                        total: {{ $item->total }}
                    }{{ $loop->last ? '' : ',' }}
                    @endforeach
                ]
            });
        </script>
    </div>
</div>
@endsection

