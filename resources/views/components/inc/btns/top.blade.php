<h2>{{ $name }}</h2>
<div class="project__item-descrip">
    <span class="project__item-price">
        <img loading="lazy" width="16" height="16" src="{{ asset('build/website/images/icons/cash.svg') }}"
            alt="price">
        Starts at {{ $price > 0 ? price_format($priceView) : language('Bidding Price') }}

    </span>
    @if($category->first())
    <span class="project__item-categor">
        <img loading="lazy" width="16" height="16"
             src="{{ asset('build/website/images/icons/categor-project.svg') }}"
             alt="Company registration services">
        {{$category->first()->user_category_name}}
    </span>
    @endif
</div>
