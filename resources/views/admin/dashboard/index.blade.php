@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <div class="p-2 lg:p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-box text-lg lg:text-xl"></i>
            </div>
            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3 lg:mr-4 text-right' : 'ml-3 lg:ml-4' }}">
                <p class="text-xs lg:text-sm font-medium text-gray-600">{{ __('Total Products') }}</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <div class="p-2 lg:p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-th-large text-lg lg:text-xl"></i>
            </div>
            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3 lg:mr-4 text-right' : 'ml-3 lg:ml-4' }}">
                <p class="text-xs lg:text-sm font-medium text-gray-600">{{ __('Total Categories') }}</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900">{{ $totalCategories }}</p>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <div class="p-2 lg:p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-shopping-cart text-lg lg:text-xl"></i>
            </div>
            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3 lg:mr-4 text-right' : 'ml-3 lg:ml-4' }}">
                <p class="text-xs lg:text-sm font-medium text-gray-600">{{ __('Total Orders') }}</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6">
        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
            <div class="p-2 lg:p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-dollar-sign text-lg lg:text-xl"></i>
            </div>
            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3 lg:mr-4 text-right' : 'ml-3 lg:ml-4' }}">
                <p class="text-xs lg:text-sm font-medium text-gray-600">{{ __('Total Revenue') }}</p>
                <p class="text-xl lg:text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 lg:p-6 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">{{ __('Recent Orders') }}</h3>
        </div>
        <div class="p-4 lg:p-6">
            @if($recentOrders->count() > 0)
                <div class="space-y-3 lg:space-y-4">
                    @foreach($recentOrders as $order)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 lg:p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} mb-2 sm:mb-0">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-brown rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-white text-sm lg:text-base"></i>
                            </div>
                            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3 text-right' : 'ml-3' }}">
                                <p class="text-sm lg:text-base font-semibold text-gray-800">#{{ $order->id }}</p>
                                <p class="text-xs lg:text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between sm:block {{ app()->getLocale() === 'ar' ? 'sm:text-left' : 'sm:text-right' }}">
                            <p class="text-sm lg:text-base font-semibold text-gray-800">${{ number_format($order->total_amount, 2) }}</p>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-6 lg:py-8 text-sm lg:text-base">{{ __('No orders found') }}</p>
            @endif
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 lg:p-6 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">{{ __('Top Selling Products') }}</h3>
        </div>
        <div class="p-4 lg:p-6">
            @if($topProducts->count() > 0)
                <div class="space-y-3 lg:space-y-4">
                    @foreach($topProducts as $item)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} mb-2 sm:mb-0">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-500 text-sm lg:text-base"></i>
                            </div>
                            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3 text-right' : 'ml-3' }}">
                                <p class="text-sm lg:text-base font-semibold text-gray-800 truncate">{{ $item->product->name ?? 'Unknown Product' }}</p>
                                <p class="text-xs lg:text-sm text-gray-600">{{ $item->total_sold }} {{ __('sold') }}</p>
                            </div>
                        </div>
                        <div class="{{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }}">
                            <p class="text-sm lg:text-base font-semibold text-gray-800">${{ number_format($item->product->price ?? 0, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-6 lg:py-8 text-sm lg:text-base">{{ __('No sales data available') }}</p>
            @endif
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mt-6 lg:mt-8">
    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 lg:p-6 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">{{ __('Monthly Revenue') }}</h3>
        </div>
        <div class="p-4 lg:p-6">
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Orders by Status Chart -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 lg:p-6 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">{{ __('Orders by Status') }}</h3>
        </div>
        <div class="p-4 lg:p-6">
            <canvas id="statusChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Monthly Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach($monthlyRevenue as $data)
                '{{ date("M", mktime(0, 0, 0, $data->month, 1)) }}',
            @endforeach
        ],
        datasets: [{
            label: '{{ __("Revenue") }}',
            data: [
                @foreach($monthlyRevenue as $data)
                    {{ $data->revenue }},
                @endforeach
            ],
            borderColor: '#8B4513',
            backgroundColor: 'rgba(139, 69, 19, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Orders by Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($ordersByStatus as $status)
                '{{ ucfirst($status->status) }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($ordersByStatus as $status)
                    {{ $status->count }},
                @endforeach
            ],
            backgroundColor: [
                '#10B981',
                '#F59E0B',
                '#EF4444',
                '#8B4513'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush

