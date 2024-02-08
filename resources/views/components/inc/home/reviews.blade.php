<section class="review">
    <div class="container">
        <h2>Our happy clients talk about us</h2>
        
        <div class="review__box">
            <div class="review__arrow">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="mySwiper">
                <div class="swiper-wrapper review__wrapper">
                    <div class="swiper-slide review__item">
                        <div class="review__left">
                            <img loading="lazy" width="160" height="250"
                                src="{{ asset('build/website/images/other/review.png') }}" alt="">
                        </div>
                        <div class="review__right">
                            <div class="review__star">
                                <x-inc.previews.rating-white :ratingStars="5" />
                                <span>5.0 rating</span>
                            </div>
                            <p class="review__content">
                                My vision came alive effortlessly. Their blend
                                of casual and professional approach made the process a breeze. Creativity flowed, and
                                the
                                results were beyond my expectations.
                            </p>
                            <div class="review__bottom">
                                <span>Jenny Wilson</span>
                                <span>Grower.io</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide review__item">
                        <div class="review__left">
                            <img loading="lazy" width="160" height="250"
                                src="{{ asset('build/website/images/other/review.png') }}" alt="">
                        </div>
                        <div class="review__right">
                            <div class="review__star">
                                <x-inc.previews.rating-white :ratingStars="5" />
                            </div>
                            <p class="review__content">
                                My vision came alive effortlessly. Their blend
                                of casual and professional approach made the process a breeze. Creativity flowed, and
                                the
                                results were beyond my expectations.
                            </p>
                            <div class="review__bottom">
                                <span>Jenny Wilson</span>
                                <span>Grower.io</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide review__item">
                        <div class="review__left">
                            <img loading="lazy" width="160" height="250"
                                src="{{ asset('build/website/images/other/review.png') }}" alt="">
                        </div>
                        <div class="review__right">
                            <div class="review__star">
                                <x-inc.previews.rating-white :ratingStars="5" />
                            </div>
                            <p class="review__content">
                                My vision came alive effortlessly. Their blend
                                of casual and professional approach made the process a breeze. Creativity flowed, and
                                the
                                results were beyond my expectations.
                            </p>
                            <div class="review__bottom">
                                <span>Jenny Wilson</span>
                                <span>Grower.io</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
@push('js')
    <script>
        let swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 65,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                992: {
                    spaceBetween: 25,
                    slidesPerView: 2,
                },
                1200: {
                    spaceBetweenSlides: 25,
                    slidesPerView: 2,
                },

            }
        });
    </script>
@endpush
