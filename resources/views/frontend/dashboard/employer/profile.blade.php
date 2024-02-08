@extends('frontend.layouts.index')

@section('title', $user->name ." - Employer")
@section('keywords', language('frontend.employer.keywords') )
@section('description',language('frontend.employer.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Profile Banner -->
    <section class="profile-baner" @if($user->banner_image) style="background-image: url('{{ $user->banner_image }}')
    " @endif >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="profile-img">
                        <img src="{{ $user->profile_photo }}"  alt="{{ $user->name }}" style="width:106px;">
                    </div>
                </div>
                <div class="col">
                    <div class="profile-main">
                        <h2>{{ $user->name }} <i class="fas fa-check-circle"></i></h2>
                        <p>{{ $user->user_category_name }}</p>
                        <div class="about-list">
                            <ul>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
{{--                                    <img src="{{ $user->user_country_image }}" alt="{{ $user->user_country_name }}"--}}
{{--                                         height="16">--}}
                                    {{ $user->user_country_name }}
                                </li>
                                <li><i class="far fa-clock"></i> Since {{ $user->created_at->format('M d, Y') }}</li>
                            </ul>
                        </div>
                        <div class="rating">
                            <span class="rating-stars" data-rating="{{ $average_rating }}"></span>
                            <span class="average-rating">{{ $average_rating }} ({{ $reviews_count }})</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    @if(auth()->id() == $user->id)
                    <div class="pro-info-right profile-inf">
                        <a class="btn profile-edit-btn" href="{{ route('frontend.dashboard.employer.profile-settings')
                                }}">{{ language('Edit Profile') }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Profile Banner -->

    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-md-12">

                    <div class="pro-view">

                        <!-- Tab Detail -->
                        <nav class="provider-tabs abouts-view">
                            <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                @if($user->description)
                                <li class="nav-item">
                                    <a class="nav-link" href="#overview" data-bs-toggle="tab">
                                        <img src="{{ asset('frontend/assets/images/icon/tab-icon-01.png') }}"  alt="">
                                        <p class="bg-red">{{ language('About Us') }}</p>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link active " href="#project"
                                       data-bs-toggle="tab">
                                        <img src="{{ asset('frontend/assets/images/icon/tab-icon-09.png') }}"
                                             alt="">
                                        <p>{{ language('Projects') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#review" data-bs-toggle="tab">
                                        <img src="{{ asset('frontend/assets/images/icon/tab-icon-11.png') }}"
                                             alt="">
                                        <p>{{ language('Reviews') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- /Tab Detail -->

                        <div class="tab-content pt-0">
                            @if($user->description)
                            <!-- About Tab Content -->
                            <div role="tabpanel" id="overview" class="tab-pane fade">
                                <div class="pro-post widget-box company-post abouts-detail" >
                                <h3 class="pro-title">{{ language('About US') }}</h3>
                                <div class="pro-content">
                                    {!! $user->description !!}
                                </div>
                            </div>
                            </div>
                            <!-- /About Tab Content -->
                            @endif

                            <!-- Projects Tab Content -->
                            <div role="tabpanel" id="project" class="tab-pane fade active show ">
                                <div class="pro-post widget-box company-post" >
                                <h3 class="pro-title">{{ language('Projects') }}</h3>
                                    @if($getProjects)
                                        @foreach($projects as $project)
                                        <div class="projects-card flex-fill project-company">
                                            <div class="card-body">
                                                <div class="projects-details align-items-center">
                                                    <div class="project-info">
                                                        <span>{{ $project->user_categories_name }}</span>
                                                        <h2>
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a>
                                                        </h2>
                                                        <div class="customer-info">
                                                            <ul class="list-details">
                                                                <li>
                                                                    <div class="slot">
                                                                        <p>{{ language('Price type') }}</p>
                                                                        <h5>
                                                                            @if($project->price_type == 1) {{ language('Fixed Price') }}
                                                                            @elseif($project->price_type == 2) {{ language('Hourly Pricing') }}
                                                                            @else {{ language('Bidding Price') }}
                                                                            @endif
                                                                        </h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="slot">
                                                                        <p>{{ language('Location') }}</p>
                                                                        <h5>
                                                                            <img src="{{ $project->user_country_image }}" height="13" alt="">
                                                                            {{ $project->user_country_name }}
                                                                        </h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="slot">
                                                                        <p>{{ language('Expiry') }}</p>
                                                                        <h5>
                                                                            {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                                                                        </h5>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="project-hire-info">
                                                        <div class="content-divider"></div>
                                                        <div class="projects-amount">
                                                            @if($project->price > 0)
                                                            <h3>${{ $project->price }}</h3>
                                                            @endif
                                                            <h5>
                                                                @if($project->price_type == 1) {{ language('Fixed Price') }}
                                                                @elseif($project->price_type == 2) {{ language('Hourly Pricing') }}
                                                                @else {{ language('Bidding Price') }}
                                                                @endif
                                                            </h5>
                                                        </div>
                                                        <div class="content-divider"></div>
                                                        <div class="projects-action text-center">
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}" class="projects-btn">{{ language('View Details') }} </a>
                                                            <p class="hired-detail"><span>{{ $project->proposals_count }}</span> {{ language('Proposals') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    @else
                                        <p>{{ language('No Projects') }}</p>
                                    @endif

                                <!-- pagination -->
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ $getProjects->appends(['search' => isset($searchText) ? $searchText : null])
                    ->render('vendor.pagination.frontend.dashboard-pagination') }}
                                    </div>
                                </div>
                                <!-- /pagination -->

                            </div>
                            </div>
                            <!-- /Projects Tab Content -->

                            <!-- Reviews Tab Content -->
                            <div role="tabpanel" id="review" class="tab-pane fade">
                                <div class="pro-post widget-box company-post" >
                                <h3 class="pro-title">{{ language('Reviews') }}</h3>
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
                                                <span class="rating-stars" data-rating="{{ $review->rating_view }}"></span>
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
                            <!-- /Reviews Tab Content -->
                        </div>

                    </div>
                </div>

                <!-- profile Sidebar -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar company-profile">

                    <!-- About Widget -->
                    <div class="pro-post widget-box about-widget profile-overview">
                        <div class="profile-head">
                            <h4 class="pro-title mb-0">{{ language('Profile Overview') }}</h4>
                        </div>
                        <ul class="latest-posts pro-content">
                            <li><p>{{ language('Company Name') }}</p><h6>{{ $user->name }}</h6></li>
                            @if($user->established)
                            <li><p>{{ language('Company Established') }}</p><h6>{{ $user->established }}</h6></li>
                            @endif
                            <li><p>{{ language('Designation') }}</p><h6>{{ $user->user_category_name }}</h6></li>
                            @if($user->owner)
                            <li><p>{{ language('Owner Name') }}</p><h6>{{ $user->owner }}</h6></li>
                            @endif
                            <li><p>{{ language('Phone') }}</p><h6>{{ $user->phone }}</h6></li>
                            <li><p>{{ language('Email') }}</p><h6>{{ $user->email }}</h6></li>
                            <li><p>{{ language('Country') }}</p><h6><img src="{{ $user->user_country_image }}" alt="{{
                            $user->user_country_name }}" height="16"> {{ $user->user_country_name }}</h6></li>
                            @if($user->address)
                            <li><p>{{ language('Address') }}</p><h6>{{ $user->address }} @if($user->postalcode) {{ $user->postalcode }}
                                    @endif </h6></li>
                            @endif
                            @if(auth()->id() == $user->id)
                            <li> </li>
                            @endif
                        </ul>
                        @if(auth()->id() != $user->id)
                        <div class="contact-btn">
                            <a href="{{ route('frontend.dashboard.create-chat', $user->id) }}" class="btn btn-primary"><i class="fas fa-phone-alt"></i>{{ language('Send message') }}</a>
                        </div>
                        @endif
                    </div>
                    <!-- /About Widget -->

                    @if($user->social)
                    <!-- Social Widget -->
                    <div class="pro-post widget-box social-widget">
                        <div class="profile-head">
                            <h4 class="pro-title">{{ language('SOCIAL LINKS') }}</h4>
                        </div>
                        <ul class="social-link-profile">
                            @foreach($user->social as $social)
                            <li>
                                <a href="{{ $social->link }}" target="_blank" rel="nofollow">
                                    @if($social->name)
                                    <i class="socicon-{{ $social->name }}"></i>
                                    @else
                                    <i class="fas fa-ban"></i>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /Social Widget -->
                    @endif

                </div>
                <!-- /Profile Sidebar -->

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

    <script>
        function copyToClipboard() {
            var textBoxCopy = document.getElementById("profile-link-copy");
            textBoxCopy.select();
            document.execCommand("copy");
        }
    </script>
@endsection

