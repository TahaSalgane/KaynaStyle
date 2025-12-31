@extends('admin.layouts.app')

@section('title', 'View Product')
@section('page-title', 'Product Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center text-gray-600 hover:text-brown transition-colors duration-300">
                   <i class="fas fa-arrow-left mr-2"></i>
                   {{ __('Back to Products') }}
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.edit', $product) }}"
                   class="inline-flex items-center px-4 py-2 bg-brown text-white text-sm font-medium rounded-lg hover:bg-brown-hover transition duration-300">
                   <i class="fas fa-edit mr-2"></i>
                   {{ __('Edit Product') }}
                </a>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mt-4">{{ $product->name }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ __('View product details and information') }}</p>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- Left Column - Product Images & Descriptions -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Product Images -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Product Images') }}</h2>

                @php
                    $colorImages = $product->colorImages()->with('color')->get()->groupBy('color_id');
                @endphp

                @if($colorImages->count() > 0)
                    @foreach($colorImages as $colorId => $images)
                        <div class="mb-6">
                            <div class="flex items-center mb-3">
                                <div class="w-6 h-6 rounded-full border border-gray-300 mr-3"
                                     style="background-color: {{ $images->first()->color->hex_code }}"></div>
                                <h3 class="text-md font-semibold text-gray-800">{{ $images->first()->color->name }} Images</h3>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($images as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="{{ $product->name }} - {{ $images->first()->color->name }} - Image {{ $index + 1 }}"
                                             class="w-full h-32 sm:h-36 object-cover rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                        @if($image->is_main)
                                            <div class="absolute top-1 left-1">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-brown text-white">
                                                    {{ __('Main') }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="absolute bottom-1 right-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-image text-xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">{{ __('No images available') }}</p>
                    </div>
                @endif
            </div>

            <!-- Description -->
            @if($product->description_en)
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Product Description') }}</h2>
                    <div class="text-gray-900 text-sm whitespace-pre-wrap bg-gray-50 p-3 rounded-lg">{{ $product->description_en }}</div>
                </div>
            @endif
        </div>

        <!-- Right Column - Product Information -->
        <div class="xl:col-span-2 space-y-4">
            <!-- Basic Information & Pricing -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Product Details') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Basic Info -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Product Name') }}</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $product->name_en }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Category') }}</label>
                            <p class="text-sm text-gray-900">{{ $product->category->name }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('SKU') }}</label>
                            <p class="text-sm text-gray-900">{{ $product->sku ?: __('Not set') }}</p>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Price') }}</label>
                            <p class="text-xl font-bold text-brown">${{ number_format($product->price, 2) }}</p>
                        </div>

                        @if($product->sale_price)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Sale Price') }}</label>
                                <p class="text-lg font-bold text-green-600">${{ number_format($product->sale_price, 2) }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Stock') }}</label>
                            <p class="text-sm text-gray-900">{{ $product->stock_quantity }} {{ __('units') }}</p>
                        </div>

                        @if($product->defaultColor)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Default Color') }}</label>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full border border-gray-300"
                                         style="background-color: {{ $product->defaultColor->hex_code }}"></div>
                                    <span class="text-sm text-gray-900">{{ $product->defaultColor->name }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ __('This color\'s main image is used as the product main image') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colors & Sizes -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Colors & Sizes') }}</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-2">{{ __('Available Colors') }}</label>
                        @if(!empty($product->colors))
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->colors as $colorId)
                                    @php
                                        $color = \App\Models\Color::find($colorId);
                                    @endphp
                                    @if($color)
                                        <div class="flex items-center space-x-1 p-1.5 bg-gray-50 rounded-md">
                                            <div class="w-3 h-3 rounded-full border border-gray-300"
                                                 style="background-color: {{ $color->hex_code }}"></div>
                                            <span class="text-xs text-gray-700">{{ $color->name }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-xs">{{ __('No colors selected') }}</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-2">{{ __('Available Sizes') }}</label>
                        @if(!empty($product->sizes))
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->sizes as $sizeId)
                                    @php
                                        $size = \App\Models\Size::find($sizeId);
                                    @endphp
                                    @if($size)
                                        <div class="flex items-center space-x-1 p-1.5 bg-gray-50 rounded-md">
                                            <div class="w-5 h-5 bg-brown-light rounded-full flex items-center justify-center">
                                                <span class="text-xs font-semibold text-brown">{{ $size->name }}</span>
                                            </div>
                                            <span class="text-xs text-gray-700">{{ $size->name }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-xs">{{ __('No sizes selected') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Color Quantities -->
            @php
                $colorQuantities = $product->colorQuantities()->with('color')->get();
            @endphp
            @if($colorQuantities->count() > 0)
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Color Quantities') }}</h2>
                    <div class="space-y-3">
                        @foreach($colorQuantities as $colorQuantity)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-4 h-4 rounded-full border border-gray-300"
                                         style="background-color: {{ $colorQuantity->color->hex_code }}"></div>
                                    <span class="text-sm font-medium text-gray-700">{{ $colorQuantity->color->name }}</span>
                                </div>
                                <span class="text-sm font-bold text-brown">{{ $colorQuantity->quantity }} {{ __('units') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Status & Settings -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Status & Settings') }}</h2>

                <div class="grid grid-cols-2 gap-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">{{ __('Active') }}</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? __('Yes') : __('No') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">{{ __('Featured') }}</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $product->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->is_featured ? __('Yes') : __('No') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">{{ __('Sort Order') }}</span>
                        <span class="text-xs text-gray-900">{{ $product->sort_order }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">{{ __('Created') }}</span>
                        <span class="text-xs text-gray-900">{{ $product->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
