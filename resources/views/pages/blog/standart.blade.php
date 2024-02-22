<x-layout>
    <div class="container">
        <x-inc.breadcrumbs :items="$breadcrumbs" />
        <div class="blog">

            <div class="content">
                <x-inc.standart.image-content
                    src="{{ !empty($page->image) ? \App\Services\ImageService::resizeImageSize($page->image, 'large', 80) : '' }}"
                    alt="{{$page->name}}" />
                <div class="content__block">
                    <div class="content__block-top">
                        <div class="posts__item-data">
                            <img width="16" height="16" src="{{ asset('build/website/images/icons/time.svg') }}" alt="{{$data}}" >
                            {{$data}}
                        </div>
                    </div>
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
    @push('meta')
        <title>{{ $title }}</title>
        <meta name="description" content="{{ $decription }}">
        <meta name="keywords" content="{{ $keywords }}">
    @endPush


</x-layout>
