@if($reviews->hasPages())
<div class="reviews-pagination-wrapper mt-8 flex justify-center">
    <nav class="reviews-pagination" aria-label="Reviews pagination">
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($reviews->onFirstPage())
                <li class="pagination-item pagination-item-disabled">
                    <span class="pagination-link pagination-link-prev">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="pagination-item">
                    <a href="{{ $reviews->previousPageUrl() }}" class="pagination-link pagination-link-prev" data-page="{{ $reviews->currentPage() - 1 }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $currentPage = $reviews->currentPage();
                $lastPage = $reviews->lastPage();
                $startPage = max(1, $currentPage - 2);
                $endPage = min($lastPage, $currentPage + 2);
            @endphp

            @if ($startPage > 1)
                <li class="pagination-item">
                    <a href="{{ $reviews->url(1) }}" class="pagination-link pagination-link-number" data-page="1">1</a>
                </li>
                @if ($startPage > 2)
                    <li class="pagination-item pagination-item-ellipsis">
                        <span class="pagination-link">...</span>
                    </li>
                @endif
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page == $currentPage)
                    <li class="pagination-item pagination-item-active">
                        <span class="pagination-link pagination-link-number">{{ $page }}</span>
                    </li>
                @else
                    <li class="pagination-item">
                        <a href="{{ $reviews->url($page) }}" class="pagination-link pagination-link-number" data-page="{{ $page }}">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endfor

            @if ($endPage < $lastPage)
                @if ($endPage < $lastPage - 1)
                    <li class="pagination-item pagination-item-ellipsis">
                        <span class="pagination-link">...</span>
                    </li>
                @endif
                <li class="pagination-item">
                    <a href="{{ $reviews->url($lastPage) }}" class="pagination-link pagination-link-number" data-page="{{ $lastPage }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($reviews->hasMorePages())
                <li class="pagination-item">
                    <a href="{{ $reviews->nextPageUrl() }}" class="pagination-link pagination-link-next" data-page="{{ $reviews->currentPage() + 1 }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="pagination-item pagination-item-disabled">
                    <span class="pagination-link pagination-link-next">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif

