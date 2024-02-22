@if($subTitle )
    <h4>{{ $subTitle }}</h4>
@endif
<div class="project__item-descrip">
    <img class="project__item-author" width="60" height="60" src="{{ $photo }}" alt="{{ $name }}" >

    <span class="project__item-price">
        <img loading="lazy" width="16" height="16" src="{{ asset('build/website/images/icons/cash.svg') }}"
             alt="price">
        Starts at {{$price }}

    </span>
    @if (!empty($category))
        <span class="project__item-categor">
            <img loading="lazy" width="16" height="16"
                 src="{{ asset('build/website/images/icons/categor-project.svg') }}"
                 alt=" {{ $category }}">
            {{ $category }}
        </span>
    @endif
</div>
<p>  {!!  str_limit(strip_tags(html_entity_decode($content)), $limit = 230, $end = '...') !!}</p>
