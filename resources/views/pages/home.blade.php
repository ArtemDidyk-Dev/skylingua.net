<x-layout>

    <x-inc.home.search />
    <x-inc.home.categories :categories="$categories" />
    <x-inc.home.banner />
    <x-inc.home.projects :categories="$categories" />
    <x-inc.home.reviews />
    <x-inc.home.faq />
    <x-inc.home.banner-join />
    @push('meta')
        <title>
            {{ empty(language('frontend.home.title')) ? language('frontend.home.home') : language('frontend.home.title') }}
        </title>
        <meta name="description" content="{{ language('frontend.home.description') }}">
        <meta name="keywords" content="{{ language('frontend.home.keyword') }}">
        <link rel="stylesheet" href="/css/swiper-bundle.min.css" />
        <script src="/js/swiper-bundle.min.js"></script>
    @endPush


</x-layout>
