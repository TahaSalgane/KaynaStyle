@extends('layouts.app')

@section('title', __('messages.faq'))

@section('content')
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 gradient-text">
                {{ __('messages.faq') }}
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                {{ __('messages.faq_subtitle') }}
            </p>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-4">
            @php
                $faqs = [
                    [
                        'question' => __('messages.faq_question_1'),
                        'answer' => __('messages.faq_answer_1')
                    ],
                    [
                        'question' => __('messages.faq_question_payment'),
                        'answer' => __('messages.faq_answer_payment')
                    ],
                    [
                        'question' => __('messages.faq_question_3'),
                        'answer' => __('messages.faq_answer_3')
                    ],
                    [
                        'question' => __('messages.faq_question_4'),
                        'answer' => __('messages.faq_answer_4')
                    ]
                ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <button class="faq-item w-full px-6 py-5 text-left flex items-center justify-between focus:outline-none" onclick="toggleFAQ({{ $index }})">
                    <span class="font-semibold text-gray-900 text-base sm:text-lg pr-4">{{ $faq['question'] }}</span>
                    <i class="fas fa-chevron-down faq-icon text-brown transition-transform duration-300" id="faq-icon-{{ $index }}"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-5" id="faq-answer-{{ $index }}">
                    <div class="pt-2 border-t border-gray-200">
                        <p class="text-gray-700 leading-relaxed text-sm sm:text-base">{{ $faq['answer'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact CTA -->
        <div class="mt-12 text-center bg-brown/5 rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('messages.faq_need_help') }}</h3>
            <p class="text-gray-600 mb-6">{{ __('messages.faq_contact_us') }}</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center px-6 py-3 bg-brown text-white rounded-full font-semibold hover:bg-brown-darker transition-all duration-300 transform hover:scale-105">
                {{ __('messages.contact_us') }}
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
function toggleFAQ(index) {
    const answer = document.getElementById('faq-answer-' + index);
    const icon = document.getElementById('faq-icon-' + index);

    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        answer.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>
@endpush
@endsection




