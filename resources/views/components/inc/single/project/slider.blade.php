<section class="project-carulse">
    <div class="container">
        <h2>{{ language('frontend.project.slider') }}</h2>
        <div class="project-carulse__box">
            <div class="review__arrow">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="mySwiper" style="overflow: hidden">
                <div class="swiper-wrapper project__wrapper-carulse">
                    @foreach ($projects as $project)
                        <a href="{{ route('frontend.project.detail', $project['id']) }}"
                            class="swiper-slide project__item slider">
                            <div class="project__item-slider">
                                <div class="project__item-top">
                                    <div class="project__top-item">
                                        <img width="16" height="16"
                                            src="{{ asset('build/website/images/icons/owner.svg') }}"
                                            alt="{{ $project['user_name'] }}">
                                        <span>Project Owner: {{ $project['user_name'] }}</span>
                                    </div>
                                    <div class="project__top-item">
                                        <img width="16" height="16"
                                            src="{{ asset('build/website/images/icons/time.svg') }}"
                                            alt="{{ $project['created_at_view'] }}">
                                        <span>{{ $project['created_at_view'] }}</span>
                                    </div>
                                </div>
                                <h4>{{ $project['name'] }}</h4>
                                <div class="project__item-descrip">
                                    <span class="project__item-price">
                                        <img loading="lazy" width="16" height="16"
                                            src="{{ asset('build/website/images/icons/cash.svg') }}" alt="price">
                                        Starts at
                                        {{ $project['price'] ?? language('Bidding Price') }}

                                    </span>
                                    @if (!empty($project['user_category_name']))
                                        <span class="project__item-categor">
                                            <img loading="lazy" width="16" height="16"
                                                src="{{ asset('build/website/images/icons/categor-project.svg') }}"
                                                alt=" {{ $project['user_category_namet'] }}">
                                            {{ $project['user_category_name'] }}
                                        </span>
                                    @endif
                                </div>
                                <p> {!! str_limit(strip_tags(html_entity_decode($project['description'])), $limit = 230, $end = '...') !!}</p>
                            </div>
                        </a>
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
