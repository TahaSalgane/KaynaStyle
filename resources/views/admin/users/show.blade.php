@extends('admin.layouts.app')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                <div class="w-16 h-16 bg-brown rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
                <div class="{{ app()->getLocale() === 'ar' ? 'mr-4 text-right' : 'ml-4' }}">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="bg-brown text-white px-4 py-2 rounded-lg hover:bg-brown-darker transition duration-300">
                    <i class="fas fa-edit {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                    {{ __('Edit User') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Information -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('User Information') }}</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('Name') }}</label>
                        <p class="text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('Email') }}</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('Email Verified') }}</label>
                        <p class="text-gray-900">
                            @if($user->email_verified_at)
                                <span class="text-green-600">{{ __('Yes') }} ({{ $user->email_verified_at->format('M d, Y') }})</span>
                            @else
                                <span class="text-red-600">{{ __('No') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Account Details') }}</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('Member Since') }}</label>
                        <p class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('Last Updated') }}</label>
                        <p class="text-gray-900">{{ $user->updated_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">{{ __('User ID') }}</label>
                        <p class="text-gray-900">#{{ $user->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} mt-6">
            <a href="{{ route('admin.users.index') }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300">
                {{ __('Back to Users') }}
            </a>
        </div>
    </div>
</div>
@endsection









