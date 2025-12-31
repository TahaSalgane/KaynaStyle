@extends('layouts.app')

@section('title', __('messages.shipping_policy'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white py-12 sm:py-16 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-10 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-brown mb-4">
                {{ __('messages.shipping_policy') }}
            </h1>
            <p class="text-gray-600 text-sm sm:text-base">
                {{ __('messages.last_updated') }}: {{ date('F d, Y') }}
            </p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10 space-y-8">
            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.shipping_intro_title') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.shipping_intro_text') }}
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    <strong>Business Name:</strong> {{ __('messages.business_name') }}<br>
                    <strong>Full Business Name:</strong> {{ __('messages.business_name_full') }}
                </p>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.processing_time') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.processing_time_text') }}
                </p>
                <div class="bg-brown-lighter rounded-lg p-4 sm:p-6 border border-brown/20">
                    <p class="text-gray-800 font-semibold mb-2">{{ __('messages.preparation_time') }}</p>
                    <p class="text-gray-700">{{ __('messages.preparation_time_text') }}</p>
                </div>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.shipping_methods') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.shipping_methods_text') }}
                </p>
                <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                    <li>{{ __('messages.shipping_method_1') }}</li>
                    <li>{{ __('messages.shipping_method_2') }}</li>
                    <li>{{ __('messages.shipping_method_3') }}</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.delivery_times') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.delivery_times_text') }}
                </p>
                <div class="bg-brown-lighter rounded-lg p-4 sm:p-6 border border-brown/20 space-y-3">
                    <div>
                        <p class="text-gray-800 font-semibold">{{ __('messages.delivery_time_1') }}</p>
                        <p class="text-gray-700">{{ __('messages.delivery_time_1_text') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-800 font-semibold">{{ __('messages.delivery_time_2') }}</p>
                        <p class="text-gray-700">{{ __('messages.delivery_time_2_text') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-800 font-semibold">{{ __('messages.estimated_total') }}</p>
                        <p class="text-gray-700">{{ __('messages.estimated_total_text') }}</p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.tracking') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.tracking_text') }}
                </p>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.shipping_responsibility') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.shipping_responsibility_text') }}
                </p>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.customs_duties') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.customs_duties_text') }}
                </p>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <p class="text-gray-800 font-semibold mb-2">{{ __('messages.canada_note') }}</p>
                    <p class="text-gray-700">{{ __('messages.canada_note_text') }}</p>
                </div>
            </section>

            <section>
                <h2 class="text-xl sm:text-2xl font-bold text-brown mb-4">{{ __('messages.contact_us') }}</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ __('messages.shipping_contact_text') }}
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


