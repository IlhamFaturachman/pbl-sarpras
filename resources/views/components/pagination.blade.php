@props(['paginator'])

@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $maxPagesToShow = 3; 
        
        // Hitung start dan end page
        if ($lastPage <= $maxPagesToShow) {
            $startPage = 1;
            $endPage = $lastPage;
        } else {
            $half = floor($maxPagesToShow / 2);
            
            if ($currentPage <= $half) {
                $startPage = 1;
                $endPage = $maxPagesToShow;
            } elseif ($currentPage > ($lastPage - $half)) {
                $startPage = $lastPage - $maxPagesToShow + 1;
                $endPage = $lastPage;
            } else {
                $startPage = $currentPage - $half;
                $endPage = $currentPage + $half;
            }
        }
    @endphp

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item prev disabled">
                    <a class="page-link" href="javascript:void(0);">
                        <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                    </a>
                </li>
            @else
                <li class="page-item prev">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                    </a>
                </li>
            @endif

            {{-- First page jika tidak termasuk dalam range --}}
            @if ($startPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>
                @if ($startPage > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            {{-- Pagination Numbers --}}
            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Last page jika tidak termasuk dalam range --}}
            @if ($endPage < $lastPage)
                @if ($endPage < $lastPage - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                        <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                    </a>
                </li>
            @else
                <li class="page-item next disabled">
                    <a class="page-link" href="javascript:void(0);">
                        <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif