<div class="preview-user">
    <div class="preview-user__wrapper">
        <img width="80" height="80" loading="lazy" src="{{ $photo }}" alt="{{ $name }}"
             class="preview-user__photo">
        <div class="preview-user__right">
            <span> {{ $name }}</span>
        </div>
    </div>
    <div class="project__item-bottom single">
        <div class="project__item-right">
            <div class="project__item-right-item">
                <img loading="lazy" width="16" height="16"
                     src="{{ asset('build/website/images/icons/star.svg') }}" alt="star">
                <span>{{$rating ?? 0}}  ({{$ratingCount ?? 0}})</span>
            </div>
            <div class="project__item-right-item">
                <img width="16" height="16" src="{{ asset('build/website/images/icons/time.svg') }}" alt="{{$created}}" >
                <span>{{ $created ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>
