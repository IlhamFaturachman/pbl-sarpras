@props(['paginator'])

@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            {{-- Tampilkan tombol panah hanya jika lebih dari 1 halaman --}}
            @if ($paginator->lastPage() > 1)
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
            @endif

            {{-- Pagination Numbers --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Tampilkan tombol panah hanya jika lebih dari 1 halaman --}}
            @if ($paginator->lastPage() > 1)
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
            @endif
        </ul>
    </nav>
@endif