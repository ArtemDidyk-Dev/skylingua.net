@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content content-page">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="card ">
                        <div class="card-header review-heading">
                            <h3 class="pro-title without-border">{{ language('Reviews') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="reviews company-review">
                                @if($reviews)
                                    @foreach($reviews as $review)
                                        <div class="review-content no-padding">
                                            <p class="mb-0">{!! $review->review !!}</p>
                                            <div class="review-top tab-reviews d-flex align-items-center">
                                                <div class="review-img">
                                                    <a href="{{ route('frontend.profile.index', $review->id) }}"><img class="img-fluid" src="{{ $review->user_profile_photo }}" alt="{{ $review->user_name }}"></a>
                                                </div>
                                                <div class="review-info">
                                                    <h3><a href="{{ route('frontend.profile.index', $review->id) }}">{{ $review->user_name }}</a></h3>
                                                    <h5>{{ $review->created_at_view }}</h5>
                                                </div>
                                                <div class="rating">
                                                    <span class="rating-stars"
                                                          data-rating="{{ $review->rating_view }}"></span>
                                                    <span class="average-rating">{{ $review->rating_view }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{ language('No Reviews') }}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
    <!-- RateIt CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/star-rating-svg/css/star-rating-svg.css')}}">
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
@endsection

