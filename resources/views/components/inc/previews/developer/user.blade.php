<div class="project__item-top">
    <div class="project__top-item">
        <img width="16" height="16" src="{{ asset('build/website/images/icons/owner.svg') }}" alt="{{$name}}" >
        <span>Project Owner: {{$name}}</span>
    </div>
    @if(!empty($category))
        <div class="project__top-item">
            <span>{{$category}}</span>
        </div>
    @endif
</div>
