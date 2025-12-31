@foreach($reviews as $review)
    <div class="jdgm-rev jdgm-divider-top review-item"
         data-rating="{{ $review->rating }}"
         data-has-media="{{ $review->media ? 'true' : 'false' }}"
         data-review-id="{{ $review->id }}">

        <!-- Review Header -->
        <div class="jdgm-rev__header">
            <div class="jdgm-row-rating">
                <span class="jdgm-rev__rating" data-score="{{ $review->rating }}" aria-label="{{ $review->rating }} star review" role="img" tabindex="0">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="jdgm-star jdgm--{{ $i <= $review->rating ? 'on' : 'off' }}">
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                        </span>
                    @endfor
                </span>
                <span class="jdgm-rev__timestamp">{{ $review->created_at->format('m/d/Y') }}</span>
            </div>

            <div class="jdgm-row-profile">
                <div class="jdgm-rev__icon">{{ strtoupper(substr($review->formatted_display_name, 0, 1)) }}</div>
                <span class="jdgm-rev__author-wrapper">
                    <span class="jdgm-rev__author">{{ $review->formatted_display_name }}</span>
                </span>
            </div>

            <div class="jdgm-row-extra">
                <span class="jdgm-rev__location"></span>
            </div>

            <div class="jdgm-rev__br"></div>
        </div>

        <!-- Review Media (Pictures) -->
        @if($review->media)
        <div class="jdgm-rev__pics">
            <a class="jdgm-rev__pic-link" href="javascript:void(0);"
               data-media-url="{{ asset('storage/' . $review->media) }}"
               data-review-id="{{ $review->id }}"
               onclick="openGalleryFromReview({{ $review->id }})">
                @if(str_contains($review->media, '.mp4') || str_contains($review->media, '.mov') || str_contains($review->media, '.m4v'))
                    <video class="jdgm-rev__pic-img" src="{{ asset('storage/' . $review->media) }}" controls></video>
                @else
                    <img class="jdgm-rev__pic-img" alt="User picture" src="{{ asset('storage/' . $review->media) }}">
                @endif
            </a>
        </div>
        @endif

        <!-- Review Content -->
        <div class="jdgm-rev__content">
            @if($review->review_title)
                <b class="jdgm-rev__title">{{ $review->review_title }}</b>
            @endif

            <div class="jdgm-rev__body">
                <p>{!! nl2br(e($review->review_text)) !!}</p>
            </div>

            <div class="jdgm-rev__custom-form"></div>
            <div class="jdgm-rev__transparency-badge-wrapper"></div>
        </div>

        <!-- Review Actions (Social Share & Voting) -->
        <div class="jdgm-rev__actions">
            <div class="jdgm-rev__social">
                <div class="jdgm-rev__social-inner">
                    <span class="jdgm-rev__share-btn jdgm-rev__share-fb" title="Facebook" data-social-media="Facebook" tabindex="0">
                        <i class="fab fa-facebook-f"></i>
                    </span>
                    <span class="jdgm-rev__share-btn jdgm-rev__share-twitter" title="Twitter" data-social-media="Twitter" tabindex="0">
                        <i class="fab fa-twitter"></i>
                    </span>
                    <span class="jdgm-rev__share-btn jdgm-rev__share-pinterest" title="Pinterest" data-social-media="Pinterest" tabindex="0">
                        <i class="fab fa-pinterest"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endforeach



