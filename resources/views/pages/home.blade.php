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
<div style="position: absolute; left: 0; right: 0; top: 0; height: 100vh; z-index: 100000; background-color: rgba(1, 1, 1, 0.7); display: none; align-items: center; justify-content: center;" id="popup-black-friday-overlay">
        <img style="height: min(90%, 618px); object-fit: contain;" src="/build/website/images/other/popup_new_may.gif" />
        
</div>
<script>
        document.body.style.overflow = 'hidden';

        const popupOverlay = document.querySelector('#popup-black-friday-overlay');
        const popupClose = document.querySelector('#popup-black-friday-close');

        popupOverlay.style.display = 'flex';

        popupOverlay.addEventListener('click', removePopup);
        popupClose.addEventListener('click', removePopup);

        function removePopup() {
                popupOverlay.style.display = 'none';
                document.body.style.overflow = 'auto';
        }
</script>

