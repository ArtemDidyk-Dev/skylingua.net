@if($name)
    <h2>{{$name}}</h2>
@endif
<div class="project__item-descrip">
    <span class="project__item-price">
        <img loading="lazy" width="16" height="16" src="{{ asset('build/website/images/icons/cash.svg') }}"
             alt="price">
        Starts at {{ $price}}

    </span>
    @if($category)
        <span class="project__item-categor">
        <img loading="lazy" width="16" height="16"
             src="{{ asset('build/website/images/icons/categor-project.svg') }}"
             alt="{{$category}}">
        {{$category}}
    </span>
    @endif
</div>
