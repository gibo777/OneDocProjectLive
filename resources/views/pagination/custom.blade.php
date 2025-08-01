@if ($paginator->hasPages())
    <style type="text/css">
        .pagination-link {
            color: #1E69CD;
            /*font-weight: 500;*/
        }

        .pagination-link:hover {
            color: #0056b3;
            text-decoration: underline;
            background: linear-gradient(to bottom, #EAF4FD, #B0D2F8);
            cursor: pointer;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center">
        <div class="mx-2">Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of
            {{ $paginator->total() }} entries</div>
        <nav class="text-sm">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link font-weight-bold" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link pagination-link font-weight-bold" wire:click="previousPage" rel="prev"
                            aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span
                                class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array of links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link pagination-link"
                                        wire:click="gotoPage({{ $page }})"
                                        href="javascript:void(0);">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link pagination-link font-weight-bold" wire:click="nextPage" rel="next"
                            aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link font-weight-bold" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
