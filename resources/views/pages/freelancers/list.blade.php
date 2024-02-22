<x-layout>

    <section class="filter">
        <div class="container">
            <x-inc.breadcrumbs :items="[
                [
                    'title' => 'Services',
                    'link' => '/',
                ],
            ]" />
            @if ($freelancers->currentPage() == 1 && $freelancers->total() > 0)
                {!! language('seo.freelancers.text') !!}
            @endif
            <div class="filter__wrapper">
                <div class="filter__left">
                    <x-inc.filter.filters route="{{ route('frontend.developer.index') }}"
                                          :filter="$filter" :selectCategories="$userCategories" :minMaxPrice="$freelancersMinMaxPrice"
                                          action="{{ route('frontend.developer.index') }}" />
                </div>
                <div class="filter__right">
                    @if ($freelancers && $freelancers->total() > 0)
                    <div class="filter__right-wrapper">
                        @foreach ($freelancers as $freelancer)
                            <x-inc.previews.developer.developer
                            photo="{{ !empty($freelancer->profile_photo)
                                    ? asset('storage/profile/' . $freelancer->profile_photo)
                                    : asset('storage/no-photo.jpg') }}"
                            name="{{ $freelancer->name }}"
                            subTitle="{{ $freelancer->sub_title }}"
                            position="{{ $freelancer->user_category_name ? $freelancer->user_category_name : '' }}"
                            content="{!!$freelancer->description !!}"
                            data="{{ $freelancer->created_at_view }}"
                            price="{{ $freelancer->hourly_rate > 0 ? $freelancer->hourly_rate . ' ' . language('frontend.currency') . ' ' . language('Hourly') : language('Bidding Price') }}"
                            link="{{ route('frontend.profile.index', $freelancer->id) }}" />
                        @endforeach
                    </div>
                    {{ $freelancers->appends(['search' => isset($searchText) ? $searchText : null])->render('components.inc.pagination') }}
                    @else
                        <p class="no-result">{{ language('Not result...') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>


    @push('meta')
        <title>
            {{ empty(language('frontend.developer.title')) ? language('frontend.developer.name') : language('frontend.developer.title')  }}
        </title>

        <meta name="description" content="{{ language('frontend.developer.description') }}">
        <meta name="keywords" content="{{ language('frontend.developer.keywords') }}">
        <script src="/js/nouislider.min.js"></script>
    @endPush



</x-layout>
