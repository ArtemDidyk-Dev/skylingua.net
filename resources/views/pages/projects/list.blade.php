<x-layout>
    <section class="filter">
        <div class="container">
            <x-inc.breadcrumbs :items="[
        [
            'title' => 'Services',
            'link' => '/',
        ],
        ]" />
            @if ($getProjects->currentPage() == 1 && $getProjects->total() > 0)
                {!! language('seo.projects.text') !!}
            @endif
            <div class="filter__wrapper">
                <div class="filter__left">
                    <x-inc.filter.filters route="{{ route('frontend.project.index') }}"
                        :filter="$filter" :selectCategories="$categories" :minMaxPrice="$getProjectsMinMaxPrice"
                        action="{{ route('frontend.project.index') }}" />
                </div>

                <div class="filter__right">
                    @if ($getProjects && $getProjects->total() > 0)
                    <div class="filter__right-wrapper">
                        @foreach ($projects as $project)
                            <x-inc.previews.project.project
                                image="{{$project['image']}}"
                                category="{{$project['project_categories_first']}}"
                                photo="{{ $project['user_profile_photo'] }}"
                                name="{{ $project['name'] }}"
                                :reviews="$project['reviews']"
                                nameAuthor="{{ $project['user_name'] }}"
                                posted="{{ language('Posted') }} {{ $project['created_at_view'] }}"
                                country="{{ $project['country_name'] }}" type="{!! $project['name'] !!}"
                                expiry="{{ \Carbon\Carbon::parse($project['deadline'])->format('M d, Y') }}"
                                job="{{ $project['price_type'] == 1 ? language('Fixed Price') : ($project['price_type'] == 2 ? language('Hourly Pricing') : language('Bidding Price')) }}"
                                proposals="{{ $project['proposals_count'] }}"
                                price="{{ $project['price'] > 0 ? price_format($project['price_view']) : language('Bidding Price') }}"
                                link="{{ route('frontend.project.detail', $project['id']) }}"
                                content="{!! $project['description'] !!}"

                                />

                        @endforeach
                    </div>
                    {{ $getProjects->appends(['search' => isset($searchText) ? $searchText : null])->render('components.inc.pagination') }}
                    @else
                    <p class="no-result">{{ language('Not result...') }}</p>
                    @endif
                </div>

            </div>
        </div>
    </section>


    @push('meta')
    <title>
        {{ empty(language('frontend.project.title')) ? language('frontend.project.name') : language('frontend.project.title')  }}
    </title>
    <meta name="description" content="{{ language('frontend.project.description') }}">
    <meta name="keywords" content="{{ language('frontend.project.keywords') }}">
    <script src="/js/nouislider.min.js"></script>
    @endPush


</x-layout>
