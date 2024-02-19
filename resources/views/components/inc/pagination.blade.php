@if ($paginator->hasPages())
    <div class="filter-btn">
        @if ($paginator->nextPageUrl())
            <x-inc.btns.all color="blue" title="{{ language('Show more') }}" link="{{ $paginator->nextPageUrl() }}" >
            </x-inc.btns.all>
        @endif
    </div>
    <div class="pagination">
        @if ($paginator->previousPageUrl())
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-left">
                <img src="/images/icons/arrow-right.svg" alt="" class="pagination-left-img">
            </a>
        @endif

        <div class="pagination-pages">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-item disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <a href="{{ $url }}"
                            class="pagination-item {{ $page == $paginator->currentPage() ? 'active' : '' }} {{ $page == '...' ? 'disabled' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                @endif
            @endforeach
        </div>
        @if ($paginator->nextPageUrl())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-right">
                <img src="/images/icons/arrow-right.svg" alt="" class="pagination-right-img">
            </a>
        @endif
    </div>
@endif

{{-- @push('css')
    <style>
        .pagination-right,
        .pagination-left {
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination-right-img,
        .pagination-left-img {
            width: 20px;
        }

        .pagination-left-img {
            transform: rotate(180deg);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination-pages {
            display: flex;
            justify-content: center;
        }

        .pagination-item {
            background-color: #F5F5F5;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 32px;
            height: 32px;
            text-decoration: none;
            margin: 0 12.5px;
            font-size: 15px;
            transition: 0.3s;
        }

        .pagination-item.disabled {
            pointer-events: none;
        }

        .pagination-item:hover,
        .pagination-item.active {
            background-color: var(--color-blue);
            color: var(--color-white);
        }
        .filter-btn {
            margin-bottom: 25px;
        }
    </style>
@endPush --}}
