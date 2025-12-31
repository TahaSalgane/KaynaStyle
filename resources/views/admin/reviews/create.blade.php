@extends('admin.layouts.app')

@section('title', 'Add Review')
@section('page-title', 'Add New Review')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.reviews.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-2">
                {{ __('Product') }} <span class="text-red-500">*</span>
            </label>
            <select name="product_id" id="product_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent">
                <option value="">{{ __('Select a product') }}</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            @error('product_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- <div>
            <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                {{ __('Customer Name') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" name="customer_name" id="customer_name" required
                   value="{{ old('customer_name') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent"
                   placeholder="{{ __('Enter customer name') }}">
            @error('customer_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                {{ __('Rating') }} <span class="text-red-500">*</span>
            </label>
            <div class="flex items-center space-x-2" id="rating-selector">
                @for($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $i }}" class="sr-only" required>
                <label for="rating-{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 transition-colors rating-star" data-rating="{{ $i }}">
                    <i class="fas fa-star"></i>
                </label>
                @endfor
            </div>
            @error('rating')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="review_text" class="block text-sm font-semibold text-gray-700 mb-2">
                {{ __('Review Text') }} <span class="text-red-500">*</span>
            </label>
            <textarea name="review_text" id="review_text" rows="5" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-transparent resize-none"
                      placeholder="{{ __('Enter review text') }}">{{ old('review_text') }}</textarea>
            @error('review_text')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.reviews.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                {{ __('Cancel') }}
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-brown text-white rounded-lg hover:bg-brown-darker transition duration-300">
                <i class="fas fa-save mr-2"></i>
                {{ __('Create Review') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating-star');

    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            document.getElementById('rating-' + rating).checked = true;

            // Update visual display
            ratingStars.forEach((s, index) => {
                const starRating = 5 - index;
                if (starRating <= rating) {
                    s.querySelector('i').classList.remove('text-gray-300');
                    s.querySelector('i').classList.add('text-yellow-400');
                } else {
                    s.querySelector('i').classList.remove('text-yellow-400');
                    s.querySelector('i').classList.add('text-gray-300');
                }
            });
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            ratingStars.forEach((s, index) => {
                const starRating = 5 - index;
                if (starRating <= rating) {
                    s.querySelector('i').classList.add('text-yellow-400');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            const checkedRating = document.querySelector('input[name="rating"]:checked');
            if (!checkedRating) {
                ratingStars.forEach(s => {
                    s.querySelector('i').classList.remove('text-yellow-400');
                    s.querySelector('i').classList.add('text-gray-300');
                });
            } else {
                const rating = parseInt(checkedRating.value);
                ratingStars.forEach((s, index) => {
                    const starRating = 5 - index;
                    if (starRating <= rating) {
                        s.querySelector('i').classList.remove('text-gray-300');
                        s.querySelector('i').classList.add('text-yellow-400');
                    } else {
                        s.querySelector('i').classList.remove('text-yellow-400');
                        s.querySelector('i').classList.add('text-gray-300');
                    }
                });
            }
        });
    });
});
</script>
@endpush
@endsection


