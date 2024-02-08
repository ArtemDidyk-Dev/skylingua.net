@if ($paginator->hasPages())

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1 disabled"
                   disabled
                        aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <i class="ki ki-bold-double-arrow-back icon-xs"></i>
                </a>

                <a class="btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1 disabled"
                   disabled
                        aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <i class="ki ki-bold-arrow-back icon-xs"></i>
                </a>
            @else
                <a class="page-link btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1"
                    href="{{ $paginator->url(1) }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <i class="ki ki-bold-double-arrow-back icon-xs"></i>
                </a>

                <a class="page-link btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1"
                    href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <i class="ki ki-bold-arrow-back icon-xs"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <div class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></div>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <!--  Aktiv Link  -->
                            <a href="#" class="btn btn-circle btn-icon btn-sm border-0 btn-hover-success active mr-2 my-1">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="btn btn-circle btn-icon btn-sm border-0 btn-hover-success mr-2 my-1">{{ $page }}</a>

                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="page-link btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1"
                   href="{{ $paginator->nextPageUrl() }}" rel="prev" aria-label="@lang('pagination.next')">
                    <i class="ki ki-bold-arrow-next icon-xs"></i>
                </a>

                <a class="page-link btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1"
                   href="{{ $paginator->url($page) }}" rel="prev" aria-label="@lang('pagination.next')">
                    <i class="ki ki-bold-double-arrow-next icon-xs"></i>
                </a>
            @else

                <a class="btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1 disabled"
                   disabled
                   aria-disabled="true" aria-label="@lang('pagination.next')">
                    <i class="ki ki-bold-arrow-next icon-xs"></i>
                </a>

                <a class="btn btn-circle btn-icon btn-sm btn-light-success mr-2 my-1 disabled"
                   disabled
                   aria-disabled="true" aria-label="@lang('pagination.next')">
                    <i class="ki ki-bold-double-arrow-next icon-xs"></i>
                </a>
            @endif

@endif
