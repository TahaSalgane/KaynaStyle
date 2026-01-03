@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 lg:mb-6 gap-4">
    <h2 class="text-lg lg:text-xl font-semibold text-gray-800">{{ __('Manage Products') }}</h2>
    <a href="{{ route('admin.products.create') }}"
       class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300 text-sm lg:text-base text-center">
        <i class="fas fa-plus mr-2"></i>
        {{ __('Add New Product') }}
    </a>
</div>

@if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-40 sm:h-48 object-cover">
                @else
                    <div class="w-full h-40 sm:h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-3xl lg:text-4xl"></i>
                    </div>
                @endif

                <div class="absolute top-2 lg:top-4 right-2 lg:right-4 flex flex-col space-y-1 lg:space-y-2">
                    @if($product->is_active)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ __('Active') }}
                        </span>
                    @else
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ __('Inactive') }}
                        </span>
                    @endif

                    @if($product->is_featured)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ __('Featured') }}
                        </span>
                    @endif

                    @if($product->colorImages && $product->colorImages->count() > 1)
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            <i class="fas fa-images mr-1"></i>
                            {{ $product->colorImages->count() }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-4 lg:p-6">
                <h3 class="text-base lg:text-lg font-semibold text-gray-800 mb-2 truncate">{{ $product->name }}</h3>
                <p class="text-xs lg:text-sm text-gray-600 mb-3 lg:mb-4 truncate">{{ $product->category->name }}</p>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 lg:mb-4 gap-2">
                    <div class="flex items-center space-x-2">
                        @if($product->sale_price)
                            <span class="text-base lg:text-lg font-bold text-brown">${{ $product->sale_price }}</span>
                            <span class="text-xs lg:text-sm text-gray-500 line-through">${{ $product->price }}</span>
                        @else
                            <span class="text-base lg:text-lg font-bold text-brown">${{ $product->price }}</span>
                        @endif
                    </div>
                    <span class="text-xs lg:text-sm text-gray-500">{{ $product->stock_quantity }} {{ __('in stock') }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex space-x-1 lg:space-x-2">
                        <a href="{{ route('admin.products.show', $product) }}"
                           class="text-blue-600 hover:text-blue-800 p-1 lg:p-2" title="{{ __('View') }}">
                            <i class="fas fa-eye text-sm lg:text-base"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="text-green-600 hover:text-green-800 p-1 lg:p-2" title="{{ __('Edit') }}">
                            <i class="fas fa-edit text-sm lg:text-base"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.toggle-active', $product) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 p-1 lg:p-2" title="{{ __('Toggle Active') }}">
                                <i class="fas fa-toggle-{{ $product->is_active ? 'on' : 'off' }} text-sm lg:text-base"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.products.toggle-featured', $product) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-purple-600 hover:text-purple-800 p-1 lg:p-2" title="{{ __('Toggle Featured') }}">
                                <i class="fas fa-star text-sm lg:text-base"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                              class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 p-1 lg:p-2" title="{{ __('Delete') }}">
                                <i class="fas fa-trash text-sm lg:text-base"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6 lg:mt-8">
        {{ $products->links() }}
    </div>
@else
    <div class="text-center py-8 lg:py-12">
        <i class="fas fa-box text-4xl lg:text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-lg lg:text-xl font-semibold text-gray-600 mb-2">{{ __('No Products') }}</h3>
        <p class="text-sm lg:text-base text-gray-500 mb-4 lg:mb-6">{{ __('Get started by adding your first product.') }}</p>
        <a href="{{ route('admin.products.create') }}"
           class="bg-brown text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg hover:bg-brown-darker transition duration-300 text-sm lg:text-base">
            <i class="fas fa-plus mr-2"></i>
            {{ __('Add First Product') }}
        </a>
    </div>
@endif
@endsection

