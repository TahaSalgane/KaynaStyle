{{--
    Reusable Reviews Section Component
    Used on both Category and Product pages

    Required Variables:
    - $categoryId: The category ID for reviews
    - $reviews: Paginated reviews collection
    - $allReviews: All reviews collection (for statistics)
    - $totalReviews: Total count of reviews
    - $averageRating: Average rating value
    - $ratingDistribution: Array of rating counts [5 => count, 4 => count, ...]
    - $sectionId: Unique section ID (e.g., 'product-reviews' or 'category-reviews')
    - $containerId: Unique container ID (e.g., 'judgeme_product_reviews' or 'judgeme_category_reviews')
--}}

<section id="{{ $sectionId }}" class="bg-white py-12 sm:py-16 {{ isset($addMarginTop) && $addMarginTop ? 'mt-16' : '' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="{{ $containerId }}" class="max-w-6xl mx-auto">
            <!-- Reviews Header with Summary - Shopify Inspired -->
            <div class="mb-8 bg-white rounded-lg shadow-md border border-gray-200 p-6 sm:p-8">
                <!-- Title -->
                <h2 class="jdgm-rev-widg__title text-2xl sm:text-3xl font-bold text-gray-900 mb-6">{{ __('messages.customer_reviews') }}</h2>

                @if($totalReviews > 0)
                <!-- Desktop: Three Column Layout -->
                <div class="hidden lg:flex lg:items-center lg:justify-between lg:gap-8 mb-8">
                    <!-- Left: Rating Summary -->
                    <div class="jdgm-rev-widg__summary flex-shrink-0">
                        <div class="jdgm-rev-widg__summary-inner">
                            <div class="jdgm-rev-widg__summary-stars flex items-center gap-2 mb-2" aria-label="Average rating is {{ number_format($averageRating, 2) }} stars" role="img">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="jdgm-star jdgm--{{ $i <= round($averageRating) ? 'on' : 'off' }}">
                                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }} text-xl"></i>
                                    </span>
                                @endfor
                                <span class="jdgm-rev-widg__summary-average text-lg font-semibold text-gray-900 ml-2">
                                    {{ number_format($averageRating, 2) }} {{ __('messages.out_of_5') }}
                                </span>
                            </div>
                            <div class="jdgm-rev-widg__summary-text text-gray-600">
                                {{ __('messages.based_on_reviews', ['count' => $totalReviews]) }}
                            </div>
                        </div>
                    </div>

                    <!-- Vertical Separator -->
                    <div class="hidden lg:block w-px h-auto bg-gray-300 flex-shrink-0 self-stretch"></div>

                    <!-- Middle: Rating Histogram -->
                    <div class="jdgm-histogram flex-1 max-w-md mx-4 flex items-center">
                        <div class="w-full">
                        @for($rating = 5; $rating >= 1; $rating--)
                            @php
                                $count = $ratingDistribution[$rating] ?? 0;
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="jdgm-histogram__row flex items-center gap-3 mb-2 cursor-pointer hover:opacity-80 transition-opacity"
                                 data-rating="{{ $rating }}"
                                 data-frequency="{{ $count }}"
                                 data-percentage="{{ $percentage }}"
                                 role="button"
                                 tabindex="0"
                                 aria-label="{{ $percentage }}% ({{ $count }}) reviews with {{ $rating }} star rating">
                                <div class="jdgm-histogram__star flex items-center gap-0.5 flex-shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="jdgm-star jdgm--{{ $i <= $rating ? 'on' : 'off' }}">
                                            <i class="fas fa-star {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                        </span>
                                    @endfor
                                </div>
                                <div class="jdgm-histogram__bar flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="jdgm-histogram__bar-content h-full bg-yellow-400 transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="jdgm-histogram__frequency text-sm text-gray-600 w-6 text-right">{{ $count }}</div>
                            </div>
                        @endfor
                        <div class="jdgm-histogram__row jdgm-histogram__clear-filter mt-3 text-sm text-gray-600 hover:text-brown cursor-pointer transition-colors"
                             data-rating="null"
                             tabindex="0"
                             role="button">
                            {{ __('messages.see_all_reviews') }}
                        </div>
                        </div>
                    </div>

                    <!-- Vertical Separator -->
                    <div class="hidden lg:block w-px h-auto bg-gray-300 flex-shrink-0 self-stretch"></div>

                    <!-- Right: Write Review Button -->
                    <div class="jdgm-widget-actions-wrapper flex-shrink-0">
                        <button id="write-review-btn"
                                class="jdgm-write-rev-link text-brown hover:text-brown-darker underline font-medium transition-colors"
                                role="button"
                                aria-expanded="false">
                            {{ __('messages.write_a_review') }}
                        </button>
                    </div>
                </div>

                <!-- Mobile: Stacked Layout -->
                <div class="lg:hidden space-y-4 mb-8">
                    <!-- Rating Summary -->
                    <div class="jdgm-rev-widg__summary">
                        <div class="jdgm-rev-widg__summary-inner">
                            <div class="jdgm-rev-widg__summary-stars flex items-center gap-2 mb-2" aria-label="Average rating is {{ number_format($averageRating, 2) }} stars" role="img">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="jdgm-star jdgm--{{ $i <= round($averageRating) ? 'on' : 'off' }}">
                                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }} text-xl"></i>
                                    </span>
                                @endfor
                                <span class="jdgm-rev-widg__summary-average text-lg font-semibold text-gray-900 ml-2">
                                    {{ number_format($averageRating, 2) }} {{ __('messages.out_of_5') }}
                                </span>
                            </div>
                            <div class="jdgm-rev-widg__summary-text text-gray-600">
                                {{ __('messages.based_on_reviews', ['count' => $totalReviews]) }}
                            </div>
                        </div>
                    </div>

                    <!-- Rating Histogram -->
                    <div class="jdgm-histogram">
                        @for($rating = 5; $rating >= 1; $rating--)
                            @php
                                $count = $ratingDistribution[$rating] ?? 0;
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="jdgm-histogram__row flex items-center gap-3 mb-2 cursor-pointer hover:opacity-80 transition-opacity"
                                 data-rating="{{ $rating }}"
                                 data-frequency="{{ $count }}"
                                 data-percentage="{{ $percentage }}"
                                 role="button"
                                 tabindex="0"
                                 aria-label="{{ $percentage }}% ({{ $count }}) reviews with {{ $rating }} star rating">
                                <div class="jdgm-histogram__star flex items-center gap-0.5 flex-shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="jdgm-star jdgm--{{ $i <= $rating ? 'on' : 'off' }}">
                                            <i class="fas fa-star {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                        </span>
                                    @endfor
                                </div>
                                <div class="jdgm-histogram__bar flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="jdgm-histogram__bar-content h-full bg-yellow-400 transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="jdgm-histogram__frequency text-sm text-gray-600 w-6 text-right">{{ $count }}</div>
                            </div>
                        @endfor
                        <div class="jdgm-histogram__row jdgm-histogram__clear-filter mt-3 text-sm text-gray-600 hover:text-brown cursor-pointer transition-colors block"
                             data-rating="null"
                             tabindex="0"
                             role="button">
                            {{ __('messages.see_all_reviews') }}
                        </div>
                    </div>

                    <!-- Write Review Button -->
                    <div class="jdgm-widget-actions-wrapper">
                        <button id="write-review-btn-mobile"
                                class="jdgm-write-rev-link text-brown hover:text-brown-darker underline font-medium transition-colors w-full text-left"
                                role="button"
                                aria-expanded="false">
                            {{ __('messages.write_a_review') }}
                        </button>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-6">{{ __('messages.no_reviews_yet') }}</p>
                    <button id="write-review-btn" class="jdgm-write-rev-link text-brown hover:text-brown-darker underline font-medium transition-colors">
                        {{ __('messages.write_a_review') }}
                    </button>
                </div>
                @endif

                <!-- Customer Photos & Videos Gallery -->
                @php
                    // Check if there are any reviews with media across ALL pages
                    $hasMediaReviews = isset($allReviews) && $allReviews->whereNotNull('media')->count() > 0;
                @endphp
                @if($totalReviews > 0 && $hasMediaReviews)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.customer_photos_videos') }}</h3>
                    <div class="flex flex-col items-center">
                        <div id="gallery-thumbnails-grid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 max-w-4xl">
                            @php
                                // Use allReviews to show ALL images from ALL pages
                                $mediaReviews = isset($allReviews) ? $allReviews->whereNotNull('media') : $reviews->whereNotNull('media');
                                $mediaReviewsAll = $mediaReviews->values()->all(); // Reset keys to be sequential (0, 1, 2, 3...)
                                $initialCount = 6;
                                $mediaReviewsInitial = array_slice($mediaReviewsAll, 0, $initialCount);
                                $hasMoreMedia = count($mediaReviewsAll) > $initialCount;
                            @endphp
                            @foreach($mediaReviewsInitial as $index => $review)
                                <div class="aspect-square rounded-lg overflow-hidden cursor-pointer hover:opacity-80 transition-opacity border border-gray-200 hover:border-brown transition-colors gallery-thumbnail"
                                     data-media-index="{{ $index }}"
                                     data-review-id="{{ $review->id }}"
                                     data-media-url="{{ asset('storage/' . $review->media) }}">
                                    @if(str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v'))
                                        <video src="{{ asset('storage/' . $review->media) }}" class="w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $review->media) }}" alt="Review media" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if($hasMoreMedia)
                        <div class="jdgm-widget-actions-wrapper flex-shrink-0 mt-6">
                            <button id="gallery-grid-see-more-btn" class="jdgm-write-rev-link text-brown hover:text-brown-darker underline font-medium transition-colors" role="button">
                                {{ __('messages.see_more') }} ({{ count($mediaReviewsAll) - $initialCount }} {{ __('messages.more') }})
                            </button>
                        </div>
                        @endif

                        <!-- Hidden container for all media reviews data -->
                        <div id="all-media-reviews-data" style="display: none;">
                            @foreach($mediaReviewsAll as $index => $review)
                                <div data-media-index="{{ $index }}"
                                     data-review-id="{{ $review->id }}"
                                     data-media-url="{{ asset('storage/' . $review->media) }}"
                                     data-is-video="{{ str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v') ? 'true' : 'false' }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Review Form (Hidden by default) -->
            <div id="review-form-wrapper" class="hidden mb-8 bg-gray-50 rounded-lg p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('messages.write_a_review') }}</h3>
                    <button id="close-review-form" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <form id="category-review-form" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $categoryId }}">

                    <!-- Rating -->
                    <div>
                        <div class="mb-2">{{ __('messages.rating') }} <span class="text-red-500">*</span></div>
                        <div class="flex items-center space-x-2" id="category-rating-selector">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="category-rating-{{ $i }}" class="sr-only" required>
                                <label for="category-rating-{{ $i }}" class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-400 transition-colors category-rating-star" data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="category-selected-rating" required>
                    </div>

                    <!-- Review Content -->
                    <div>
                        <label for="review_text" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('messages.review_content') }} <span class="text-red-500">*</span></label>
                        <textarea id="review_text" name="review_text" rows="5" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown resize-none transition-all text-gray-800 bg-white placeholder-gray-400"
                                  placeholder="{{ __('messages.start_writing_here') }}"></textarea>
                    </div>

                    <!-- Picture/Video Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">{{ __('messages.picture_video_optional') }}</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brown transition-colors">
                            <input type="file" id="review_media" name="media" accept="image/*,video/*" class="hidden">
                            <label for="review_media" class="cursor-pointer">
                                <i class="fas fa-camera text-3xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">{{ __('messages.choose_picture_video') }}</p>
                            </label>
                            <div id="media-preview" class="hidden mt-4">
                                <img id="media-preview-img" src="" alt="Preview" class="max-w-full max-h-48 mx-auto rounded-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block text-sm font-semibold text-gray-800 mb-2">
                            {{ __('messages.name') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="review_anonymous" name="anonymous" value="1" class="w-4 h-4 text-brown border-gray-300 rounded focus:ring-brown focus:ring-2">
                                <label for="review_anonymous" class="{{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-gray-700 cursor-pointer">
                                    {{ __('messages.post_as_anonymous') }}
                                </label>
                            </div>
                            <input type="text" id="customer_name" name="customer_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown transition-all text-gray-800 bg-white placeholder-gray-400"
                                   placeholder="{{ __('messages.enter_your_name') }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="reviewer_email" class="block text-sm font-semibold text-gray-800 mb-2">{{ __('messages.email') }} <span class="text-red-500">*</span></label>
                        <input type="email" id="reviewer_email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown focus:border-brown transition-all text-gray-800 bg-white placeholder-gray-400"
                               placeholder="{{ __('messages.your_email_address') }}">
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-4 pt-4">
                        <button type="button" id="cancel-review-form-btn" class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-all">
                            {{ __('messages.cancel_review') }}
                        </button>
                        <button type="submit" class="w-full sm:w-auto btn-brown-gradient px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ __('messages.submit_review') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reviews List -->
            <div id="reviews-list-section" class="mb-6">
                <!-- Sort Dropdown and Reviews Count -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4">
                    <!-- Reviews Count Display -->
                    @if($reviews->total() > 0)
                    @php
                        $start = $reviews->firstItem() ?? 0;
                        $end = $reviews->lastItem() ?? 0;
                        $total = $reviews->total();
                    @endphp
                    <div id="reviews-count-display" class="reviews-count-display">
                        <span class="text-gray-700 text-sm sm:text-base">
                            {{ __('messages.showing_reviews') }} <span class="font-semibold">{{ $start }}</span> {{ __('messages.to') }} <span class="font-semibold">{{ $end }}</span> {{ __('messages.of') }} <span class="font-semibold">{{ $total }}</span> {{ __('messages.reviews') }}
                        </span>
                    </div>
                    @else
                    <div id="reviews-count-display" class="reviews-count-display">
                        <span class="text-gray-700 text-sm sm:text-base">
                            {{ __('messages.no_reviews_yet') }}
                        </span>
                    </div>
                    @endif

                    <!-- Sort Dropdown -->
                    @if($reviews->total() > 0)
                    <div class="flex items-center justify-end sm:justify-start">
                        <select id="review-sort" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-brown focus:border-brown w-full sm:w-auto">
                            <option value="most-recent">{{ __('messages.most_recent') }}</option>
                            <option value="highest-rating">{{ __('messages.highest_rating') }}</option>
                            <option value="lowest-rating">{{ __('messages.lowest_rating') }}</option>
                            <option value="only-pictures">{{ __('messages.only_pictures') }}</option>
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Reviews Container - Masonry Layout -->
                <div class="jdgm-rev-widg__body">
                    <div id="reviews-list" class="jdgm-rev-widg__reviews">
                        @include('categories.partials.reviews-list', ['reviews' => $reviews])
                    </div>

                    <!-- Reviews Pagination -->
                    <div id="reviews-pagination">
                        @include('categories.partials.reviews-pagination', ['reviews' => $reviews])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Store Reviews Data for JavaScript -->
@if($totalReviews > 0)
<script>
    window.reviewsData = {
        @if(isset($allReviews))
            @foreach($allReviews as $review)
            {{ $review->id }}: {
                id: {{ $review->id }},
                name: "{{ addslashes($review->formatted_display_name ?? $review->customer_name) }}",
                rating: {{ $review->rating }},
                title: "{{ $review->review_title ? addslashes($review->review_title) : '' }}",
                text: "{{ addslashes($review->review_text) }}",
                date: "{{ $review->created_at->format('M d, Y') }}",
                media: @if($review->media)"{{ asset('storage/' . $review->media) }}"@else null @endif
            },
            @endforeach
        @else
            @foreach($reviews as $review)
            {{ $review->id }}: {
                id: {{ $review->id }},
                name: "{{ addslashes($review->formatted_display_name ?? $review->customer_name) }}",
                rating: {{ $review->rating }},
                title: "{{ $review->review_title ? addslashes($review->review_title) : '' }}",
                text: "{{ addslashes($review->review_text) }}",
                date: "{{ $review->created_at->format('M d, Y') }}",
                media: @if($review->media)"{{ asset('storage/' . $review->media) }}"@else null @endif
            },
            @endforeach
        @endif
    };
</script>
@endif

<!-- Gallery Lightbox Modal -->
@if($totalReviews > 0 && isset($allReviews) && $allReviews->whereNotNull('media')->count() > 0)
@php
    $mediaReviews = $allReviews->whereNotNull('media');
    $mediaReviewsAll = $mediaReviews->values()->all(); // Reset keys to be sequential (0, 1, 2, 3...)
@endphp
<div id="gallery-lightbox-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90 p-4">
    <div class="jm-mfp-main w-full max-w-[95vw] sm:max-w-[90vw] lg:max-w-7xl h-[90vh] sm:h-[85vh] lg:h-[85vh] flex flex-col lg:flex-row bg-white rounded-lg lg:rounded-2xl overflow-hidden shadow-2xl relative">
        <!-- Close Button -->
        <button id="close-gallery-modal" class="absolute top-2 right-2 lg:top-4 lg:right-4 text-gray-700 hover:text-gray-900 transition-colors z-10 bg-white/90 hover:bg-white rounded-full p-2 shadow-lg">
            <i class="fas fa-times text-xl lg:text-2xl"></i>
        </button>

        <!-- Main Content Wrapper -->
        <div class="jm-mfp-carousel-wrapper flex-1 flex flex-col items-center justify-center p-3 sm:p-4 lg:p-6 min-h-0 overflow-hidden">
            <!-- Main Image/Video Display -->
            <div class="jm-mfp-content-wrapper flex-1 w-full flex items-center justify-center relative min-h-0">
                <!-- Navigation Arrows -->
                @if(count($mediaReviewsAll) > 1)
                <button id="lightbox-prev" class="absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center text-brown shadow-lg transition-all z-10">
                    <i class="fas fa-chevron-left text-xl"></i>
                </button>
                <button id="lightbox-next" class="absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center text-brown shadow-lg transition-all z-10">
                    <i class="fas fa-chevron-right text-xl"></i>
                </button>
                @endif

                <div class="jm-mfp-content w-full">
                    <figure class="jm-mfp-figure w-full flex items-center justify-center">
                        <img id="lightbox-main-image" src="" alt="Review image" class="jm-mfp-img max-h-[48vh] sm:max-h-[35vh] lg:max-h-[55vh] w-full sm:w-auto object-contain rounded-lg">
                        <video id="lightbox-main-video" src="" controls class="hidden max-h-[48vh] sm:max-h-[35vh] lg:max-h-[55vh] w-full sm:w-auto object-contain rounded-lg"></video>
                    </figure>
                </div>
            </div>

            <!-- Thumbnail Carousel -->
            <div class="jm-mfp-carousel mt-10 sm:mt-3 w-full">
                <div id="gallery-thumbnails-container" class="flex flex-col items-stretch gap-3 w-full">
                    <div id="jdgm-gallery-thumbnails" class="jdgm-gallery flex items-center justify-start gap-2 sm:gap-3 overflow-x-auto pb-2 sm:pb-3 w-full px-3 sm:px-4" style="scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
                        @foreach($mediaReviewsAll as $index => $review)
                            <div class="jdgm-gallery__thumbnail-link flex-shrink-0 cursor-pointer border-2 border-transparent hover:border-brown transition-colors rounded-lg overflow-hidden {{ $index === 0 ? 'jdgm-gallery__thumbnail-link--current border-brown' : '' }}"
                                 data-media-index="{{ $index }}"
                                 data-review-id="{{ $review->id }}"
                                 data-media-url="{{ asset('storage/' . $review->media) }}">
                                <div class="jdgm-gallery__thumbnail-wrapper w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24">
                                    @if(str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v'))
                                        <video src="{{ asset('storage/' . $review->media) }}" class="jdgm-gallery__thumbnail w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $review->media) }}" alt="User picture" class="jdgm-gallery__thumbnail w-full h-full object-cover" data-mfp-src="{{ asset('storage/' . $review->media) }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Hidden container for all media reviews data -->
                    <div id="all-media-reviews-data" style="display: none;">
                        @foreach($mediaReviewsAll as $index => $review)
                            <div data-media-index="{{ $index }}"
                                 data-review-id="{{ $review->id }}"
                                 data-media-url="{{ asset('storage/' . $review->media) }}"
                                 data-is-video="{{ str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v') ? 'true' : 'false' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Sidebar -->
        <div class="jm-mfp-review-wrapper w-full lg:w-96 xl:w-[450px] bg-white overflow-y-auto max-h-[30vh] sm:max-h-[35vh] lg:max-h-none">
            <div id="lightbox-review-content" class="jdgm-rev p-3 sm:p-4 lg:p-5">
                <!-- Review content will be dynamically loaded here -->
            </div>
        </div>
    </div>
</div>
@endif

