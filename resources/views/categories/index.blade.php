@extends('layouts.app')

@section('title', __('messages.categories'))

@section('content')
    <!-- Hero Section -->
    <section class="relative text-white py-6 sm:py-16 lg:py-10 overflow-hidden"
        style="background: linear-gradient(to left, var(--color-brown-primary), var(--color-brown-darker));">
        <!-- Modern Background Pattern -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
            <div
                class="absolute top-0 right-0 w-48 h-48 sm:w-96 sm:h-96 bg-white/10 rounded-full -translate-y-24 translate-x-24 sm:-translate-y-48 sm:translate-x-48">
            </div>
            <div
                class="absolute bottom-0 left-0 w-40 h-40 sm:w-80 sm:h-80 bg-white/5 rounded-full translate-y-20 -translate-x-20 sm:translate-y-40 sm:-translate-x-40">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol
                    class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} text-sm text-white/80">
                    <li><a href="{{ route('home') }}"
                            class="hover:text-white transition-colors">{{ __('messages.home') }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-white">{{ __('messages.categories') }}</li>
                </ol>
            </nav>

            <div class="text-center">
                <!-- Category Title -->
                <h1 class="pt-3 text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 drop-shadow-lg">
                    {{ __('messages.categories') }}
                </h1>

                <!-- Category Description -->
                <p class="text-base sm:text-lg lg:text-xl mb-6 text-white/90 drop-shadow-md max-w-2xl mx-auto">
                    {{ __('messages.choose_from_collection') }}
                </p>

            </div>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10">
                @foreach ($categories as $category)
                    <div class="group cursor-pointer">
                        <a href="{{ route('categories.show', $category->slug) }}">
                            <div
                                class="category-card bg-white rounded-3xl overflow-hidden group-hover:shadow-2xl transition-all duration-500 border border-gray-100 relative">
                                <!-- Category Image -->
                                <div class="relative h-64 sm:h-72 overflow-hidden">
                                    <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/600x750/FFC0CB/FFFFFF?text=' . urlencode($category->name) }}"
                                        alt="{{ $category->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 aspect-[2/3]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                                    </div>

                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        <div class="bg-white/90 backdrop-blur-sm rounded-full px-3 py-1">
                                            <span class="text-sm font-semibold text-gray-800">
                                                {{ $category->products->count() }} {{ __('messages.products') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Category Info Overlay -->
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <h3
                                            class="text-2xl sm:text-3xl font-bold text-white mb-2 group-hover:text-brown-light transition-colors duration-300">
                                            {{ $category->name }}
                                        </h3>
                                        <p class="text-white/90 text-sm sm:text-base leading-relaxed">
                                            {{ $category->description }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Category Content -->
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }}">
                                            <div
                                                class="w-10 h-10 bg-circle-gradient rounded-full flex items-center justify-center">
                                                <i class="fas fa-tshirt text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 font-medium">
                                                    {{ __('messages.diverse_collection') }}
                                                </p>
                                                <p class="text-xs text-gray-400">
                                                    {{ __('messages.latest_trends') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <span class="inline-flex items-center text-brown font-semibold text-sm">
                                                {{ __('messages.explore_now') }}
                                                <i
                                                    class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <!-- Trust & Social Proof Section with Animated Counters -->
    <section class="py-14 bg-gradient-to-br from-white via-gray-50 to-white relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-30">
            <div
                class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(128,89,60,0.1),transparent_50%)]">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Trust Badges -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.free_shipping') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.free_shipping_text') }}</p>
                </div>
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-transfer text-blue-600 text-2xl"></i>                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.cash_on_delivery') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.cash_on_delivery_text') }}</p>
                </div>
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.good_quality') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.good_quality_text') }}</p>
                </div>
                <div
                    class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.customer_support') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.customer_support_text') }}</p>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('styles')
    <style>
        .category-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--color-brown-light), rgba(147, 51, 234, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .category-card img {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        .gradient-text {
            position: relative;
            background: linear-gradient(135deg, #80593c, #5d4037, #80593c);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease infinite;
        }
    </style>
@endpush
