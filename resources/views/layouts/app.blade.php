<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.welcome'))</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Brown Color Palette */
            --color-brown-primary: #80593c;
            --color-brown-dark: #6b4a2f;
            --color-brown-darker: #5d4037;
            --color-brown-darkest: #4a2c20;
            --color-brown-light: rgba(128, 89, 60, 0.1);
            --color-brown-medium: rgba(128, 89, 60, 0.2);
            --color-brown-lighter: rgba(128, 89, 60, 0.05);

            /* Hover states */
            --color-brown-hover: #6b4a2f;
            --color-brown-hover-light: rgba(107, 74, 47, 0.1);

            /* Text colors */
            --color-text-brown: #80593c;
            --color-text-brown-light: rgba(128, 89, 60, 0.7);
            --color-text-brown-lighter: rgba(128, 89, 60, 0.5);
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Live Sale Notification Animation */
        @keyframes slide-in-left {
            from {
                transform: translateX(-120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-left {
            animation: slide-in-left 0.5s ease-out;
        }
        .rtl {
            direction: rtl;
        }
        .ltr {
            direction: ltr;
        }

        /* RTL Support */
        [dir="rtl"] {
            text-align: right;
        }
        [dir="rtl"] .text-left {
            text-align: right;
        }
        [dir="rtl"] .text-right {
            text-align: left;
        }
        [dir="rtl"] .ml-auto {
            margin-left: 0;
            margin-right: auto;
        }
        [dir="rtl"] .mr-auto {
            margin-right: 0;
            margin-left: auto;
        }
        [dir="rtl"] .space-x-reverse > * + * {
            margin-left: 0;
            margin-right: 0.5rem;
        }

        /* Utility classes for consistent color usage */
        .text-brown { color: var(--color-text-brown); }
        .text-brown-light { color: var(--color-text-brown-light); }
        .text-brown-lighter { color: var(--color-text-brown-lighter); }

        .bg-brown { background-color: var(--color-brown-primary); }
        .bg-brown-dark { background-color: var(--color-brown-dark); }
        .bg-brown-light { background-color: var(--color-brown-light); }
        .bg-brown-medium { background-color: var(--color-brown-medium); }
        .bg-brown-lighter { background-color: var(--color-brown-lighter); }

        .border-brown { border-color: var(--color-brown-primary); }
        .border-brown-light { border-color: var(--color-brown-light); }

        .ring-brown { --tw-ring-color: var(--color-brown-primary); }

        .hover\:text-brown:hover { color: var(--color-text-brown); }
        .hover\:bg-brown:hover { background-color: var(--color-brown-primary); }
        .hover\:bg-brown-hover:hover { background-color: var(--color-brown-hover); }
        .hover\:bg-brown-light:hover { background-color: var(--color-brown-hover-light); }
        .hover\:border-brown:hover { border-color: var(--color-brown-primary); }

        .focus\:ring-brown:focus { --tw-ring-color: var(--color-brown-primary); }

        /* Gradient utilities */
        .bg-gradient-brown {
            background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));
        }
        .bg-gradient-brown-hover:hover {
            background: linear-gradient(135deg, var(--color-brown-hover), var(--color-brown-darkest));
        }

        /* Button gradient classes */
        .btn-brown-gradient {
            background: linear-gradient(to right, var(--color-brown-primary), var(--color-brown-darker));
            color: white;
        }
        .btn-brown-gradient:hover {
            background: linear-gradient(to right, var(--color-brown-hover), var(--color-brown-darkest));
        }

        /* Background pattern utilities */
        .bg-pattern-grain {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        /* Hero section gradients */
        .bg-hero-gradient {
            background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker), #4f46e5);
        }

        /* Small gradient circles */
        .bg-circle-gradient {
            background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));
        }

        /* Cart Sidebar Animations */
        #cart-sidebar {
            will-change: transform;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #cart-sidebar-overlay {
            will-change: opacity;
            transition: opacity 0.3s ease-in-out;
        }

        /* Smooth scroll for cart items */
        #cart-sidebar-items {
            scrollbar-width: thin;
            scrollbar-color: var(--color-brown-primary) transparent;
        }

        #cart-sidebar-items::-webkit-scrollbar {
            width: 6px;
        }

        #cart-sidebar-items::-webkit-scrollbar-track {
            background: transparent;
        }

        #cart-sidebar-items::-webkit-scrollbar-thumb {
            background-color: var(--color-brown-primary);
            border-radius: 3px;
        }

        #cart-sidebar-items::-webkit-scrollbar-thumb:hover {
            background-color: var(--color-brown-darker);
        }

        /* Payment Method Badges */
        .payment-method-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 4px;
            padding: 4px 6px;
            height: 24px;
            transition: transform 0.2s ease;
        }

        .payment-method-badge:hover {
            transform: scale(1.1);
        }

        .payment-method-badge .icon {
            display: block;
            width: 38px;
            height: 24px;
        }

        /* Countdown Timer Styles */
        .countdown-banner {
            position: relative;
            overflow: hidden;
            z-index: 60;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .countdown-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }

        .countdown-display {
            font-family: 'Courier New', monospace;
        }

        .countdown-item {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            min-width: 35px;
        }

        .countdown-value {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.2;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            min-width: 30px;
            text-align: center;
        }

        .countdown-label {
            font-size: 0.65rem;
            margin-top: 2px;
            opacity: 0.9;
        }

        .countdown-separator {
            font-size: 1.2rem;
            font-weight: 700;
            opacity: 0.8;
        }

        @media (min-width: 640px) {
            .countdown-value {
                font-size: 1.25rem;
                min-width: 40px;
                padding: 4px 8px;
            }
            .countdown-label {
                font-size: 0.7rem;
            }
        }

        /* Countdown Message Badge Styling */
        .countdown-message-badge {
            color: red;
            display: inline-block;
            background: white;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            animation: messagePulse 2s ease-in-out infinite;
            white-space: nowrap;
        }

        @keyframes messagePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.4);
            }
        }

        .countdown-title {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 640px) {
            .countdown-message-badge {
                font-size: 0.75rem;
                padding: 5px 12px;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    @if(isset($activeCountdown) && $activeCountdown)
    <!-- Countdown Timer Banner -->
    <div id="countdown-banner" class="countdown-banner" style="background: linear-gradient(135deg, {{ $activeCountdown->background_color }}, {{ $activeCountdown->background_color }}dd); color: {{ $activeCountdown->text_color }};">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 sm:py-3">
            <div class="flex items-center justify-center flex-wrap gap-3 sm:gap-4 text-center">
                @if($activeCountdown->title)
                <span class="font-bold text-sm sm:text-base animate-pulse countdown-title">
                    <i class="fas fa-fire {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>{{ $activeCountdown->title }}
                </span>
                @endif
                @if($activeCountdown->message)
                <span class="countdown-message-badge">
                    {{ $activeCountdown->message }}
                </span>
                @endif
                <div class="flex items-center gap-2 sm:gap-3">
                    <span class="text-xs sm:text-sm font-semibold">{{ __('messages.ends_in') }}:</span>
                    <div class="flex items-center gap-1 sm:gap-2 countdown-display">
                        <span class="countdown-item">
                            <span class="countdown-value" id="countdown-days">00</span>
                            <span class="countdown-label text-xs">{{ __('messages.days') }}</span>
                        </span>
                        <span class="countdown-separator mx-1">:</span>
                        <span class="countdown-item">
                            <span class="countdown-value" id="countdown-hours">00</span>
                            <span class="countdown-label text-xs">{{ __('messages.hours') }}</span>
                        </span>
                        <span class="countdown-separator mx-1">:</span>
                        <span class="countdown-item">
                            <span class="countdown-value" id="countdown-minutes">00</span>
                            <span class="countdown-label text-xs">{{ __('messages.minutes') }}</span>
                        </span>
                        <span class="countdown-separator mx-1">:</span>
                        <span class="countdown-item">
                            <span class="countdown-value" id="countdown-seconds">00</span>
                            <span class="countdown-label text-xs">{{ __('messages.seconds') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <span class="countdown-end-date hidden" data-end-date="{{ $activeCountdown->end_date->toIso8601String() }}"></span>
    </div>
    @endif

    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-xl sticky top-0 z-50 border-b border-brown/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-18">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="group flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} hover:opacity-80 transition-opacity duration-300">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="{{ __('messages.business_name') }}"
                             class="h-20 sm:h-24 md:h-28 lg:h-32 w-auto object-contain group-hover:scale-105 transition-transform duration-300"
                             onerror="this.onerror=null; this.src='{{ asset('images/logo.jpg') }}';">
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:block">
                    <div class="{{ app()->getLocale() === 'ar' ? 'mr-10' : 'ml-10' }} flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-1' : 'space-x-1' }}">
                        <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-brown hover:bg-brown/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            <i class="fas fa-home {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.home') }}
                        </a>
                        <a href="{{ route('products.index') }}" class="nav-link text-gray-700 hover:text-brown hover:bg-brown/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            <i class="fas fa-shopping-bag {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.products') }}
                        </a>
                        <a href="{{ route('categories.index') }}" class="nav-link text-gray-700 hover:text-brown hover:bg-brown/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            <i class="fas fa-th-large {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.categories') }}
                        </a>
                        <a href="{{ route('faq.index') }}" class="nav-link text-gray-700 hover:text-brown hover:bg-brown/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            <i class="fas fa-question-circle {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.faq') }}
                        </a>
                        <a href="{{ route('contact.index') }}" class="nav-link text-gray-700 hover:text-brown hover:bg-brown/5 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                            <i class="fas fa-envelope {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>{{ __('messages.contact_us') }}
                        </a>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3 sm:space-x-reverse sm:space-x-4' : 'space-x-3 sm:space-x-4' }}">
                    <!-- Language Switcher -->
                    <div class="relative group">
                        <button onclick="toggleLanguageMenu()" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }} bg-white border border-gray-200 hover:border-brown rounded-lg px-3 py-2 text-sm font-medium transition-all duration-300 hover:shadow-md">
                            <span id="current-flag" class="w-6 h-4 rounded-sm overflow-hidden">
                                @if(app()->getLocale() === 'ar')
                                    <img src="https://flagcdn.com/w20/ma.png" alt="Morocco Flag" class="w-full h-full object-cover">
                                @elseif(app()->getLocale() === 'en')
                                    <img src="https://flagcdn.com/w20/gb.png" alt="UK Flag" class="w-full h-full object-cover">
                                @elseif(app()->getLocale() === 'fr')
                                    <img src="https://flagcdn.com/w20/fr.png" alt="French Flag" class="w-full h-full object-cover">
                                @else
                                    <img src="https://flagcdn.com/w20/es.png" alt="Spanish Flag" class="w-full h-full object-cover">
                                @endif
                            </span>
                            <span id="current-lang" class="text-gray-700">
                                @if(app()->getLocale() === 'ar')
                                    عربي
                                @elseif(app()->getLocale() === 'en')
                                    EN
                                @elseif(app()->getLocale() === 'fr')
                                    FR
                                @else
                                    ES
                                @endif
                            </span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>

                        <!-- Language Dropdown -->
                        <div id="language-menu" class="hidden absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-28 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            @if(app()->getLocale() !== 'ar')
                            <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} px-4 py-2 text-sm text-gray-700 hover:bg-brown/5 hover:text-brown transition-colors duration-200">
                                <img src="https://flagcdn.com/w20/ma.png" alt="Morocco Flag" class="w-5 h-3 rounded-sm object-cover">
                                <span>عربي</span>
                            </a>
                            @endif
                            @if(app()->getLocale() !== 'en')
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} px-4 py-2 text-sm text-gray-700 hover:bg-brown/5 hover:text-brown transition-colors duration-200">
                                <img src="https://flagcdn.com/w20/gb.png" alt="UK Flag" class="w-5 h-3 rounded-sm object-cover">
                                <span>EN</span>
                            </a>
                            @endif
                            @if(app()->getLocale() !== 'fr')
                            <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} px-4 py-2 text-sm text-gray-700 hover:bg-brown/5 hover:text-brown transition-colors duration-200">
                                <img src="https://flagcdn.com/w20/fr.png" alt="French Flag" class="w-5 h-3 rounded-sm object-cover">
                                <span>FR</span>
                            </a>
                            @endif
                            @if(app()->getLocale() !== 'es')
                            <a href="{{ route('lang.switch', 'es') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} px-4 py-2 text-sm text-gray-700 hover:bg-brown/5 hover:text-brown transition-colors duration-200">
                                <img src="https://flagcdn.com/w20/es.png" alt="Spanish Flag" class="w-5 h-3 rounded-sm object-cover">
                                <span>ES</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Cart -->
                    <button onclick="openCartSidebar()" type="button" class="relative group">
                        <div class="p-2 rounded-lg hover:bg-brown/5 transition-all duration-300 group-hover:scale-110 relative">
                            <i class="fas fa-shopping-cart text-lg sm:text-xl text-gray-700 group-hover:text-brown transition-colors duration-300"></i>
                            <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-[10px] sm:text-xs rounded-full min-w-[18px] sm:min-w-[20px] h-[18px] sm:h-[20px] flex items-center justify-center font-bold shadow-lg border-2 border-white">
                                0
                            </span>
                        </div>
                    </button>

                    <!-- Mobile menu button -->
                    <div class="lg:hidden">
                        <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-gray-700 hover:text-brown hover:bg-brown/5 focus:outline-none focus:text-brown transition-all duration-300">
                            <i class="fas fa-bars text-lg sm:text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="px-4 pt-2 pb-4 space-y-1 bg-white/95 backdrop-blur-md border-t border-brown/10">
                <a href="{{ route('home') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} text-gray-700 hover:text-brown hover:bg-brown/5 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-300">
                    <i class="fas fa-home w-5"></i>
                    <span>{{ __('messages.home') }}</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} text-gray-700 hover:text-brown hover:bg-brown/5 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-300">
                    <i class="fas fa-shopping-bag w-5"></i>
                    <span>{{ __('messages.products') }}</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} text-gray-700 hover:text-brown hover:bg-brown/5 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-300">
                    <i class="fas fa-th-large w-5"></i>
                    <span>{{ __('messages.categories') }}</span>
                </a>
                <a href="{{ route('faq.index') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} text-gray-700 hover:text-brown hover:bg-brown/5 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-300">
                    <i class="fas fa-question-circle w-5"></i>
                    <span>{{ __('messages.faq') }}</span>
                </a>
                <a href="{{ route('contact.index') }}" class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3' : 'space-x-3' }} text-gray-700 hover:text-brown hover:bg-brown/5 block px-4 py-3 rounded-lg text-base font-medium transition-all duration-300">
                    <i class="fas fa-envelope w-5"></i>
                    <span>{{ __('messages.contact_us') }}</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Newsletter Modal -->
    <div id="newsletterModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full transform transition-all duration-300 scale-95 opacity-0 overflow-hidden" id="newsletterModalContent">
            <!-- Close Button -->
            <button onclick="closeNewsletterModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors duration-200 z-10 bg-white/80 rounded-full p-2 hover:bg-white">
                <i class="fas fa-times text-xl"></i>
            </button>

            <!-- Modal Content - Two Column Layout -->
            <div class="flex flex-col md:flex-row">
                <!-- Left Side - Image -->
                <div class="hidden md:block md:w-3/5 bg-gradient-to-br from-brown to-brown-darker flex items-center justify-center">
                    <img src="{{ asset('images/newsletter-modal.webp') }}"
                         alt="Newsletter"
                         class="w-full h-full object-cover rounded-lg"
                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="hidden flex-col items-center justify-center text-white">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-envelope-open text-white text-5xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Content -->
                <div class="w-full md:w-3/6 p-6 sm:p-8 bg-white">
                    <!-- Icon/Title for Mobile -->
                    <div class="text-center md:text-left mb-6">
                        <div class="inline-flex md:hidden items-center justify-center w-16 h-16 rounded-full mb-4 shadow-lg" style="background: linear-gradient(135deg, #80593c, #5d4037);">
                            <i class="fas fa-envelope-open text-white text-2xl"></i>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">
                            {{ __('messages.stay_updated') }}
                        </h2>
                        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                            {{ __('messages.newsletter_modal_text') }}
                        </p>
                    </div>

                    <!-- Newsletter Form -->
                    <form id="newsletterModalForm" class="space-y-4">
                        <div>
                            <input type="email"
                                   id="newsletterModalEmail"
                                   name="email"
                                   placeholder="{{ __('messages.your_email_address') }}"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-brown focus:border-brown text-gray-900 text-base transition-all duration-200 bg-white placeholder-gray-400">
                        </div>
                        <button type="submit"
                                class="w-full px-6 py-3 rounded-lg font-semibold text-base transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center text-white"
                                style="background: linear-gradient(to right, #80593c, #5d4037);">
                            <i class="fas fa-paper-plane {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                            <span>{{ __('messages.subscribe') }}</span>
                        </button>
                    </form>

                    <!-- Privacy Text -->
                    <p class="text-gray-600 text-xs text-center mt-4">
                        {{ __('messages.newsletter_privacy') }}
                    </p>

                    <!-- Don't show again option -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label class="flex items-center justify-center cursor-pointer">
                            <input type="checkbox" id="dontShowAgain" class="{{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} w-4 h-4 text-brown focus:ring-brown border-gray-300 rounded">
                            <span class="text-gray-700 text-sm">{{ __('messages.dont_show_again') }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Sale Notification -->
    <div id="liveSaleNotification" class="fixed bottom-4 left-4 md:bottom-6 md:left-6 z-50 hidden transform transition-all duration-500 ease-out" style="transform: translateX(-120%); opacity: 0;">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-4 md:p-5 max-w-sm md:max-w-sm w-full flex items-center gap-4 md:gap-4 relative" style="box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);">
            <!-- Close Button -->
            <button onclick="closeLiveSaleNotification()" class="absolute top-2.5 right-2.5 md:top-3 md:right-3 text-gray-400 hover:text-gray-600 transition-colors z-10 bg-white/80 rounded-full p-1.5 md:p-1.5">
                <i class="fas fa-times text-sm md:text-sm"></i>
            </button>

            <!-- Product Image -->
            <div class="flex-shrink-0">
                <img id="notificationProductImage" src="" alt="Product" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28 rounded-lg object-cover border border-gray-200 shadow-md">
            </div>

            <!-- Notification Content -->
            <div class="flex-1 min-w-0 pr-7 md:pr-8">
                <p class="text-sm md:text-sm font-medium text-gray-600 mb-1.5 md:mb-1.5" id="notificationText" style="color: #80593c;">
                    {{ __('messages.someone_purchased') }}
                </p>
                <p class="text-base md:text-base lg:text-lg font-bold text-gray-900 mb-1.5 md:mb-1.5 line-clamp-2 leading-tight" id="notificationProductName" style="color: #1f2937;">
                    Product Name
                </p>
                <p class="text-sm md:text-sm text-gray-500" id="notificationTime" style="color: #80593c;">
                    46 minutes ago
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Cart Sidebar -->
    <div id="cart-sidebar-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300" onclick="closeCartSidebar()"></div>
    <div id="cart-sidebar" class="fixed top-0 bottom-0 w-3/4 sm:w-full max-w-md bg-white shadow-2xl z-[60] transform transition-transform duration-300 ease-in-out overflow-hidden right-0 translate-x-full">
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-brown/20" style="background: linear-gradient(135deg, var(--color-brown-primary), var(--color-brown-darker));">
                <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                    <i class="fas fa-shopping-cart text-white"></i>
                    <span class="text-white">{{ __('messages.shopping_cart') }}</span>
                    <span id="cart-sidebar-count" class="text-sm bg-white/30 text-white px-2 py-1 rounded-full font-semibold">(0)</span>
                </h2>
                <button onclick="closeCartSidebar()" class="text-white hover:text-white/80 transition-colors duration-200 p-2 rounded-lg hover:bg-white/20">
                    <i class="fas fa-times text-xl text-white"></i>
                </button>
            </div>

            <!-- Cart Items Container -->
            <div id="cart-sidebar-items" class="flex-1 overflow-y-auto p-4 sm:p-6">
                <!-- Loading state -->
                <div id="cart-sidebar-loading" class="flex items-center justify-center py-12">
                    <i class="fas fa-spinner fa-spin text-brown text-3xl"></i>
                </div>

                <!-- Empty cart -->
                <div id="cart-sidebar-empty" class="hidden text-center py-12">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg mb-4">{{ __('messages.your_cart_empty') }}</p>
                    <button onclick="closeCartSidebar()" class="btn-brown-gradient px-6 py-2 rounded-lg text-white">
                        {{ __('messages.shop_now') }}
                    </button>
                </div>

                <!-- Cart items will be inserted here -->
                <div id="cart-sidebar-items-list" class="hidden space-y-4"></div>
            </div>

            <!-- Footer with Total and Checkout -->
            <div id="cart-sidebar-footer" class="hidden border-t border-gray-200 bg-gray-50 p-4 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-800">{{ __('messages.total') }}</span>
                    <span id="cart-sidebar-total" class="text-2xl font-bold text-brown">0.00 DH</span>
                </div>
                <a href="{{ route('checkout') }}" class="block w-full btn-brown-gradient text-center py-3 rounded-lg font-semibold text-white transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-credit-card {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        {{ __('messages.checkout') }}
                </a>
                <a href="{{ route('cart.index') }}" class="block w-full text-center py-2 mt-2 text-brown hover:text-brown-darker transition-colors duration-200 text-sm font-medium">
                    {{ __('messages.shopping_cart') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white py-6" style="background: linear-gradient(to right, var(--color-brown-primary), var(--color-brown-darker));">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- KaynaStyle Section -->
                <div>
                    <div class="mb-3 sm:mb-4">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="{{ __('messages.business_name') }}"
                             class="h-20 sm:h-24 md:h-28 w-auto object-contain"
                             onerror="this.onerror=null; this.src='{{ asset('images/logo.jpg') }}';">
                    </div>
                    <p class="text-gray-300 text-sm sm:text-base mb-2">
                        {{ __('messages.business_name_full') }}
                    </p>
                    <p class="text-gray-300 text-sm sm:text-base mb-4">
                        <strong>{{ __('messages.email') }}:</strong> contact@kaynastyle.com<br>
                        <strong>{{ __('messages.phone') }}:</strong> +1 917 695 2890
                    </p>
                    <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4' }}">
                        <a href="https://www.instagram.com/kaynastyle" target="_blank" rel="noopener noreferrer"
                           class="text-gray-300 hover:text-pink-400 transition-colors duration-300 transform hover:scale-110"
                           aria-label="Instagram">
                            <i class="fab fa-instagram text-3xl"></i>
                        </a>
                        <a href="https://www.facebook.com/kaynastyle" target="_blank" rel="noopener noreferrer"
                           class="text-gray-300 hover:text-blue-400 transition-colors duration-300 transform hover:scale-110"
                           aria-label="Facebook">
                            <i class="fab fa-facebook text-3xl"></i>
                        </a>
                        <a href="https://wa.me/19176952890" target="_blank" rel="noopener noreferrer"
                           class="text-gray-300 hover:text-green-400 transition-colors duration-300 transform hover:scale-110"
                           aria-label="WhatsApp">
                            <i class="fab fa-whatsapp text-3xl"></i>
                        </a>
                </div>
                </div>

                <!-- Categories Section -->
                <div>
                    <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">{{ __('messages.categories') }}</h3>
                    <ul class="space-y-1 sm:space-y-2">
                        @foreach($footerCategories ?? [] as $category)
                            <li><a href="{{ route('categories.show', $category->slug) }}" class="text-gray-300 hover:text-white text-sm sm:text-base transition-colors">{{ $category->name_en }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Help Section -->
                <div>
                    <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">{{ __('messages.help') }}</h3>
                    <ul class="space-y-1 sm:space-y-2">
                        <li><a href="{{ route('policies.privacy') }}" class="text-gray-300 hover:text-white text-sm sm:text-base transition-colors">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="{{ route('policies.shipping') }}" class="text-gray-300 hover:text-white text-sm sm:text-base transition-colors">{{ __('messages.shipping_policy') }}</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-gray-300 hover:text-white text-sm sm:text-base transition-colors">{{ __('messages.contact_us') }}</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="text-gray-300 hover:text-white text-sm sm:text-base transition-colors">{{ __('messages.wishlist') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-6 sm:mt-8 pt-4 sm:pt-8">
                <div class="flex flex-col sm:flex-row items-center justify-self-center">
                    <div class="text-center sm:text-left">
                        <p class="text-gray-300 text-xs sm:text-sm">&copy; 2024 {{ __('messages.business_name') }}. {{ __('messages.all_rights_reserved') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Language menu toggle
        function toggleLanguageMenu() {
            const languageMenu = document.getElementById('language-menu');
            languageMenu.classList.toggle('hidden');
        }


        // Close language menu when clicking outside
        document.addEventListener('click', function(event) {
            const languageMenu = document.getElementById('language-menu');
            const languageButton = event.target.closest('[onclick="toggleLanguageMenu()"]');

            if (!languageButton && !languageMenu.contains(event.target)) {
                languageMenu.classList.add('hidden');
            }
        });


        // Close language menu when clicking outside
        document.addEventListener('click', function(event) {
            const languageMenu = document.getElementById('language-menu');
            const languageButton = event.target.closest('[onclick="toggleLanguageMenu()"]');

            if (!languageButton && !languageMenu.contains(event.target)) {
                languageMenu.classList.add('hidden');
            }
        });

        // Update cart count from server
        function updateCartCount() {
            fetch('{{ route("cart.count") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count;
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
        }

        // Initialize cart count
        updateCartCount();

        // Cart Sidebar Functions
        function openCartSidebar() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-sidebar-overlay');
            // Show overlay and sidebar
            overlay.classList.remove('hidden');
            sidebar.classList.remove('hidden');

            // Trigger animation
            setTimeout(() => {
                overlay.classList.add('opacity-100');
                overlay.classList.remove('opacity-0');
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
            }, 10);

            // Prevent body scroll
            document.body.style.overflow = 'hidden';

            // Load cart items
            loadCartSidebar();
        }

        function closeCartSidebar() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-sidebar-overlay');

            // Trigger animation
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('translate-x-full');

            // Hide after animation
            setTimeout(() => {
                overlay.classList.add('hidden');
                sidebar.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        function loadCartSidebar() {
            const loading = document.getElementById('cart-sidebar-loading');
            const empty = document.getElementById('cart-sidebar-empty');
            const itemsList = document.getElementById('cart-sidebar-items-list');
            const footer = document.getElementById('cart-sidebar-footer');

            // Show loading
            loading.classList.remove('hidden');
            empty.classList.add('hidden');
            itemsList.classList.add('hidden');
            footer.classList.add('hidden');

            fetch('{{ route("cart.sidebar") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                loading.classList.add('hidden');

                if (data.success && data.items && data.items.length > 0) {
                    // Show items
                    itemsList.classList.remove('hidden');
                    footer.classList.remove('hidden');
                    empty.classList.add('hidden');

                    // Update count
                    document.getElementById('cart-sidebar-count').textContent = `(${data.count})`;

                    // Update total
                    document.getElementById('cart-sidebar-total').textContent = `${parseFloat(data.total).toFixed(2)} DH`;

                    // Render items
                    renderCartItems(data.items);
                } else {
                    // Show empty state
                    empty.classList.remove('hidden');
                    itemsList.classList.add('hidden');
                    footer.classList.add('hidden');
                    document.getElementById('cart-sidebar-count').textContent = '(0)';
                }
            })
            .catch(error => {
                console.error('Error loading cart:', error);
                loading.classList.add('hidden');
                empty.classList.remove('hidden');
            });
        }

        function renderCartItems(items) {
            const container = document.getElementById('cart-sidebar-items-list');

            const spaceXClass = @json(app()->getLocale() === 'ar' ? 'space-x-reverse space-x-4' : 'space-x-4');
            container.innerHTML = items.map((item) => {
                return `
                    <div class="flex ${spaceXClass} p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200" data-cart-item="${item.cart_key}">
                        <img src="${item.product.image}" alt="${item.product.name}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800 text-sm mb-1 truncate">
                                <a href="/products/${item.product.slug}" class="hover:text-brown">${item.product.name}</a>
                            </h3>
                            ${item.color ? `<p class="text-xs text-gray-600">Color: ${item.color.name}</p>` : ''}
                            ${item.size ? `<p class="text-xs text-gray-600">Size: ${item.size.name}</p>` : ''}
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-2">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button onclick="updateSidebarQuantity('${item.cart_key}', ${item.quantity - 1})" class="w-7 h-7 flex items-center justify-center hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="px-3 py-1 text-sm font-medium min-w-[2rem] text-center">${item.quantity}</span>
                                    <button onclick="updateSidebarQuantity('${item.cart_key}', ${item.quantity + 1})" class="w-7 h-7 flex items-center justify-center hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                                <div class="text-right mt-2.5 sm:mt-0">
                                    <p class="text-sm font-bold text-brown">${parseFloat(item.subtotal).toFixed(2)} DH</p>
                                    <p class="text-xs text-gray-500">${parseFloat(item.product.price).toFixed(2)} DH each</p>
                                </div>
                            </div>
                        </div>
                        <button onclick="removeSidebarItem('${item.cart_key}')" class="text-red-500 hover:text-red-700 transition-colors p-2" title="Remove">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                `;
            }).join('');
        }

        function updateSidebarQuantity(cartKey, newQuantity) {
            if (newQuantity < 1) return;

            fetch('{{ route("cart.update") }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart_key: cartKey,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    loadCartSidebar();
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
            });
        }

        function removeSidebarItem(cartKey) {
            fetch('{{ route("cart.remove") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart_key: cartKey
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    loadCartSidebar();
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
            });
        }

        // Close sidebar on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCartSidebar();
            }
        });

        // Newsletter Modal Handler
        function showNewsletterModal() {
            const modal = document.getElementById('newsletterModal');
            const modalContent = document.getElementById('newsletterModalContent');

            if (modal && !modal.classList.contains('hidden')) {
                return; // Already shown
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeNewsletterModal() {
            const modal = document.getElementById('newsletterModal');
            const modalContent = document.getElementById('newsletterModalContent');
            const dontShowAgain = document.getElementById('dontShowAgain');

            // Check if "Don't show again" is checked
            if (dontShowAgain && dontShowAgain.checked) {
                localStorage.setItem('newsletterModalShown', 'true');
            } else {
                sessionStorage.setItem('newsletterModalShown', 'true');
            }

            // Animate out
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Show newsletter modal after delay (only once per session)
        document.addEventListener('DOMContentLoaded', function() {
            // Check if modal was already shown in this session or permanently dismissed
            const sessionShown = sessionStorage.getItem('newsletterModalShown');
            const permanentDismiss = localStorage.getItem('newsletterModalShown');

            if (!sessionShown && !permanentDismiss) {
                // Show modal after 3 seconds
                setTimeout(() => {
                    showNewsletterModal();
                }, 3000);
            }
        });

        // Newsletter Modal Form Handler
        const newsletterModalForm = document.getElementById('newsletterModalForm');
        if (newsletterModalForm) {
            newsletterModalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = document.getElementById('newsletterModalEmail').value;
                const submitBtn = newsletterModalForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                // Show loading state
                submitBtn.disabled = true;
                const submittingText = @json(__('messages.submitting'));
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ' + (@json(app()->getLocale() === 'ar') ? 'ml-2' : 'mr-2') + '"></i>' + submittingText + '...';

                // Submit to backend
                fetch('{{ route("newsletter.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const successMessage = @json(__('messages.newsletter_success'));
                        showNotification(successMessage, 'success');
                        closeNewsletterModal();
                        newsletterModalForm.reset();
                    } else {
                        showNotification(data.message || 'An error occurred', 'error');
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred. Please try again.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }

        // Close modal on background click
        document.getElementById('newsletterModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeNewsletterModal();
            }
        });

        // Live Sale Notification System
        const activeProducts = @json($activeProductsForNotifications ?? []);
        let currentNotificationIndex = 0;
        let notificationInterval = null;

        function getRandomTimeAgo() {
            const times = [
                { type: 'just_now', value: 0 },
                { type: 'minutes', value: Math.floor(Math.random() * 59) + 1 },
                { type: 'hours', value: Math.floor(Math.random() * 23) + 1 },
            ];
            const selected = times[Math.floor(Math.random() * times.length)];

            if (selected.type === 'just_now') {
                return @json(__('messages.just_now'));
            } else if (selected.type === 'minutes') {
                return @json(__('messages.minutes_ago')).replace(':count', selected.value);
            } else {
                return @json(__('messages.hours_ago')).replace(':count', selected.value);
            }
        }

        function showLiveSaleNotification() {
            if (activeProducts.length === 0) return;

            const notification = document.getElementById('liveSaleNotification');
            const product = activeProducts[currentNotificationIndex % activeProducts.length];

            // Update notification content
            document.getElementById('notificationProductImage').src = product.image;
            document.getElementById('notificationProductImage').alt = product.name;
            document.getElementById('notificationProductName').textContent = product.name;
            document.getElementById('notificationTime').textContent = getRandomTimeAgo();

            // Show notification
            notification.classList.remove('hidden');
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';

            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideLiveSaleNotification();
            }, 5000);

            // Move to next product
            currentNotificationIndex++;
        }

        function hideLiveSaleNotification() {
            const notification = document.getElementById('liveSaleNotification');
            notification.style.transform = 'translateX(-120%)';
            notification.style.opacity = '0';

            // Hide after animation
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 500);
        }

        function closeLiveSaleNotification() {
            hideLiveSaleNotification();
            // Stop showing notifications for this session
            sessionStorage.setItem('liveSaleNotificationsDisabled', 'true');
            if (notificationInterval) {
                clearInterval(notificationInterval);
            }
        }

        // Start live sale notifications
        document.addEventListener('DOMContentLoaded', function() {
            // Check if notifications are disabled
            if (sessionStorage.getItem('liveSaleNotificationsDisabled') === 'true') {
                return;
            }

            if (activeProducts.length > 0) {
                // Show first notification after 10 seconds
                setTimeout(() => {
                    showLiveSaleNotification();

                    // Function to schedule next notification
                    function scheduleNextNotification() {
                        const delay = Math.floor(Math.random() * 15000) + 15000; // 15-30 seconds
                        setTimeout(() => {
                            showLiveSaleNotification();
                            scheduleNextNotification(); // Schedule the next one
                        }, delay);
                    }

                    // Start scheduling notifications
                    scheduleNextNotification();
                }, 10000);
            }
        });

        // Global Notification System
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-semibold transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                'bg-blue-500'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Countdown Timer Functionality
        function initCountdownTimer() {
            const countdownBanner = document.getElementById('countdown-banner');
            if (!countdownBanner) return;

            const endDateElement = countdownBanner.querySelector('.countdown-end-date');
            if (!endDateElement) return;

            const endDate = new Date(endDateElement.dataset.endDate).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    // Countdown expired
                    countdownBanner.style.display = 'none';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const daysElement = document.getElementById('countdown-days');
                const hoursElement = document.getElementById('countdown-hours');
                const minutesElement = document.getElementById('countdown-minutes');
                const secondsElement = document.getElementById('countdown-seconds');

                if (daysElement) daysElement.textContent = String(days).padStart(2, '0');
                if (hoursElement) hoursElement.textContent = String(hours).padStart(2, '0');
                if (minutesElement) minutesElement.textContent = String(minutes).padStart(2, '0');
                if (secondsElement) secondsElement.textContent = String(seconds).padStart(2, '0');

                // Pulse animation when seconds change
                if (secondsElement) {
                    secondsElement.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        secondsElement.style.transform = 'scale(1)';
                    }, 200);
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Initialize countdown when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            initCountdownTimer();
        });
    </script>

    @stack('scripts')
</body>
</html>
