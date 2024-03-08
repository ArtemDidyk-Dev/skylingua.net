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
            />
            <x-inc.single.freelancer.review-form toId="{{$user->id}}" />
        </x-slot>

        <x-slot name="overview">
            <x-inc.single.freelancer.overview
                content="{!! $user->description !!}"
            />
        </x-slot>
        <x-slot name="about">
            <x-inc.single.freelancer.portfolio :portfolios="$portfolios"/>
            <x-inc.single.freelancer.reviews :reviews="$reviews"/>
        </x-slot>
        <x-slot name="modal">
            <x-inc.single.freelancer.model
            price="{{ $user->hourly_rate > 0 ? $user->hourly_rate . ' ' . language('frontend.currency') . ' ' . language('Hourly') : language('Bidding Price') }}"
                id="{{ $user->id }}"
                link="{{auth()->check() ? route('frontend.dashboard.create-chat', $user->id) : route('frontend.registration.employer') }}" />
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
        <link rel="stylesheet" href="/css/swiper-bundle.min.css" />
        <script src="/js/swiper-bundle.min.js"></script>
    @endPush

</x-layout>
