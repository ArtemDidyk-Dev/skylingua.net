@extends('frontend.layouts.index')

@section('title',empty(language('frontend.home.title'))?language('frontend.home.home'):language('frontend.home.title'))
@section('keywords', language('frontend.home.keyword') )
@section('description', language('frontend.home.description') )
@push('css')
<style>
.custom-select-wrapper {
	display: flex;
	justify-content: space-between;
	padding: 13px 15px;
	cursor: pointer;
}

.custom-select {
	font-weight: 500;
	font-size: 14px;
	line-height: 20px;
}

.custom-select-arrow {
	transition: 0.3s;
}

.custom-select-wrapper.active > .custom-select-arrow {
	transform: rotate(180deg);
}

.custom-select-options {
	position: absolute;
	width: 100%;
	border: 1px solid #D9D9D9;
	border-radius: 12px;
	transform: translate(0, 10px);
	padding: 13px 12px 13px 15px;
	z-index: 5;
	background-color: var(--color-white);
	transition: 0.3s;
	pointer-events: none;
	opacity: 0;
	max-height: 200px;
}

.custom-select-wrapper.active + .custom-select-options {
	transform: translate(0, 5px);
	pointer-events: auto;
	opacity: 1;
}

.custom-select-options-scrollable {
	overflow: auto;
	max-height: 174px;
}

.custom-select-options-scrollable::-webkit-scrollbar {
	width: 4px;
	padding-right: 10px;
}

.custom-select-options-scrollable::-webkit-scrollbar-track {
	background-color: #D9D9D9; 
	border-radius: 10px;
}
 
.custom-select-options-scrollable::-webkit-scrollbar-thumb {
	background: #496AF1; 
	border-radius: 10px;
}

.custom-select-option {
	margin-bottom: 10px;
	cursor: pointer;
	font-weight: 500;
	font-size: 14px;
	line-height: 20px;
}

.custom-select-option:hover {
	text-decoration: underline;
}

.custom-select-option:nth-last-child(1) {
	margin-bottom: 0;
}
</style>
@endPush
@section('content')



    <!-- Home Banner -->
    <section class="section home-banner row-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-7">
                    <div class="banner-content aos" data-aos="fade-up">
                        <div class="rating d-flex">
                            <i class="fas fa-star checked"></i>
                            <i class="fas fa-star checked"></i>
                            <i class="fas fa-star checked"></i>
                            <i class="fas fa-star checked"></i>
                            <i class="fas fa-star checked"></i>
                            <h5>{{ language('Trused by over 2M+ users') }}</h5>
                        </div>
                        <h1>{{ language('Get the perfect') }} <span class="orange-text">{{ language('Developers & Projects') }}</span></h1>
                        <p>{{ language("With the world's #1 Developers marketplace") }}</p>
                        <form class="form"  name="store" id="search" method="GET" action="{{ route('frontend.project.index') }}">
                            <div class="form-inner">
                                <div class="input-group">
                                    <span class="drop-detail">
                                        <select class="form-control select" id="searchID">
                                            <option value="project">{{ language('Projects') }}</option>
                                            <option value="developer">{{ language('Freelancers') }}</option>
                                        </select>
                                    </span>
                                    <input type="text" name="keyword" class="form-control" placeholder="{{ language('Search here') }}">
                                    <button class="btn btn-primary sub-btn" type="submit">{{ language('Search Now') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-lg-5">
                    <div class="banner-img aos" data-aos="fade-up">
                        <img src="{{ asset('frontend/assets/images/banner-img.png')}}" class="img-fluid" alt="banner">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Home Banner -->

    <!-- Our Feature -->
    <section class="section feature">
        <div class="container">
            <div class="row">

                <!-- Feature Item -->
                <div class="col-md-4">
                    <div class="feature-item freelance-count aos" data-aos="fade-up">
                        <div class="feature-icon">
                            <img src="{{ asset('frontend/assets/images/icon/icon-01.png')}}" class="img-fluid" alt="">
                        </div>
                        <div class="feature-content">
                            <h3>{{ $employerCount }}</h3>
                            <p>{{ language('Professional Employers') }}</p>
                        </div>
                    </div>
                </div>
                <!-- /Feature Item -->

                <!-- Feature Item -->
                <div class="col-md-4">
                    <div class="feature-item aos" data-aos="fade-up">
                        <div class="feature-icon">
                            <img src="{{ asset('frontend/assets/images/icon/icon-02.png')}}" class="img-fluid" alt="">
                        </div>
                        <div class="feature-content">
                            <h3>{{ $freelancersCount }}</h3>
                            <p>{{ language('Freelance Developers') }}</p>
                        </div>
                    </div>
                </div>
                <!-- /Feature Item -->

                <!-- Feature Item -->
                <div class="col-md-4">
                    <div class="feature-item comp-project aos" data-aos="fade-up">
                        <div class="feature-icon">
                            <img src="{{ asset('frontend/assets/images/icon/icon-03.png')}}" class="img-fluid" alt="">
                        </div>
                        <div class="feature-content">
                            <h3>{{ $projectsCount }}</h3>
                            <p>{{ language('Various projects') }}</p>
                        </div>
                    </div>
                </div>
                <!-- /Feature Item -->

            </div>
        </div>
    </section>
    <!-- /Our Feature -->

    <!--- Developed Project  -->
    <section class="section work">
        <div class="container-fluid">
            <div class="row">

                <!-- Feature Item -->
                <div class="col-md-6 work-box bg1">
                    <div class="work-content aos" data-aos="fade-up">
                        <h2>{{ language('I need a Developed') }} <span>{{ language('Project') }}</span></h2>
                        <p>{{ language('Get the perfect Developed project for your budget from our creative community.') }}</p>
                        <a href="{{ route('frontend.project.index') }}"><i class="fas fa-long-arrow-alt-right long-arrow"></i></a>
                    </div>
                </div>
                <!-- /Feature Item -->

                <div class="col-md-6 work-box bg2">
                    <div class="work-content aos" data-aos="fade-up">
                        <h2>{{ language('I want to') }} <span>{{ language('work') }}</span></h2>
                        <p>{{ language('Do you want to earn money, find unlimited clients and build your freelance career?') }}</p>
                        <a href="{{ route('frontend.developer.index') }}"><i class="fas fa-long-arrow-alt-right long-arrow"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--- /Developed Project  -->


    @if($getProjects)
    <!-- Projects -->
    <section class="section projects">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 mx-auto">
                    <div class="section-header text-center aos" data-aos="fade-up">
                        <div class="section-line"></div>
                        <h2 class="header-title">{{ language('Get Inspired') }}<br> {{ language('By Development Projects') }}</h2>
                        <p>{{ language('High Performing Solutions To Your') }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Project Content -->
                @foreach($projects as $project)
                <div class="col-md-4 col-lg-12 col-xl-4">
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
                                    <a href="{{ route('frontend.profile.index',$project['user_id']) }}" target="_blank">
                                        <img src="{{ $project['user_profile_photo'] }}" alt="{{ $project['user_name'] }}">
                                    </a>
                                </div>
                                <div class="profile-name">
                                    <a href="{{ route('frontend.profile.index',$project['user_id']) }}" target="_blank" class="author-location">{{ $project['user_name'] }} <i class="fas fa-check-circle text-success verified"></i></a>
                                </div>
                                <div class="freelance-info">
                                    <h3><a href="{{ route('frontend.project.detail', $project['id']) }}">{{ $project['name'] }}</a></h3>
                                    <div class="freelance-location mb-1"><i class="fas fa-clock"></i> {{ language('Posted') }} {{ $project['created_at_view'] }}</div>
                                    <div class="freelance-location"> @if($project['country_name'])  <i class="fas fa-map-marker-alt me-1"></i>{{ $project['country_name'] }} @endif </div>
                                </div>
                                <div class="freelance-tags">
                                    @if($project['projects_categories'])
                                        @foreach($project['projects_categories'] as $projects_category)
                                            <span class="badge badge-pill badge-design">{{ $projects_category }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="freelancers-price">
                                    @if($project['price'] > 0)
                                        {{ price_format($project['price_view']) }}
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
                                                @if($project['price_type'] == 1) {{ language('Fixed Price') }}
                                                @elseif($project['price_type'] == 2) {{ language('Hourly Pricing') }}
                                                @else {{ language('Bidding Price') }}
                                                @endif
                                            </span>
                                        </h3>
                                        <h5>{{ language('Job Type') }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cart-hover">
                            <a href="{{ route('frontend.project.detail', $project['id']) }}" class="btn-cart" tabindex="-1">{{ language('View Detail') }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="see-all aos" data-aos="fade-up">
                        <a href="{{ route('frontend.project.index') }}" class="btn all-btn">{{ language('SEE ALL PROJECT') }}</a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /Projects -->
    @endif

    @if($freelancers)
    <!-- Top Instructor -->
    <section class="section developer">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12 col-12 mx-auto">
                    <div class="section-header text-center aos" data-aos="fade-up">
                        <div class="section-line"></div>
                        <h2 class="header-title">{{ language('Most Hired Developers') }}</h2>
                        <p>{{ language('Work with talented people at the most affordable price') }}</p>
                    </div>
                </div>
            </div>
            <div id="developers-slider" class="owl-carousel owl-theme developers-slider aos" data-aos="fade-up">

                @foreach($freelancers as $freelancer)
                <div class="freelance-widget">
                    <div class="freelance-content">
                        @if(auth()->check() && auth()->id() != $freelancer->id)
                            @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                <a
                                    data-user_id="{{ $freelancer->id }}"
                                    href="javascript:void(0)"
                                    class="favourite freelanceAddFavorite @if($freelancer->favourites == true) {{ language('favourited') }} @endif ">
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
                                    <img src="{{ $freelancer->user_country_image }}" alt="{{ $freelancer->user_country_name }}" style="width:20px;display:inline-block;vertical-align:text-bottom;">
                                    {{ $freelancer->user_country_name }}
                                @else
                                    &nbsp;
                                @endif
                            </div>
                            <div class="rating">
                                <span class="rating-stars rating-stars{{ $freelancer->id }}" data-rating="{{ $freelancer->average_rating }}"></span>
                                <span class="average-rating">{{ $freelancer->average_rating }} ({{ $freelancer->reviews_count }})</span>
                            </div>
                            <div class="freelance-tags">
                                @if($freelancer->time_rate)
                                    <span class="badge badge-pill badge-design">{{ $freelancer->time_rate }}</span>
                                @else
                                    <span class="badge badge-pill badge-design" style="background: none;"> &nbsp; </span>
                                @endif
                            </div>

                            <div class="freelancers-price"> @if($freelancer->hourly_rate > 0) ${{ $freelancer->hourly_rate }} {{ language('Hourly') }} @else {{ language('Bidding Price') }} @endif</div>

                        </div>
                    </div>
                    <div class="cart-hover">
                        <a href="{{ route('frontend.profile.index', $freelancer->id) }}" class="btn-cart" tabindex="-1">{{ language('View Profile') }}</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="see-all aos" data-aos="fade-up">
                        <a href="{{ route('frontend.developer.index') }}" class="btn all-btn">{{ language('SEE ALL DEVELOPERS') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Developer -->
    @endif


    @if($blogs)
    <!-- News -->
    <section class="section news">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center aos" data-aos="fade-up">
                        <div class="section-line"></div>
                        <h2 class="header-title">{{ language('Feature Blog') }}</h2>
                        <p>{{ language('High Performing Developers To Your') }}</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="row blog-grid-row">
                    @foreach($blogs as $blog)
                    <div class="col-md-4">
                        <!-- Blog Post -->
                        <div class="blog grid-blog aos" data-aos="fade-up">
                            <div class="blog-image">
                                <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                    @if(empty($blog->image))
                                        <img class="img-fluid" src="{{ asset('storage/no-image.png') }}"
                                             alt="{{ $blog->name }}">
                                    @else
                                        <img class="img-fluid" src="{{  \App\Services\ImageService::resizeImageSize($blog->image,'medium',80) }}"
                                             alt="{{ $blog->name }}">
                                    @endif
                                </a>
                            </div>
                            <div class="blog-content">
                                <h3 class="blog-title"><a href="{{ route('frontend.blog.detail', $blog->slug) }}">{{ $blog->name }}</a></h3>
                            </div>
                        </div>
                        <!-- /Blog Post -->

                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="see-all aos" data-aos="fade-up">
                        <a href="{{ route('frontend.blog.index') }}" class="btn all-btn">{{ language('SEE ALL BLOGS') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / News -->
    @endif

@endsection

@section('CSS')
    @if($freelancers)
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
    @if($freelancers)
    <!-- RateIt JS -->
    <script src="{{ asset('frontend/assets/plugins/star-rating-svg/jquery.star-rating-svg.js')}}"></script>
    <script>
        @foreach($freelancers as $freelancer)
        $(".rating .rating-stars{{ $freelancer->id }}").starRating({
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
    $('#searchID').on('change', function() {
        if (this.value == 'project') {
            $('#search').attr('action', '{{ route('frontend.project.index') }}');
        } else {
            $('#search').attr('action', '{{ route('frontend.developer.index') }}');
        }
    });
    </script>
    @if(auth()->check())
    <script>
        $( '#developers-slider .freelanceAddFavorite' ).click(function( event ) {
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



