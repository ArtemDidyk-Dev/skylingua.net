<div class="breadcrumbs">
    <a href="{{ route('frontend.home.index') }}" class="breadcrumbs-item-link {{ $theme ?? '' }}">
        Home
    </a>
    @foreach ($items as $item)
        <img src="/images/icons/arrow-right.svg" alt="" class="breadcrumbs-separator {{ $theme ?? '' }}">
        @if ($loop->last)
            <div class="breadcrumbs-item {{ $theme ?? '' }}">
                {!! strip_tags($item['title']) !!}
            </div>
        @else
            <a href="{{ $item['link'] }}" class="breadcrumbs-item-link {{ $theme ?? '' }}">
                {{ strip_tags($item['title']) }}
            </a>
        @endif
    @endforeach
</div>
