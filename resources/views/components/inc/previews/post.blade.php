<div class="posts__item">
    <img src="{{ asset($photo) }}" alt="" class="posts__item-img" loading="lazy">
    <div class="posts__item-body">
        <div class="posts__item-data">
            <img width="16" height="16" src="{{ asset('build/website/images/icons/time.svg') }}" alt="{{$data}}" >
			{{$data}}
        </div>
        <a href="{{ $link }}" class="posts__item-title">
            {!! $title !!}
        </a>
        <p class="posts__item-escription">
            {!! $description !!}
        </p>
    </div>
</div>
