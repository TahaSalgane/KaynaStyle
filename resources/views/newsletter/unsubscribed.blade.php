@extends('layouts.app')

@section('title', __('messages.unsubscribe'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-12 sm:py-16 lg:py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-10 text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">{{ __('messages.unsubscribed_success') }}</h1>
                <p class="text-gray-600 mb-2">{{ __('messages.unsubscribed_message') }}</p>
                <p class="text-gray-500 text-sm">{{ $email }}</p>
            </div>
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-brown text-white rounded-lg font-semibold hover:bg-brown-darker transition-colors">
                {{ __('messages.back_to_home') }}
            </a>
        </div>
    </div>
</div>
@endsection



