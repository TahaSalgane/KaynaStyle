@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Order Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h2>
                <p class="text-gray-600">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                    @if($order->status === 'delivered') bg-green-100 text-green-800
                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-blue-100 text-blue-800 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Billing Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Billing Information') }}</h3>
            <div class="space-y-3">
                @if($order->billing_email)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Email') }}</label>
                    <p class="text-gray-900">{{ $order->billing_email }}</p>
                </div>
                @endif
                @if($order->billing_first_name || $order->billing_last_name)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Name') }}</label>
                    <p class="text-gray-900">{{ ($order->billing_first_name ?? '') . ' ' . ($order->billing_last_name ?? '') }}</p>
                </div>
                @elseif($order->customer_name)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Name') }}</label>
                    <p class="text-gray-900">{{ $order->customer_name }}</p>
                </div>
                @endif
                @if($order->billing_company)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Company') }}</label>
                    <p class="text-gray-900">{{ $order->billing_company }}</p>
                </div>
                @endif
                @if($order->billing_phone)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Phone') }}</label>
                    <p class="text-gray-900">{{ $order->billing_phone }}</p>
                </div>
                @elseif($order->customer_phone)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Phone') }}</label>
                    <p class="text-gray-900">{{ $order->customer_phone }}</p>
                </div>
                @endif
                @if($order->billing_address_1)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Address') }}</label>
                    <p class="text-gray-900">
                        {{ $order->billing_address_1 }}
                        @if($order->billing_address_2)
                        <br>{{ $order->billing_address_2 }}
                        @endif
                    </p>
                </div>
                @elseif($order->customer_address)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Address') }}</label>
                    <p class="text-gray-900">{{ $order->customer_address }}</p>
                </div>
                @endif
                @if($order->billing_city || $order->billing_state || $order->billing_postcode)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('City / State / ZIP') }}</label>
                    <p class="text-gray-900">
                        {{ $order->billing_city ?? '' }}
                        @if($order->billing_state)
                        , {{ $order->billing_state }}
                        @endif
                        @if($order->billing_postcode)
                        {{ $order->billing_postcode }}
                        @endif
                    </p>
                </div>
                @elseif($order->customer_city)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('City') }}</label>
                    <p class="text-gray-900">{{ $order->customer_city }}</p>
                </div>
                @endif
                @if($order->billing_country)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Country') }}</label>
                    <p class="text-gray-900">{{ $order->billing_country }}</p>
                </div>
                @endif
                @if($order->customer_notes)
                <div>
                    <label class="text-sm font-medium text-gray-500">{{ __('Notes') }}</label>
                    <p class="text-gray-900">{{ $order->customer_notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Order Summary') }}</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('Subtotal') }}</span>
                    <span class="font-semibold">${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('Shipping') }}</span>
                    <span class="font-semibold text-green-600">{{ __('Free') }}</span>
                </div>
                <hr>
                <div class="flex justify-between text-lg font-bold">
                    <span>{{ __('Total') }}</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Order Items') }}</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Product') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Color') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Size') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Quantity') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Price') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->product_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->color ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->size ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${{ number_format($item->price, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Update -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Update Order Status') }}</h3>
        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" id="status-update-form">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <select name="status" id="order-status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>{{ __('Confirmed') }}</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                    <button type="submit" class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300">
                        {{ __('Update Status') }}
                    </button>
                </div>

                <!-- Shipping Fields (shown only when "shipped" is selected) -->
                <div id="shipping-fields" class="hidden space-y-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div>
                        <label for="shipping_carrier" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.shipping_carrier') }} <span class="text-red-500">*</span>
                        </label>
                        <select name="shipping_carrier" id="shipping_carrier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                            <option value="">{{ __('messages.select_carrier') }}</option>
                            <option value="DHL" {{ $order->shipping_carrier === 'DHL' ? 'selected' : '' }}>DHL</option>
                            <option value="Express" {{ $order->shipping_carrier === 'Express' ? 'selected' : '' }}>Express</option>
                            <option value="FedEx" {{ $order->shipping_carrier === 'FedEx' ? 'selected' : '' }}>FedEx</option>
                            <option value="Aramex" {{ $order->shipping_carrier === 'Aramex' ? 'selected' : '' }}>Aramex</option>
                        </select>
                    </div>
                    <div>
                        <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.tracking_number') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tracking_number" id="tracking_number" value="{{ $order->tracking_number }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                               placeholder="{{ __('messages.enter_tracking_number') }}">
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('order-status');
            const shippingFields = document.getElementById('shipping-fields');
            const shippingCarrier = document.getElementById('shipping_carrier');
            const trackingNumber = document.getElementById('tracking_number');

            function toggleShippingFields() {
                if (statusSelect.value === 'shipped') {
                    shippingFields.classList.remove('hidden');
                    shippingCarrier.required = true;
                    trackingNumber.required = true;
                } else {
                    shippingFields.classList.add('hidden');
                    shippingCarrier.required = false;
                    trackingNumber.required = false;
                }
            }

            // Check on page load
            toggleShippingFields();

            // Listen for changes
            statusSelect.addEventListener('change', toggleShippingFields);

            // Form validation
            document.getElementById('status-update-form').addEventListener('submit', function(e) {
                if (statusSelect.value === 'shipped') {
                    if (!shippingCarrier.value || !trackingNumber.value.trim()) {
                        e.preventDefault();
                        alert('{{ __("Please select a shipping carrier and enter a tracking number") }}');
                        return false;
                    }
                }
            });
        });
    </script>
    @endpush

    <!-- Actions -->
    <div class="flex justify-end space-x-4 mt-6">
        <a href="{{ route('admin.orders.index') }}"
           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300">
            {{ __('Back to Orders') }}
        </a>
    </div>
</div>
@endsection









