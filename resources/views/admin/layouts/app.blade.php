<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --color-brown-primary: #8B4513;
            --color-brown-light: #D2B48C;
            --color-brown-darker: #654321;
        }
        .bg-brown { background-color: var(--color-brown-primary); }
        .text-brown { color: var(--color-brown-primary); }
        .border-brown { border-color: var(--color-brown-primary); }
        .hover\:bg-brown:hover { background-color: var(--color-brown-primary); }
        .hover\:text-brown:hover { color: var(--color-brown-primary); }
        .focus\:ring-brown:focus { --tw-ring-color: var(--color-brown-primary); }
        .focus\:border-brown:focus { border-color: var(--color-brown-primary); }
        .bg-brown-light { background-color: var(--color-brown-light); }
        .text-brown-light { color: var(--color-brown-light); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col">
            <!-- Logo -->
            <div class="p-4 lg:p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 lg:w-10 lg:h-10 bg-brown rounded-full flex items-center justify-center">
                            <i class="fas fa-crown text-white text-sm lg:text-base"></i>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-lg lg:text-xl font-bold text-gray-800">{{ __('Admin Panel') }}</h1>
                            <p class="text-xs lg:text-sm text-gray-500">{{ __('Dashboard') }}</p>
                        </div>
                    </div>
                    <!-- Mobile close button -->
                    <button id="close-sidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 lg:mt-6 overflow-y-auto flex-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Dashboard') }}</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.products.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-box mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Products') }}</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.categories.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-th-large mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Categories') }}</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-shopping-cart mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Orders') }}</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.reviews.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-star mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Reviews') }}</span>
                </a>

                <a href="{{ route('admin.questions.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.questions.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-question-circle mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Questions') }}</span>
                </a>

                <a href="{{ route('admin.contact.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.contact.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-envelope mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Contact Messages') }}</span>
                </a>

                <a href="{{ route('admin.hero-images.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.hero-images.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-images mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Hero Images') }}</span>
                </a>

                <a href="{{ route('admin.countdown.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.countdown.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-clock mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Countdown Timer') }}</span>
                </a>

                <!-- Fields Section -->
                <div class="mt-4">
                    <div class="px-4 lg:px-6 py-2">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Fields') }}</h3>
                    </div>

                    <a href="{{ route('admin.colors.index') }}"
                       class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.colors.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                        <i class="fas fa-palette mr-3 text-sm lg:text-base"></i>
                        <span class="text-sm lg:text-base">{{ __('Colors') }}</span>
                    </a>

                    <a href="{{ route('admin.sizes.index') }}"
                       class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.sizes.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                        <i class="fas fa-ruler mr-3 text-sm lg:text-base"></i>
                        <span class="text-sm lg:text-base">{{ __('Sizes') }}</span>
                    </a>
                </div>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center px-4 lg:px-6 py-3 text-gray-700 hover:bg-brown-light hover:text-brown transition duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-brown-light text-brown border-r-4 border-brown' : '' }}">
                    <i class="fas fa-users mr-3 text-sm lg:text-base"></i>
                    <span class="text-sm lg:text-base">{{ __('Users') }}</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 lg:p-6 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-brown rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm text-gray-500 hover:text-red-500 transition duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 lg:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button id="open-sidebar" class="lg:hidden text-gray-500 hover:text-gray-700 mr-3">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-xl lg:text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center space-x-2 lg:space-x-4">
                            <a href="{{ route('home') }}" target="_blank"
                               class="text-gray-500 hover:text-brown transition duration-300 text-sm lg:text-base">
                               <i class="fas fa-external-link-alt mr-2"></i>
                               <span class="hidden sm:inline">{{ __('View Site') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 lg:px-6 py-4 lg:py-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 lg:mb-6 text-sm lg:text-base">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 lg:mb-6 text-sm lg:text-base">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 lg:mb-6 text-sm lg:text-base">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const openButton = document.getElementById('open-sidebar');
            const closeButton = document.getElementById('close-sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openButton.addEventListener('click', openSidebar);
            closeButton.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            // Close sidebar when clicking on navigation links on mobile
            const navLinks = sidebar.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
