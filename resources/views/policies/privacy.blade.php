@extends('layouts.app')

@section('title', __('messages.privacy_policy'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-12 sm:py-16 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-10 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-brown mb-4">
                {{ __('messages.privacy_policy') }}
            </h1>
            <p class="text-gray-600 text-sm sm:text-base">
                {{ __('messages.last_updated') }}: {{ date('F d, Y') }}
            </p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10 space-y-8">
            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.privacy_intro_title') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.privacy_intro_text') }}
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    <strong>Business Name:</strong> {{ __('messages.business_name') }}<br>
                    <strong>Full Business Name:</strong> {{ __('messages.business_name_full') }}
                </p>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.information_we_collect') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.information_we_collect_text') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.info_collect_1') }}</li>
                    <li>{{ __('messages.info_collect_2') }}</li>
                    <li>{{ __('messages.info_collect_3') }}</li>
                    <li>{{ __('messages.info_collect_4') }}</li>
                    <li>{{ __('messages.info_collect_5') }}</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.how_we_use_info') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.how_we_use_info_text') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.use_info_1') }}</li>
                    <li>{{ __('messages.use_info_2') }}</li>
                    <li>{{ __('messages.use_info_3') }}</li>
                    <li>{{ __('messages.use_info_4') }}</li>
                    <li>{{ __('messages.use_info_5') }}</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.data_protection') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.data_protection_text') }}
                </p>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.cookies') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.cookies_text') }}
                </p>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.your_rights') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.your_rights_text') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.rights_1') }}</li>
                    <li>{{ __('messages.rights_2') }}</li>
                    <li>{{ __('messages.rights_3') }}</li>
                    <li>{{ __('messages.rights_4') }}</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.contact_us') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.privacy_contact_text') }}
                </p>
                <p class="text-gray-700">
                    <strong>{{ __('messages.email') }}:</strong> contact@kaynastyle.com<br>
                    <strong>{{ __('messages.phone') }}:</strong> +1 917 695 2890
                </p>
            </section>
        </div>
    </div>
</div>
@endsection


