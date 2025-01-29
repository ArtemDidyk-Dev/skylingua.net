<x-layout>
    <x-inc.single.layout>
        <x-slot name="breadcrumbs">
            <x-inc.breadcrumbs theme="white" :items="[
                [
                    'title' => 'Teachers',
                    'link' => route('frontend.developer.index'),
                ],
                [
                    'title' => $user->sub_title ?? $user->user_category_name,
                ],
            ]"/>
        </x-slot>

        <x-slot name="profileTop">
            <x-inc.single.freelancer.top
                name="{{$user->sub_title}}"
                category="{{$user->user_category_name}}"
                price="{{ $user->hourly_rate > 0 ? $user->hourly_rate . ' ' . language('frontend.currency') . ' ' . language('Hourly') : language('Bidding Price') }}"
            />
        </x-slot>

        <x-slot name="profileLeft">

            <x-inc.single.freelancer.description
                photo="{{$user->profile_photo}}"
                name="{{$user->name}}"
                created="{{$user->created_at_view}}"
                rating="{{$user->review_rating ?? 0}}"
                ratingCount="{{$user->review_count ?? 0}}"
            />
        </x-slot>
        <x-slot name="profiledescription">
            <x-inc.single.freelancer.details
                :user="$user"
                role="{{$hasRoleEmployer}}"
                favourites="{{$user->favourites}}"
                id="{{ $user->id }}"
                isSubscribed="{{$isSubscribed}}"
                isAuthor="{{$isAuthor}}"
            />
            <x-inc.single.freelancer.review-form toId="{{$user->id}}"/>
        </x-slot>

        <x-slot name="overview">
            <x-inc.single.freelancer.overview
                content="{!! $user->description !!}"
            />
        </x-slot>
        <x-slot name="about">
            <x-inc.single.freelancer.portfolio :portfolios="$portfolios"/>
            <div class="single-freelancer-review__wrapper">
                <div class="single-freelancer-review__tabs">
                    <span class="active" data-tabs="course">Courses</span>
                    <span data-tabs="review">Reviews</span>
                </div>
                <div class="single-freelancer-review__content">
                    <div class="single-freelancer-review__box active" data-tabs="course">
                        @forelse($courses as $course)
                            <div class="course__item">
                                <div class="course__item-top">
                                    <div class="course__item-author">
                                        <img width="50" height="50" src="{{$user->profile_photo}}"
                                             alt="{{$user->name}}">
                                    </div>
                                    <div class="course__item-author-description">
                                        <span>{{$user->name}}</span>
                                        <p>{{ $course->dataFormat}}</p>
                                    </div>
                                </div>
                                @if($course->show || $isAuthor)
                                    <div class="course__item-content">
                                        <h3>{{$course->name}}</h3>
                                        <div class="course__item-text">
                                            {!! $course->description !!}
                                        </div>
                                        @if( $course->files)
                                            <div class="course__item-files">
                                                @foreach($course->files as $file)
                                                    <div class="course__files-item">
                                                        <img src="{{$file->promo}}" alt="{{$file->name}}">
                                                        @if($file->type != 'image')
                                                            <a href="{{$file->path}}">
                                                                <svg width="16" height="16" viewBox="0 0 16 16"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M14.6708 9.23242C14.1588 9.23242 13.7428 9.64842 13.7428 10.1604V12.8004H2.23881V10.1604C2.23881 9.64842 1.82281 9.23242 1.31081 9.23242C0.798811 9.23242 0.382812 9.64842 0.382812 10.1604V13.7124C0.382812 14.2244 0.798811 14.6404 1.31081 14.6404H14.6708C15.1828 14.6404 15.5988 14.2244 15.5988 13.7124V10.1604C15.5988 9.64842 15.1828 9.23242 14.6708 9.23242Z"
                                                                        fill="#0F0F34"/>
                                                                    <path
                                                                        d="M7.35876 11.0404C7.53476 11.2164 7.77475 11.3124 8.01475 11.3124C8.25475 11.3124 8.49476 11.2164 8.67076 11.0404L11.4228 8.28835C11.7908 7.92035 11.7908 7.34435 11.4228 6.97635C11.0548 6.60835 10.4788 6.60835 10.1108 6.97635L8.94276 8.14436V2.28835C8.94276 1.77635 8.52675 1.36035 8.01475 1.36035C7.50275 1.36035 7.08675 1.77635 7.08675 2.28835V8.17635L5.88675 6.97635C5.51875 6.60835 4.94275 6.60835 4.57475 6.97635C4.20675 7.34435 4.20675 7.92035 4.57475 8.28835L7.35876 11.0404Z"
                                                                        fill="#0F0F34"/>
                                                                </svg>
                                                                Download
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="course__item-content no-available">
                                        <div class="course__item-no-available">
                                            <h3>{{$course->name}}</h3>
                                            <div class="course__item-text">
                                                {!! $course->short !!}
                                            </div>
                                            <div class="course__item-available-show">
                                                <img height="280" width="734" src="{{$course->promo_img ?: '/images/promo/look-bay.png'}}">
                                                <a href="{{$course->linkPay['link']}}">{{$course->linkPay['text']}}</a>
                                            </div>


                                        </div>
                                    </div>
                                @endif
                            </div>

                        @empty
                            <p>Sorry, but there are no courses available in the {{$user->name}}.</p>
                        @endforelse
                    </div>
                    <div class="single-freelancer-review__box" data-tabs="review">
                        <x-inc.single.freelancer.reviews :reviews="$reviews"/>
                    </div>
                </div>
            </div>

        </x-slot>
        <x-slot name="modal">
            <x-inc.single.freelancer.model
                price="{{ $user->hourly_rate > 0 ? $user->hourly_rate . ' ' . language('frontend.currency') . ' ' . language('Hourly') : language('Bidding Price') }}"
                id="{{ $user->id }}"
                link="{{auth()->check() ? route('frontend.dashboard.create-chat', $user->id) : route('frontend.registration.employer') }}"/>
            <x-inc.single.freelancer.model-chat
                id="{{ $user->id }}"
                link="{{auth()->check() ? route('frontend.dashboard.create-chat', $user->id) : route('frontend.registration.employer') }}"
            />
        </x-slot>


        <x-slot name="projects">
            <x-inc.single.freelancer.slider
                :freelancers="$freelancers"
            />
        </x-slot>
    </x-inc.single.layout>


    @push('meta')
        <title>{{ $user->name . ' - Freelancer' }}</title>
        <meta name="description" content="{{ language('frontend.developer.description') }}">
        <meta name="keywords" content="{{ language('frontend.developer.keywords') }}">
        <link rel="stylesheet" href="/css/swiper-bundle.min.css"/>
        <script src="/js/swiper-bundle.min.js"></script>
    @endPush

</x-layout>
