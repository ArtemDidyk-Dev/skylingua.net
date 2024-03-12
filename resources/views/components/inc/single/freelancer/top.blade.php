@if($name)
    <h2>{{$name}}</h2>
@endif
<div class="project__item-descrip">
    <span class="project__item-price">
       <span class="project__item-currency">€</span>
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
