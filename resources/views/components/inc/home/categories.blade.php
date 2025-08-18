@php
    $firstIndex = 1;
    $centerIndex = 2;
@endphp

<section class="categories">
    <div class="container">
        <h2>{{ language('categories.home.title') }}</h2>
        <div class="categories__wrapper">
            @foreach ($categoryes as $category)
                @if ($loop->iteration == $firstIndex)
                    <div class="categories__item first">
                    @php
                        $firstIndex += 3;
                    @endphp
                @elseif($loop->iteration == $centerIndex)
                    <div class="categories__item center">
                    @php
                        $centerIndex += 3;
                    @endphp
                @else
                    <div class="categories__item">
                @endif
                    <img loading="lazy" width="44" height="44"
                        src="{{ !empty($category->userCategory->first()->image) ? $category->userCategory->first()->image : asset('build/website/images/icons/categories.svg') }}" alt=""
                        class="categories__item-img">
                    <span>{{ $category->name  }}</span>
                    @if ($category->text)
                        <p>{!! $category->text !!} </p>
                    @endif
                    <a href="{{ route('frontend.developer.index', ['user_category' => $category->user_category_id]) }}">
                        {{ language('learnmore') }}
                    </a>
                </div>

            @endforeach
        </div>
    </div>
</section>
