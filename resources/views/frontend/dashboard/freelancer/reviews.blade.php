@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="pro-title without-border">{{ language('Reviews') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="reviews">
                                @if($reviews)
                                    @foreach($reviews as $review)
                                        <div class="review-content no-padding">
                                            <h4>
                                                <a href="{{ route('frontend.profile.index', $review->id) }}">{{ $review->user_name }}</a>
                                            </h4>
                                            <div class="rating mb-2">
                                                <span class="average-rating">{{ $review->rating_view }}</span>
                                                <span class="rating-stars"
                                                      data-rating="{{ $review->rating_view }}"></span>
                                            </div>
                                            <p class="mb-0">{!! $review->review !!}</p>
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

