<x-layout>
    <x-inc.home.search />
    <x-inc.home.categories  />
    <x-inc.home.banner />
    <x-inc.home.catalog :freelancers="$freelancers" />
    <x-inc.home.posts :blogs="$blogs" />
    <x-inc.home.faq :faq="$faq" />
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
