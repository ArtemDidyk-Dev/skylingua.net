@extends('frontend.layouts.index')

@section('title',empty(language('frontend.project.title')) ? language('frontend.project.name') : language('frontend.project.title').' | Page '.$getProjects->currentPage())
@section('keywords', language('frontend.project.keywords') )
@section('description',language('frontend.project.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Search Filter -->
                    <div class="card search-filter">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title mb-0">{{ language('FILTERS') }}</h4>
                            @if($filter)
                            <a href="{{ route('frontend.project.index') }}">{{ language('Clear All') }}</a>
                            @endif
                        </div>
                        <div class="card-body">

                            @php( $minPrice = (int)(isset($filter['minPrice']) && $filter['minPrice'] > 0 ? $filter['minPrice'] : $getProjectsMinMaxPrice['minPrice']) )
                            @php( $maxPrice = (int)(isset($filter['maxPrice']) && $filter['maxPrice'] > 0 ? $filter['maxPrice'] : $getProjectsMinMaxPrice['maxPrice']) )

                            <form action="{{ route('frontend.project.index') }}" method="GET">

                                <div class="filter-widget">
                                    <h4>{{ language('Keywords') }}</h4>
                                    <div class="form-group">
                                        <input name="keyword" type="text" class="form-control"
                                               placeholder="Enter Keywords"
                                               value="@if(isset($filter['keyword']) && !empty($filter['keyword'])){{ $filter['keyword'] }}@endif">
                                    </div>
                                </div>

                                <div class="filter-widget">
                                    <h4>{{ language('Price') }}</h4>
                                    <div id="price-range"></div>
                                    <div class="row slider-labels">
                                        <div class="col-xs-12 caption">
                                            <span id="price-range-value1">{{ $minPrice }}</span> - <span
                                                id="price-range-value2">{{ $maxPrice }}</span>{{ language('frontend.currency') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" name="minPrice" id="price-range-minPrice"
                                                   value="{{ $minPrice }}">
                                            <input type="hidden" name="maxPrice" id="price-range-maxPrice"
                                                   value="{{ $maxPrice }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="filter-widget">
                                    <h4>{{ language('Pricing Type') }}</h4>
                                    <div class="form-group">
                                        <select name="price_type" class="form-control select">
                                            <option value="">{{ language('Select Pricing Type') }}</option>
                                            <option value="1" @if(isset($filter['price_type']) && $filter['price_type']==1) selected @endif >{{ language('Fixed Price') }}</option>
                                            <option value="2" @if(isset($filter['price_type']) && $filter['price_type']==2) selected @endif >{{ language('Hourly Pricing') }}</option>
                                            <option value="3" @if(isset($filter['price_type']) && $filter['price_type']==3) selected @endif >{{ language('Bidding Price') }}</option>
                                        </select>
                                    </div>
                                </div>

                                @if($countries)
                                    <div class="filter-widget">
                                        <h4>{{ language('Location') }}</h4>
                                        <div class="form-group">
                                            <select name="country" class="form-control select">
                                                <option value="">{{ language('Select Country') }}</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                            @if(isset($filter['country']) && $filter['country'] == $country->id) selected @endif >{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if($userCategories)
                                    <div class="filter-widget">
                                        <h4>{{ language('Category') }}</h4>
                                        <div class="form-group">
                                            <select name="project_category" class="form-control select">
                                                <option value="">{{ language('Select Category') }}</option>
                                                @foreach($userCategories as $userCategory)
                                                    <option value="{{ $userCategory->id }}"
                                                            @if(isset($filter['project_category']) && $filter['project_category'] == $userCategory->id) selected @endif >{{ $userCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="btn-search">
                                    <button type="submit" class="btn btn-block">{{ language('Search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Search Filter -->

                </div>

                <div class="col-md-12 col-lg-8 col-xl-9">

                    @if($getProjects && $getProjects->total() > 0)
                        @if($getProjects->currentPage() == 1)
                            {!! language('seo.projects.text') !!}
                            <div style="margin-top: 12px;"></div>
                        @endif
                        <div class="row">
                            <!-- Project Content -->
                            @foreach($projects as $project)
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="freelance-widget widget-author">
                                        <div class="freelance-content">
                                            @if(auth()->check())
                                                @if(\App\Services\CommonService::userRoleId(auth()->id()) == 4)
                                                    <a
                                                        data-project_id="{{ $project['id'] }}"
                                                        href="javascript:void(0)"
                                                        class="favourite projectAddFavorite @if($project['favourites'] == true) favourited @endif ">
                                                        <i class="fas fa-heart"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            <div class="author-heading">
                                                <div class="profile-img">
                                                    <a href="{{ route('frontend.profile.index',$project['user_id']) }}"
                                                       target="_blank">
                                                        <img src="{{ $project['user_profile_photo'] }}"
                                                             alt="{{ $project['user_name'] }}">
                                                    </a>
                                                </div>
                                                <div class="profile-name">
                                                    <a href="{{ route('frontend.profile.index',$project['user_id']) }}"
                                                       target="_blank"
                                                       class="author-location">{{ $project['user_name'] }} <i
                                                            class="fas fa-check-circle text-success verified"></i></a>
                                                </div>
                                                <div class="freelance-info">
                                                    <h3>
                                                        <a href="{{ route('frontend.project.detail', $project['id']) }}">{{ $project['name'] }}</a>
                                                    </h3>
                                                    <div class="freelance-location mb-1"><i class="fas fa-clock"></i>
                                                        Posted {{ $project['created_at_view'] }}</div>
                                                    <div class="freelance-location"> @if($project['country_name'])
                                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $project['country_name'] }}
                                                        @endif </div>
                                                </div>
                                                <div class="freelance-tags">
                                                    @if($project['projects_categories'])
                                                        @foreach($project['projects_categories'] as $projects_category)
                                                            <span
                                                                class="badge badge-pill badge-design">{{ $projects_category }}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="freelancers-price">
                                                    @if($project['price'] > 0)
                                                        {{ $project['price_view'] }}{{ language('frontend.currency') }}
                                                    @else
                                                        {{ language('Bidding Price') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="counter-stats">
                                                <ul>
                                                    <li>
                                                        <h3 class="counter-value">{{ \Carbon\Carbon::parse($project['deadline'])->format('M d, Y') }}</h3>
                                                        <h5>{{ language('Expiry') }}</h5>
                                                    </li>
                                                    <li>
                                                        <h3 class="counter-value">{{ $project['proposals_count'] }}</h3>
                                                        <h5>{{ language('Proposals') }}</h5>
                                                    </li>
                                                    <li>
                                                        <h3 class="counter-value">
                                                    <span class="jobtype">
                                                        @if($project['price_type'] == 1)
                                                            {{ language('Fixed Price') }}
                                                        @elseif($project['price_type'] == 2)
                                                            {{ language('Hourly Pricing') }}
                                                        @else
                                                            {{ language('Bidding Price') }}
                                                        @endif
                                                    </span>
                                                        </h3>
                                                        <h5>{{ language('Job Type') }}</h5>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cart-hover">
                                            <a href="{{ route('frontend.project.detail', $project['id']) }}"
                                               class="btn-cart" tabindex="-1">{{ language('View Detail') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <!-- pagination -->
                        <div class="row">
                            <div class="col-md-12">
                                {{ $getProjects->appends(['search' => isset($searchText) ? $searchText : null])
                        ->render('components.inc.pagination') }}
            
                            </div>
                        </div>
                        <!-- /pagination -->
                    @else
                        <p style="border-bottom: 3px #ff5b37 solid;">{{ language('Not result...') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
    <style>
        .noUi-horizontal .noUi-handle {
            width: 18px !important;
            height: 18px !important;
        }
    </style>
@endsection

@section('JS')
    <!-- Range JS -->
    <script src="{{ asset('frontend/assets/js/range.js')}}"></script>

    <script>
        $('.noUi-handle').on('click', function () {
            $(this).width(50);
        });
        var rangeSlider = document.getElementById('price-range');
        var moneyFormat = wNumb({
            decimals: 0,
            thousand: ',',
            prefix: ''
        });
        noUiSlider.create(rangeSlider, {
            start: [{{ $minPrice }}, {{ $maxPrice }}],
            step: 1,
            range: {
                'min': [{{ $getProjectsMinMaxPrice['minPrice'] }}],
                'max': [{{ $getProjectsMinMaxPrice['maxPrice'] }}]
            },
            format: moneyFormat,
            connect: true
        });

        // Set visual min and max values and also update value hidden form inputs
        rangeSlider.noUiSlider.on('update', function (values, handle) {
            document.getElementById('price-range-value1').innerHTML = values[0];
            document.getElementById('price-range-value2').innerHTML = values[1];
            document.getElementById('price-range-minPrice').value = moneyFormat.from(
                values[0]);
            document.getElementById('price-range-maxPrice').value = moneyFormat.from(
                values[1]);
        });
    </script>

    @if(auth()->check())
    <script>
        $( '.projectAddFavorite' ).click(function( event ) {
            event.preventDefault();

            if ($(this).hasClass('favourited')) {
                $(this).removeClass('favourited');
            } else {
                $(this).addClass('favourited');
            }

            let project_id = $(this).data('project_id');

            $.ajax({
                url: '{{ route('frontend.ajax_add_project_favourites') }}',
                type: 'POST',
                data: {
                    freelancer_id: {{ auth()->id() }},
                    project_id: project_id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',

                success: function(json) {
                    if (json.success == true) {

                        Snarl.addNotification({
                            title: json.data.title,
                            text: json.data.text,
                            icon: json.data.icon
                        });

                    }
                }
            });
        });
    </script>
    @endif
@endsection

