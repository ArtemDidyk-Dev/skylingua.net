@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content content-page bookmark">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">

                    <div class="my-projects-view favourite-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header d-flex">
                                        <h5 class="card-title">{{ language('Bookmarked Freelancers') }}</h5>
                                    </div>
                                    <div class="freelance-box book-mark favour-book">
                                        <div class="row">
                                            @if($favourites)
                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                <div class="relavance-result d-flex align-items-center">
                                                    <h4>{{ language('Found') }} {{ count($favourites) }} {{ language('Results') }}</h4>
                                                </div>
                                            </div>
                                                @foreach($favourites as $favourite)
                                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                                        <div class="freelance-widget">
                                                            <div class="freelance-content">
                                                                @if(auth()->check() && auth()->id() !=$favourite->id)
                                                                    @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                                                        <a
                                                                            data-user_id="{{$favourite->id }}"
                                                                            href="javascript:void(0)"
                                                                            class="favourite freelanceAddFavorite @if($favourite->favourites == true) favourited @endif ">
                                                                            <i class="fas fa-star"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <div class="freelance-img">
                                                                    <a href="{{ route('frontend.profile.index',$favourite->id) }}">
                                                                        <img src="{{ !empty($favourite->profile_photo) ? asset('storage/profile/'.
                               $favourite->profile_photo) : asset('storage/no-photo.jpg') }}" alt="{{
                               $favourite->name }}">
                                                                        <span class="verified"><i class="fas fa-check-circle"></i></span>
                                                                    </a>
                                                                </div>
                                                                <div class="freelance-info">
                                                                    <h3><a href="{{ route('frontend.profile.index',$favourite->id) }}">{{
                               $favourite->name }}</a></h3>
                                                                    <div class="freelance-specific">
                                                                        @if($favourite->user_category_name)
                                                                            {{$favourite->user_category_name }}
                                                                        @else
                                                                            &nbsp;
                                                                        @endif
                                                                    </div>
                                                                    <div class="freelance-location">
                                                                        @if($favourite->user_country_name)
                                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                                            <img src="{{$favourite->user_country_image }}" alt="{{$favourite->user_country_name }}" style="width:20px;display:inline-block;vertical-align:text-bottom;">
                                                                            {{$favourite->user_country_name }}
                                                                        @else
                                                                            &nbsp;
                                                                        @endif
                                                                    </div>
                                                                    <div class="rating">
                                                                        <span class="rating-stars rating-stars{{ $favourite->id }}" data-rating="{{ $favourite->average_rating }}"></span>
                                                                        <span class="average-rating">{{ $favourite->average_rating }} ({{ $favourite->reviews_count }})</span>
                                                                    </div>
                                                                    <div class="freelance-tags">
                                                                        @if($favourite->time_rate)
                                                                            <span class="badge badge-pill badge-design">{{$favourite->time_rate }}</span>
                                                                        @else
                                                                            <span class="badge badge-pill badge-design" style="background: none;"> &nbsp; </span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="freelancers-price"> @if($favourite->hourly_rate > 0) {{$favourite->hourly_rate }}{{ language('frontend.currency') }} {{ language('Hourly') }} @else {{ language('Bidding Price') }} @endif</div>

                                                                </div>
                                                            </div>
                                                            <div class="cart-hover">
                                                                <a href="{{ route('frontend.profile.index',$favourite->id) }}" class="btn-cart" tabindex="-1">{{ language('View Profile') }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>{{ language('Not found') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- project list -->
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
    @if($favourites)
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
    @endif
@endsection

@section('JS')
    @if($favourites)
        <!-- RateIt JS -->
        <script src="{{ asset('frontend/assets/plugins/star-rating-svg/jquery.star-rating-svg.js')}}"></script>
        <script>
            @foreach($favourites as $favourite)
            $(".rating .rating-stars{{ $favourite->id }}").starRating({
                starSize: 20,
                readOnly: true,
                useGradient: false,
                starShape: 'rounded',
                activeColor: '#febe42',
            });
            @endforeach
        </script>
    @endif

    <script>
        $( '.freelanceAddFavorite' ).click(function( event ) {
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
@endsection

