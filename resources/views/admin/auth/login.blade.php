<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Admin Login') }} - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-brown rounded-full mb-4">
                <i class="fas fa-crown text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Admin Panel') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('Sign in to your account') }}</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Email Address') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('email') border-red-500 @enderror"
                               placeholder="{{ __('Enter your email') }}">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('Password') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent transition duration-300 @error('password') border-red-500 @enderror"
                               placeholder="{{ __('Enter your password') }}">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember"
                               class="h-4 w-4 text-brown focus:ring-brown border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-brown text-white py-3 px-4 rounded-lg font-semibold hover:bg-brown-darker transition duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    {{ __('Sign In') }}
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-600 text-sm">
                {{ __('© 2026 Admin Panel. All rights reserved.') }}
            </p>
        </div>
    </div>
</body>
</html>









