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
                    @foreach ($freelancers as $freelancer)
                        <a href="{{ route('frontend.profile.index', $freelancer->id) }}"
                           class="swiper-slide project__item slider">
                            <div class="project__item-top">
                                <div class="project__top-item">
                                    <img width="16" height="16"
                                         src="{{ asset('build/website/images/icons/owner.svg') }}"
                                         alt="{{ $freelancer['user_name'] }}">
                                    <span> {{ $freelancer['name'] }}</span>
                                </div>
                                @if(!empty($freelancer['user_category_name']))
                                    <div class="project__top-item">
                                        <span>{{$freelancer['user_category_name']}}</span>
                                    </div>
                                @endif
                            </div>
                            @if($freelancer['sub_title'])
                                <h4>{{$freelancer['sub_title']}}</h4>
                            @endif
                            <div class="project__item-descrip">
                                <img class="project__item-author" width="60" height="60" src="{{ !empty($freelancer->profile_photo) ? asset('storage/profile/' . $freelancer->profile_photo): asset('storage/no-photo.jpg') }}" alt="{{ $freelancer['user_name'] }}" >


                                <span class="project__item-price">
                                    <span class="project__item-currency">€</span>
                                    Starts at {{ $freelancer->hourly_rate > 0 ? $freelancer->hourly_rate . ' ' . language('Hourly') : language('Bidding Price') }}

                                </span>
                                @if(!empty($freelancer['user_category_name']))
                                    <span class="project__item-categor">
                                    <img loading="lazy" width="16" height="16"
                                         src="{{ asset('build/website/images/icons/categor-project.svg') }}"
                                         alt=" {{$freelancer['project_categories_first']}}">
                                        {{$freelancer['user_category_name']}}
                                     </span>
                                @endif
                            </div>
                            <p> {!!  str_limit(strip_tags(html_entity_decode($freelancer['description'])), $limit = 230, $end = '...') !!}</p>
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
