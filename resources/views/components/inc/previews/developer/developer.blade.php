<div class="developers__item swiper-slide">
    <div class="developers__box">
        <x-inc.previews.developer.user :photo="$photo" :name="$name" :position="$position" :countryIco="$countryIco" />
        <x-inc.previews.developer.body :price="$price" :ratingStars="$ratingStars" :ratingCount="$ratingCount" :jobType="$jobType"
            :countryIco="$countryIco" :country="$country" :data="$data" />
        <x-inc.previews.footer :link="$link" />
    </div>
</div>
