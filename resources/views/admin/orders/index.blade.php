@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ __('All Orders') }}</h2>
    </div>

    @if($orders->count() > 0)
        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Order #') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Customer') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Total') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $order->order_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($order->status === 'delivered') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="text-blue-600 hover:text-blue-800" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                      class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden">
            @foreach($orders as $order)
            <div class="border-b border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-900">#{{ $order->order_number }}</h3>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        @if($order->status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">{{ __('Customer') }}:</span>
                        <span class="text-sm text-gray-900">{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">{{ __('Phone') }}:</span>
                        <span class="text-sm text-gray-900">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">{{ __('Total') }}:</span>
                        <span class="text-sm font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">{{ __('Date') }}:</span>
                        <span class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="flex space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        <i class="fas fa-eye {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        {{ __('View') }}
                    </a>
                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="flex-1"
                          onsubmit="return confirm('{{ __('Are you sure?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors text-sm">
                            <i class="fas fa-trash {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-8 lg:py-12">
            <i class="fas fa-shopping-cart text-4xl lg:text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-lg lg:text-xl font-semibold text-gray-600 mb-2">{{ __('No Orders') }}</h3>
            <p class="text-sm lg:text-base text-gray-500">{{ __('No orders have been placed yet.') }}</p>
        </div>
    @endif
</div>
@endsection

