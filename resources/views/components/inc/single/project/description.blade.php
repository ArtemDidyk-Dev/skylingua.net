<div class="single-project-description">
    <div class="single-project-description-text">
        <div class="single-project-description-title">
            {!! $name !!}
        </div>
        <div class="single-project-description-subtitle">
            <img class="single-project-description-subtitle-icon" src="/images/icons/clock.svg" alt="{{ $createdAtView }}">
            {{ $createdAtView }}
        </div>
    </div>

    <div class="single-project-description-tags">
        @if ($price > 0)
            <x-inc.single.tag title="{{ $price }}{{ language('frontend.currency') }}" />
        @endif
        <x-inc.single.tag title="{{ $priceType }}" />
    </div>
    <div class="single-layout__line"></div>
</div>
