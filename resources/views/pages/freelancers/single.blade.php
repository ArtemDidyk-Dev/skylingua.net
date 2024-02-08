<x-layout>
    <x-inc.single.layout>
        <x-slot name="breadcrumbs">
            <x-inc.breadcrumbs theme="white" :items="[
                [
                    'title' => 'Designers',
                    'link' => route('frontend.developer.index'),
                ],
                [
                    'title' => $user->name,
                ],
            ]" />
        </x-slot>
        <x-slot name="profileLeft">
            <x-inc.single.freelancer.profile name="{{ $user->name }}" category="{{ $user->user_category_name }}"
                profileLink="{{ $user->user_profile_link }}  " rate="{{ $user->hourly_rate }}"
                proflieImg="{{ $user->profile_photo }}" id="{{ $user->id }}"  rating="{{ $average_rating }}" ratingCount="{{ $reviews_count }}" 
                data="{{ $user->created_at->format('d M Y') }}"
                geo="{{ $user->user_country_name }}"
                gender="{{ $user->gender == 1 ? language('Male') : language('Famele') }}"
                />
        </x-slot>
        <x-slot name="profiledescription">
            <x-inc.single.freelancer.details data="{{ $user->created_at->format('d M Y') }}"
                geo="{{ $user->user_country_name }}" geoImg="{{ $user->user_country_image }}"
                gender="{{ $user->gender == 1 ? language('Male') : language('Famele') }}"
                rating="{{ $average_rating }}" ratingCount="{{ $reviews_count }}" id="{{ $user->id }}"
                favourites="{{ $user->favourites }}" />
        </x-slot>
        <x-slot name="overview">
            <x-inc.single.freelancer.overview description="{!! $user->description !!}" />
        </x-slot>
        <x-slot name="about">
            <x-inc.single.freelancer.portfolio :portfolios="$portfolios" />
            <x-inc.single.freelancer.reviews :reviews="$reviews" />
        </x-slot>
        <x-slot name="modal">
            <x-inc.single.freelancer.model id="{{ $user->id }}" :projectslist="$projects_list" />
        </x-slot>
    </x-inc.single.layout>


    @push('meta')
        <title>{{ $user->name . ' - Freelancer' }}</title>
        <meta name="description" content="{{ language('frontend.developer.description') }}">
        <meta name="keywords" content="{{ language('frontend.developer.keywords') }}">
    @endPush

</x-layout>
