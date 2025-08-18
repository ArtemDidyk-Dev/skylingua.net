@if ($freelancers)
    <section class="developers">
        <div class="container">
            <div class="developers__wrapper">
                <div class="developers__top">
                    <div class="developers__top-content">
                        <h2>{{ language('home_developers_title') }}</h2>
    
                    </div>
                </div>
                <div class="developers__top-arrow">
                    <div class="developers__arrow">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
                <div class="developers__inner mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($freelancers as $freelancer)
                            <x-inc.previews.developer.developer
                                photo="{{ !empty($freelancer->profile_photo)
                                    ? asset('storage/profile/' . $freelancer->profile_photo)
                                    : asset('storage/no-photo.jpg') }}"
                                alt="{{ $freelancer->name }}" name="{{ $freelancer->name }}"
                                position="{{ $freelancer->user_category_name }}"
                                countryIco="{{ $freelancer->user_country_image }}"
                                country="{{ $freelancer->user_country_name }}"
                                data="{{ $freelancer->created_at->format('d M Y') }}"
                                ratingCount="{{ $freelancer->reviews_count }}"
                                ratingStars="{{ $freelancer->average_rating }}" jobType="{{ $freelancer->time_rate }}"
                                price="{{ $freelancer->hourly_rate > 0 ? $freelancer->hourly_rate . ' ' . language('Hourly') : language('Bidding Price') }}"
                                link="{{ route('frontend.profile.index', $freelancer->id) }}" />
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
                spaceBetween: 25,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    567: {
                        slidesPerView: 2,
                    },
                    922: {
                        slidesPerView: 3,
                        spaceBetweenSlides: 25
                    },
                   
                }
            });
        </script>
    @endpush
@endif
