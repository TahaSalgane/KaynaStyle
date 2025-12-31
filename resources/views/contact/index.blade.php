@extends('layouts.app')

@section('title', __('messages.contact_us'))

@section('content')
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 gradient-text">
                {{ __('messages.contact_us') }}
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                {{ __('messages.contact_subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.send_message') }}</h2>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown transition duration-300"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.email') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown transition duration-300"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.subject') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="subject"
                               name="subject"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown transition duration-300"
                               value="{{ old('subject') }}">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.message') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message"
                                  name="message"
                                  rows="6"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown transition duration-300 resize-none">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-brown text-white py-3 px-6 rounded-lg font-semibold hover:bg-brown-darker transition-all duration-300 transform hover:scale-105 shadow-lg">
                        {{ __('messages.send_message') }}
                        <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.contact_info') }}</h2>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-brown text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ __('messages.email') }}</h3>
                                <p class="text-gray-600">contact@kaynastyle.com</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-brown text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ __('messages.phone') }}</h3>
                                <p class="text-gray-600"><a href="tel:+19176952890" class="hover:text-brown transition-colors">+1 917 695 2890</a></p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-brown/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-brown text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">{{ __('messages.address') }}</h3>
                                <p class="text-gray-600">{{ __('messages.business_address') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Link -->
                <div class="bg-brown/5 rounded-2xl p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.have_questions') }}</h3>
                    <p class="text-gray-600 mb-4 text-sm">{{ __('messages.check_faq') }}</p>
                    <a href="{{ route('faq.index') }}" class="inline-flex items-center text-brown font-semibold hover:text-brown-darker transition-colors">
                        {{ __('messages.view_faq') }}
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection




