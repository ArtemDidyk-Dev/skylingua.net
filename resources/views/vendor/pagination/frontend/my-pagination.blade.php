@if ($paginator->hasPages())

    <!-- pagination start -->
    <div class="basic-pagination text-center">
        <nav>
            <ul>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span>
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    </li>
                    <li>
                        <span>
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url(1) }}">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </a>
                    </li>
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
                                <li>
                                    <span class="current">{{ $page }}</span>
                                </li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}">
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $paginator->url($page) }}">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li>
                        <span>
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </span>
                    </li>
                    <li>
                        <span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <!-- pagination end -->


@endif
