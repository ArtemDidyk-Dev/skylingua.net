<h4>{{ $name }}</h4>
<div class="project__item-descrip">
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