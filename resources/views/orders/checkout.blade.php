@extends('layouts.app')

@section('title', __('messages.checkout'))

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('messages.checkout') }}</h1>

        <form action="{{ route('orders.store') }}" method="POST" id="checkout-form" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            @csrf

            <!-- Billing Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 lg:p-8">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 sm:mb-6">{{ __('messages.customer_info') }}</h2>

                    <div class="space-y-4 sm:space-y-6">
                        <!-- Email -->
                        <div>
                            <label for="billing_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email address <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="billing_email"
                                   name="billing_email"
                                   value="{{ old('billing_email') }}"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_email') border-red-500 @enderror text-sm sm:text-base"
                                   required
                                   autocomplete="email">
                            @error('billing_email')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- First Name and Last Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label for="billing_first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    First name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="billing_first_name"
                                       name="billing_first_name"
                                       value="{{ old('billing_first_name') }}"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_first_name') border-red-500 @enderror text-sm sm:text-base"
                                       required
                                       autocomplete="given-name">
                                @error('billing_first_name')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="billing_last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Last name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="billing_last_name"
                                       name="billing_last_name"
                                       value="{{ old('billing_last_name') }}"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_last_name') border-red-500 @enderror text-sm sm:text-base"
                                       required
                                       autocomplete="family-name">
                                @error('billing_last_name')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Company (Optional) -->
                        <div>
                            <label for="billing_company" class="block text-sm font-semibold text-gray-700 mb-2">
                                Company name <span class="text-gray-500 text-xs font-normal">(optional)</span>
                            </label>
                            <input type="text"
                                   id="billing_company"
                                   name="billing_company"
                                   value="{{ old('billing_company') }}"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_company') border-red-500 @enderror text-sm sm:text-base"
                                   autocomplete="organization">
                            @error('billing_company')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="billing_country" class="block text-sm font-semibold text-gray-700 mb-2">
                                Country / Region <span class="text-red-500">*</span>
                            </label>
                            <select id="billing_country"
                                    name="billing_country"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_country') border-red-500 @enderror text-sm sm:text-base"
                                    required
                                    autocomplete="country">
                                <option value="">Select a country / region…</option>
                                @foreach($countries as $code => $name)
                                <option value="{{ $code }}" {{ old('billing_country', 'US') === $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('billing_country')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Address -->
                        <div>
                            <label for="billing_address_1" class="block text-sm font-semibold text-gray-700 mb-2">
                                Street address <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="billing_address_1"
                                   name="billing_address_1"
                                   value="{{ old('billing_address_1') }}"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_address_1') border-red-500 @enderror text-sm sm:text-base"
                                   placeholder="House number and street name"
                                   required
                                   autocomplete="address-line1">
                            @error('billing_address_1')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Apartment, suite, unit, etc. (Optional) -->
                        <div>
                            <label for="billing_address_2" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="sr-only">Apartment, suite, unit, etc.</span>
                                <span class="text-gray-500 text-xs font-normal">(optional)</span>
                            </label>
                            <input type="text"
                                   id="billing_address_2"
                                   name="billing_address_2"
                                   value="{{ old('billing_address_2') }}"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_address_2') border-red-500 @enderror text-sm sm:text-base"
                                   placeholder="Apartment, suite, unit, etc. (optional)"
                                   autocomplete="address-line2">
                            @error('billing_address_2')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City and State -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label for="billing_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Town / City <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="billing_city"
                                       name="billing_city"
                                       value="{{ old('billing_city') }}"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_city') border-red-500 @enderror text-sm sm:text-base"
                                       required
                                       autocomplete="address-level2">
                                @error('billing_city')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="state-field-wrapper">
                                <label for="billing_state" class="block text-sm font-semibold text-gray-700 mb-2">
                                    State <span class="text-red-500" id="state-required">*</span>
                                </label>
                                <select id="billing_state"
                                        name="billing_state"
                                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_state') border-red-500 @enderror text-sm sm:text-base"
                                        autocomplete="address-level1">
                                    <option value="">Select an option…</option>
                                    @foreach($usStates as $code => $name)
                                    <option value="{{ $code }}" {{ old('billing_state') === $code ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <input type="text"
                                       id="billing_state_text"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_state') border-red-500 @enderror text-sm sm:text-base hidden"
                                       placeholder="State / Province"
                                       autocomplete="address-level1"
                                       disabled>
                                @error('billing_state')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Postcode -->
                        <div>
                            <label for="billing_postcode" class="block text-sm font-semibold text-gray-700 mb-2">
                                ZIP Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="billing_postcode"
                                   name="billing_postcode"
                                   value="{{ old('billing_postcode') }}"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_postcode') border-red-500 @enderror text-sm sm:text-base"
                                   required
                                   autocomplete="postal-code">
                            @error('billing_postcode')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="billing_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel"
                                   id="billing_phone"
                                   name="billing_phone"
                                   value="{{ old('billing_phone') }}"
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent @error('billing_phone') border-red-500 @enderror text-sm sm:text-base"
                                   required
                                   autocomplete="tel">
                            @error('billing_phone')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes (Optional) -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('messages.notes') }}
                            </label>
                            <textarea id="notes"
                                      name="notes"
                                      rows="3"
                                      class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent text-sm sm:text-base"
                                      placeholder="{{ app()->getLocale() === 'ar' ? 'أي ملاحظات إضافية...' : 'Any additional notes...' }}">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 sticky top-8">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">{{ __('messages.order_summary') }}</h2>

                    <!-- Cart Items -->
                    <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6 max-h-96 overflow-y-auto">
                        @foreach($cartItems as $item)
                        <div class="flex items-center {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-3 sm:space-x-reverse sm:space-x-4' : 'space-x-3 sm:space-x-4' }} pb-3 sm:pb-4 border-b border-gray-200 last:border-b-0">
                            @php
                                $mainImage = null;
                                if ($item['color']) {
                                    $mainImage = $item['product']->getMainImageForColor($item['color']->id);
                                }
                                $mainImagePath = $mainImage ? $mainImage->image_path : ($item['product']->main_image ?? null);
                            @endphp
                            <img src="{{ $mainImagePath ? asset('storage/' . $mainImagePath) : 'https://via.placeholder.com/300x375/FFC0CB/FFFFFF?text=' . urlencode($item['product']->name) }}"
                                 alt="{{ $item['product']->name }}"
                                 class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-lg aspect-[2/3]">
                            <div class="flex-1">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-800">{{ $item['product']->name }}</h3>
                                <p class="text-xs text-gray-600">{{ $item['product']->category->name }}</p>
                                @if($item['color'])
                                <p class="text-xs text-gray-600">
                                    <span class="font-medium">{{ __('messages.color') }}:</span> {{ $item['color']->name }}
                                </p>
                                @endif
                                @if($item['size'])
                                <p class="text-xs text-gray-600">
                                    <span class="font-medium">{{ __('messages.size') }}:</span> {{ $item['size']->name }}
                                </p>
                                @endif
                                <p class="text-xs sm:text-sm font-semibold text-brown">
                                    {{ $item['quantity'] }} × {{ number_format($item['product']->current_price, 2) }} DH
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Total -->
                    <div class="border-t pt-3 sm:pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ __('messages.subtotal') }}</span>
                            <span class="font-semibold text-sm sm:text-base">{{ number_format($total, 2) }} DH</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ app()->getLocale() === 'ar' ? 'التوصيل' : 'Delivery' }}</span>
                            <span class="font-semibold text-green-600 text-sm sm:text-base">{{ app()->getLocale() === 'ar' ? 'مجاني' : 'Free' }}</span>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between text-base sm:text-lg font-bold">
                                <span>{{ __('messages.total') }}</span>
                                <span class="text-brown">{{ number_format($total, 2) }} DH</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-yellow-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-yellow-600 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} text-sm"></i>
                            <span class="text-xs sm:text-sm text-yellow-800">
                                {{ app()->getLocale() === 'ar' ? 'الدفع عند التوصيل فقط' : 'Cash on delivery only' }}
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-brown text-white py-3 sm:py-4 rounded-lg text-sm sm:text-base lg:text-lg font-semibold hover:bg-brown-hover transition duration-300 mt-4 sm:mt-6">
                        <i class="fas fa-check {{ app()->getLocale() === 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}"></i>
                        {{ __('messages.place_order') }}
                    </button>

                    <!-- Estimated Delivery -->
                    <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200">
                        <div class="text-xs sm:text-sm text-gray-700 text-center">
                            <span class="font-semibold" id="estimated-arrival-range-checkout">-</span>
                            <span class="ml-1">{{ __('messages.estimated_arrival') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Form validation and dynamic state field
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    const countrySelect = document.getElementById('billing_country');
    const stateSelect = document.getElementById('billing_state');
    const stateText = document.getElementById('billing_state_text');
    const stateWrapper = document.getElementById('state-field-wrapper');
    const stateRequired = document.getElementById('state-required');

    // Handle country change - show dropdown for US, text input for others
    if (countrySelect && stateSelect && stateText) {
        function updateStateField() {
            const country = countrySelect.value;
            if (country === 'US') {
                // Show select, hide text input
                stateSelect.classList.remove('hidden');
                stateSelect.required = true;
                stateSelect.removeAttribute('disabled');
                stateSelect.setAttribute('name', 'billing_state');

                stateText.classList.add('hidden');
                stateText.required = false;
                stateText.value = '';
                stateText.setAttribute('disabled', 'disabled');
                stateText.removeAttribute('name'); // Remove name so it's not submitted

                stateRequired.classList.remove('hidden');
            } else {
                // Show text input, hide select
                stateSelect.classList.add('hidden');
                stateSelect.required = false;
                stateSelect.setAttribute('disabled', 'disabled');
                stateSelect.value = '';
                stateSelect.removeAttribute('name'); // Remove name so it's not submitted

                stateText.classList.remove('hidden');
                stateText.required = true;
                stateText.removeAttribute('disabled');
                stateText.setAttribute('name', 'billing_state'); // Ensure name is set

                stateRequired.classList.remove('hidden');
            }
        }

        countrySelect.addEventListener('change', updateStateField);

        // Trigger on page load to set initial state
        updateStateField();
    }

    form.addEventListener('submit', function(e) {
        // Ensure only the visible state field is validated
        const country = countrySelect ? countrySelect.value : 'US';
        if (country === 'US') {
            if (stateSelect && !stateSelect.value) {
                e.preventDefault();
                stateSelect.focus();
                stateSelect.classList.add('border-red-500');
                alert('Please select a state');
                submitButton.disabled = false;
                return false;
            }
        } else {
            if (stateText && !stateText.value.trim()) {
                e.preventDefault();
                stateText.focus();
                stateText.classList.add('border-red-500');
                alert('Please enter a state/province');
                submitButton.disabled = false;
                return false;
            }
        }

        // Submit via AJAX to handle JSON response
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "جاري المعالجة..." : "Processing..." }}';

        const formData = new FormData(form);

        // Get CSRF token - try meta tag first, then form field
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : formData.get('_token');

        // Ensure CSRF token is in FormData (it should be from the form, but double-check)
        if (!formData.get('_token') && csrfToken) {
            formData.append('_token', csrfToken);
        }

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'same-origin'
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // If not JSON, it might be an error page (419, etc.)
                if (response.status === 419) {
                    throw new Error('Session expired. Please refresh the page and try again.');
                }
                return response.text().then(text => {
                    throw new Error('Unexpected response format');
                });
            }
        })
        .then(data => {
            if (data.success && data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || 'An error occurred');
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-credit-card {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "تأكيد الطلب" : "Place Order" }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'An error occurred. Please refresh the page and try again.');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-credit-card {{ app()->getLocale() === "ar" ? "ml-2" : "mr-2" }}"></i>{{ app()->getLocale() === "ar" ? "تأكيد الطلب" : "Place Order" }}';
        });
    });

    // Calculate and display estimated delivery time
    function addBusinessDays(date, days) {
        let result = new Date(date);
        let addedDays = 0;

        while (addedDays < days) {
            result.setDate(result.getDate() + 1);
            // Skip weekends (Saturday = 6, Sunday = 0)
            if (result.getDay() !== 0 && result.getDay() !== 6) {
                addedDays++;
            }
        }

        return result;
    }

    function formatDate(date) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[date.getMonth()] + ' ' + date.getDate();
    }

    const today = new Date();
    const deliveryStartDate = addBusinessDays(today, 7);
    const deliveryEndDate = addBusinessDays(today, 12);

    const estimatedArrivalEl = document.getElementById('estimated-arrival-range-checkout');
    if (estimatedArrivalEl) {
        estimatedArrivalEl.textContent = formatDate(deliveryStartDate) + '-' + formatDate(deliveryEndDate) + '.';
    }
});
</script>
@endpush
