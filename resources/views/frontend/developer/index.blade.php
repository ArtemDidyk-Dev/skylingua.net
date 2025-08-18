@extends('frontend.layouts.index')

@section('title',empty(language('frontend.developer.title')) ? language('frontend.developer.name') : language('frontend.developer.title').' | Page '.$freelancers->currentPage())
@section('keywords', language('frontend.developer.keywords') )
@section('description',language('frontend.developer.description') )


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
                                <a href="{{ route('frontend.developer.index') }}">{{ language('Clear All') }}</a>
                            @endif
                        </div>
                        <div class="card-body">

                            @php( $minPrice = (int)(isset($filter['minPrice']) && $filter['minPrice'] > 0 ? $filter['minPrice'] : $freelancersMinMaxPrice['minPrice']) )
                            @php( $maxPrice = (int)(isset($filter['maxPrice']) && $filter['maxPrice'] > 0 ? $filter['maxPrice'] : $freelancersMinMaxPrice['maxPrice']) )

                            <form action="{{ route('frontend.developer.index') }}" method="GET">
                                <div class="filter-widget">
                                    <h4>{{ language('Keywords') }}</h4>
                                    <div class="form-group">
                                        <input name="keyword" type="text" class="form-control"
                                               placeholder="{{ language('Enter Keywords') }}"
                                               value="@if(isset($filter['keyword']) && !empty($filter['keyword'])){{ $filter['keyword'] }}@endif">
                                    </div>
                                </div>

                                <div class="filter-widget">
                                    <h4>{{ language('Price') }}</h4>
                                    <div id="price-range"></div>
                                    <div class="row slider-labels">
                                        <div class="col-xs-12 caption">
                                            {{ language('frontend.currency') }}<span
                                                id="price-range-value1">{{ $minPrice }}</span> - <span
                                                id="price-range-value2">{{ $maxPrice }}</span>
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
                                            <select name="user_category" class="form-control select">
                                                <option value="">{{ language('Select Category') }}</option>
                                                @foreach($userCategories as $userCategory)
                                                    <option value="{{ $userCategory->id }}"
                                                            @if(isset($filter['user_category']) && $filter['user_category'] == $userCategory->id) selected @endif >{{ $userCategory->name }}</option>
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
                    @if($freelancers && $freelancers->total() > 0)
                        <div class="row">
                            @if($freelancers->currentPage() == 1)
                                {!! language('seo.freelancers.text') !!}
                                <div style="margin-top: 12px;"></div>
                            @endif

                            @foreach($freelancers as $freelancer)
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <div class="freelance-widget">
                                        <div class="freelance-content">
                                            @if(auth()->check() && auth()->id() != $freelancer->id)
                                                @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                                    <a
                                                        data-user_id="{{ $freelancer->id }}"
                                                        href="javascript:void(0)"
                                                        class="favourite freelanceAddFavorite @if($freelancer->favourites == true) favourited @endif ">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                @endif
                                            @endif
                                            <div class="freelance-img">
                                                <a href="{{ route('frontend.profile.index', $freelancer->id) }}">
                                                    <img src="{{ !empty($freelancer->profile_photo) ? asset('storage/profile/'.
                                $freelancer->profile_photo) : asset('storage/no-photo.jpg') }}" alt="{{
                                $freelancer->name }}">
                                                    <span class="verified"><i class="fas fa-check-circle"></i></span>
                                                </a>
                                            </div>
                                            <div class="freelance-info">
                                                <h3><a href="{{ route('frontend.profile.index', $freelancer->id) }}">{{
                                $freelancer->name }}</a></h3>
                                                <div class="freelance-specific">
                                                    @if($freelancer->user_category_name)
                                                        {{ $freelancer->user_category_name }}
                                                    @else
                                                        &nbsp;
                                                    @endif
                                                </div>
                                                <div class="freelance-location">
                                                    @if($freelancer->user_country_name)
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        @if($freelancer->user_country_image)
                                                            <img src="{{ $freelancer->user_country_image }}"
                                                                 alt="{{ $freelancer->user_country_name }}"
                                                                 style="width:20px;display:inline-block;vertical-align:text-bottom;">
                                                        @endif
                                                        {{ $freelancer->user_country_name }}
                                                    @else
                                                        &nbsp;
                                                    @endif
                                                </div>
                                                <div class="rating">
                                                    <span class="rating-stars"
                                                          data-rating="{{ $freelancer->average_rating }}"></span>
                                                    <span class="average-rating">{{ $freelancer->average_rating }} <b>({{ $freelancer->reviews_count }})</b></span>
                                                </div>
                                                <div class="freelance-tags">
                                                    @if($freelancer->time_rate)
                                                        <span
                                                            class="badge badge-pill badge-design">{{ $freelancer->time_rate }}</span>
                                                    @else
                                                        <span class="badge badge-pill badge-design"
                                                              style="background: none;"> &nbsp; </span>
                                                    @endif
                                                </div>

                                                <div class="freelancers-price"> @if($freelancer->hourly_rate > 0)
                                                        {{ $freelancer->hourly_rate }}{{ language('frontend.currency') }} {{ language('Hourly') }}
                                                    @else
                                                        {{ language('Bidding Price') }}
                                                    @endif</div>

                                            </div>
                                        </div>
                                        <div class="cart-hover">
                                            <a href="{{ route('frontend.profile.index', $freelancer->id) }}"
                                               class="btn-cart" tabindex="-1">{{ language('View Profile') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!-- pagination -->
                        <div class="row">
                            <div class="col-md-12">
                                {{ $freelancers->appends(['search' => isset($searchText) ? $searchText : null])
            ->render('vendor.pagination.frontend.dashboard-pagination') }}
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


    <!-- The Modal -->
    <div class="modal fade" id="rating">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header d-block b-0 pb-0">
                    <span class="modal-close float-end"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <form action="project.html">
                        <div class="modal-info">
                            <div class="text-center pt-0 mb-5">
                                <h3>{{ language('Please login to Favourite Freelancer') }}</h3>
                            </div>
                            <div class="submit-section text-center">
                                <button data-bs-dismiss="modal"
                                        class="btn btn-primary black-btn click-btn">{{ language('Cancel') }}</button>
                                <button type="submit"
                                        class="btn btn-primary click-btn">{{ language('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The Modal -->

@endsection


@section('CSS')
    <!-- RateIt CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/star-rating-svg/css/star-rating-svg.css')}}">
    <style>
        .jq-star {
            cursor: default;
        }

        .jq-star-svg {
            vertical-align: top;
        }
    </style>

    <style>
        .noUi-horizontal .noUi-handle {
            width: 18px !important;
            height: 18px !important;
        }
    </style>
@endsection

@section('JS')
    <!-- RateIt JS -->
    <script src="{{ asset('frontend/assets/plugins/star-rating-svg/jquery.star-rating-svg.js')}}"></script>
    <script>
        $(".rating .rating-stars").starRating({
            starSize: 20,
            readOnly: true,
            useGradient: false,
            starShape: 'rounded',
            activeColor: '#febe42',
        });
    </script>

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
                'min': [{{ $freelancersMinMaxPrice['minPrice'] }}],
                'max': [{{ $freelancersMinMaxPrice['maxPrice'] }}]
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


    <script>
        $('.freelanceAddFavorite').click(function (event) {
            event.preventDefault();

            if ($(this).hasClass('favourited')) {
                $(this).removeClass('favourited');
            } else {
                $(this).addClass('favourited');
            }

            let freelancer_id = $(this).data('user_id');

            $.ajax({
                url: '{{ route('frontend.ajax_add_freelancer_favourites') }}',
                type: 'POST',
                data: {
                    employer_id: {{ auth()->id() }},
                    freelancer_id: freelancer_id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',

                success: function (json) {
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
@endsection

