@if ($paginator->hasPages())

    <ul class="paginations">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span> <i class="fas fa-angle-left"></i> Previous</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}"> <i class="fas fa-angle-left"></i> Previous</a></li>
        @endif


        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <!--  Aktiv Link  -->
                        <li><span  class="active">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">Next <i class="fas fa-angle-right"></i></a></li>
        @else
            <li><span>Next <i class="fas fa-angle-right"></i></span></li>
        @endif
    </ul>
    <!-- pagination end -->


@endif
