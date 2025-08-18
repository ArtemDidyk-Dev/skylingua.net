<section class="review">
    <div class="container">
        <h2>{{ language('frontend.home.review') }}</h2>

        <div class="review__box">
            <div class="review__arrow">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="mySwiper">
                <div class="swiper-wrapper review__wrapper">
                    @foreach ($comments as $comment)
                        <div class="swiper-slide review__item">
                            @if ($comment->image)
                                <div class="review__left">
                                    <img loading="lazy" width="160" height="250"
                                    src="{{ asset('storage/'.$comment->image) }}" alt="">
                                </div>
                            @endif
                            <div class="review__right">
                                <div class="review__star">
                                    <x-inc.previews.rating-white :ratingStars="5" />
                                    <span>5.0 rating</span>
                                </div>
                                <p class="review__content">
                                    {{ $comment->content }}
                                </p>
                                <div class="review__bottom">
                                    <span>{{ $comment->name }}</span>
                                    @if ($comment->descrip)
                                        <span>{{ $comment->descrip }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
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
