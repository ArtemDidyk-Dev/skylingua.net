<x-layout>
    <div class="container">
        <x-inc.breadcrumbs :items="$breadcrumbs" />
        <div class="standart-content {{ $with ?? '' }}">
            <h1>
                {{ $h1 }}
            </h1>
            <div class="content">
                <x-inc.standart.image-content src="{{ !empty($page->image) ? $page->image : '' }}"
                    alt="{{ $page->name }}" />
                {!! $content !!}
            </div>
        </div>
    </div>


    @push('meta')
        <title>{{ $title }}</title>
        <meta name="description" content="{{ $decription }}">
        <meta name="keywords" content="{{ $keywords }}">
    @endPush


</x-layout>
