@extends('frontend.layouts.index')

@section('title', $user->name ." - Freelancer")
@section('keywords', language('frontend.developer.keywords') )
@section('description',language('frontend.developer.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="developer-box head-develop">
                        <div class="developer-profile-img">
                            <img src="{{ $user->banner_image }}" alt="" class="img-fluid">
                            <div class="img-profile">
                                <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}" class="img-fluid">
                            </div>
                        </div>
                        <h2>{{ $user->name }} <i class="fas fa-check-circle"></i></h2>
                        <p>
                            {{ $user->user_category_name }}
                            @if($user->time_rate)
                                <span>{{ $user->time_rate }}</span>
                            @endif
                        </p>
                        <ul class="develope-list-rate">
                            <li>
                                <div class="rating">
                                    <span class="average-rating">{{ $average_rating }}</span>
                                    <span class="rating-stars"
                                          data-rating="{{ $average_rating }}"></span>
                                </div>
                            </li>
                            <li>{{ language('Member Since') }}, {{ $user->created_at->format('M d, Y') }}</li>
                            <li class="bl-0">
                                @if($user->user_country_image)
                                <img src="{{ $user->user_country_image }}" alt="{{ $user->user_country_name }}" style="height:16px;">
                                @endif
                                {{ $user->user_country_name }}
                            </li>
                        </ul>
                        <div class="proposal-box">
                            @if($user->hourly_rate > 0)
                                <div class="proposal-value me-5">
                                    <h4>{{ $user->hourly_rate }}{{ language('frontend.currency') }}</h4>
                                    <span>{{ language('( Per Hour )') }}</span>
                                </div>
                            @endif
                            @if(auth()->check())
                                @if(auth()->id() != $user->id)
                                    @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                        <a data-user_id="{{ $user->id }}" href="javascript:void(0)"
                                           class="btn favourites-btn btn-primary favour-border freelanceAddFavorite @if($user->favourites == true) favourited @endif @if($user->hourly_rate <= 0) ms-0 @endif ">
                                            {{ language('Favourite') }}
                                            <i class="fas fa-heart"></i>
                                        </a>

                                        @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                        <a data-bs-toggle="modal" href="#proposal"
                                           class="btn proposal-btn btn-primary me-3">
                                            <i class="fas fa-paper-plane me-1 ms-0"></i>
                                            {{ language('Send Invite') }}
                                        </a>
                                        @endif
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('frontend.login.index') }}"
                                   class="btn favourites-btn btn-primary favour-border @if($user->hourly_rate <= 0) ms-0 @endif ">
                                    {{ language('Favourite') }} <i class="fas fa-heart"></i>
                                </a>
                                <a href="{{ route('frontend.login.index') }}"
                                   class="btn proposal-btn btn-primary btn-success">
                                    <i class="fas fa-paper-plane me-1 ms-0"></i>
                                    {{ language('Send Invite') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="pro-view develop-view">
                        <!-- Tab Detail -->
                        <nav class="provider-tabs mb-4 abouts-view1">
                            <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active-about" href="#overview">
                                        <img src="{{ asset('frontend/assets/images/icon/tab-icon-01.png') }}" alt="">
                                        <p class="bg-red">{{ language('Overview') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#portfolio">
                                        <img src="{{ asset('frontend/assets/images/icon/tab-icon-02.png') }}" alt="">
                                        <p class="bg-blue">{{ language('Portfolio') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#reviews">
                                        <img src="{{ asset('frontend/assets/images/icon/tab-icon-06.png') }}" alt="">
                                        <p class="bg-green">{{ language('Reviews') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- /Tab Detail -->


                            <!-- Overview Tab Content -->
                            <div class="pro-post widget-box" id="overview">
                                <h3 class="pro-title">{{ language('Overview') }}</h3>
                                <div class="pro-content">
                                    @if($user->description)
                                    {!! $user->description !!}
                                    @else
                                        ...
                                    @endif
                                </div>
                            </div>
                            <!-- /Overview Tab Content -->

                        <!-- Project Tab Content -->
                        <div class="pro-post project-widget widget-box project-gallery" id="portfolio">
                            <h3 class="pro-title">{{ language('Portfolio') }}</h3>
                            <div class="pro-content">
                                <div class="row">
                                    @if($portfolios && $portfolios->total() > 0)
                                        @foreach($portfolios as $portfolio)
                                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                                <div class="project-widget">
                                                    <div class="pro-image">
                                                        @if(!empty($portfolio->image))
                                                            <a href="{{ asset('storage/portfolio/'. $portfolio->image) }}"
                                                               data-fancybox="gallery2">
                                                                <img class="img-fluid" alt="{{ $portfolio->title }}"
                                                                     src="{{ asset('storage/portfolio/'. $portfolio->image) }}">
                                                            </a>
                                                        @else
                                                            <img class="img-fluid" alt="{{ $portfolio->title }}"
                                                                 src="{{ asset('storage/no_image_portfolio.jpg') }}">
                                                        @endif

                                                    </div>
                                                    <div class="project-footer">
                                                        <div class="d-flex align-items-center">
                                                            <div class="pro-detail">
                                                                <h3 class="pro-name">
                                                                    {{ $portfolio->title }}
                                                                </h3>
                                                            </div>
                                                            @if(!empty($portfolio->link))
                                                                <div class="view-image">
                                                                    <a href="{{ $portfolio->link }}" target="_blank"
                                                                       rel="nofollow"><i class="fas fa-arrow-right"></i></a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            {{ language('No Portfolio') }}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <!-- /Project Tab Content -->


                        <!-- Feedback Tab Content -->
                        <div class="pro-post author-widget clearfix develop-feedback" id="reviews">
                            <div class="widget-title-box clearfix d-flex">
                                <h3 class="pro-title mb-0">{{ language('Reviews') }}</h3>
                            </div>

                            @if($reviews)
                                @foreach($reviews as $review)
                                    <div class="about-author">
                                        <div class="about-author-img">
                                            <div class="author-img-wrap">
                                                <a href="{{ route('frontend.profile.index', $review->id) }}"><img
                                                        class="img-fluid" alt="{{ $review->user_name }}"
                                                        src="{{ $review->user_profile_photo }}"></a>
                                            </div>
                                        </div>
                                        <div class="author-details">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('frontend.profile.index', $review->id) }}"
                                                   class="blog-author-name">{{ $review->user_name }}</a>
                                                <div class="rating">
                                                    <span class="rating-stars"
                                                          data-rating="{{ $review->rating_view }}"></span>
                                                    <span class="average-rating">{{ $review->rating_view }}</span>
                                                </div>
                                            </div>
                                            <h6>{{ language('Techline') }} {{ $review->created_at_view }}</h6>
                                            <p class="mb-0">{!! $text !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="about-author">
                                    {{ language('No Reviews') }}
                                </div>
                            @endif
                        </div>
                        <!-- /Feedback Tab Content -->

                    </div>
                </div>

                <!-- Blog Sidebar -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar developer-view">

                    <!-- About Widget -->
                    <div class="pro-post widget-box about-widget about-field">
                        <h4 class="pro-title ">{{ language('About Me') }}</h4>
                        <table class="table">
                            <tbody>
                            @if($user->gender)
                                <tr>
                                    <td>{{ language('Gender') }}</td>
                                    <td>
                                        @if($user->gender == 1)
                                            {{ language('Male') }}
                                        @else
                                            {{ language('Famele') }}
                                        @endif
                                    </td>
                                </tr>
                            @endif

{{--                            @if($user->phone)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ language('Phone') }}</td>--}}
{{--                                    <td>{{ $user->phone }}</td>--}}
{{--                                </tr>--}}
{{--                            @endif--}}

{{--                            @if($user->email)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ language('E-mail') }}</td>--}}
{{--                                    <td>{{ $user->email }}</td>--}}
{{--                                </tr>--}}
{{--                            @endif--}}

                            @if($user->address)
                                <tr>
                                    <td>{{ language('Location') }}</td>
                                    <td>
                                        @if($user->user_country_name)
                                            {{ $user->user_country_name }} /
                                        @endif
                                        {{ $user->address }}
                                        @if($user->postalcode)
                                            {{ $user->postalcode }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        @if(auth()->check())
                            @if(auth()->id() != $user->id)
                                <div class="contact-btn pb-3">
                                    <a href="{{ route('frontend.dashboard.create-chat', $user->id) }}"
                                       class="btn btn-primary">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ language('Send message') }}
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="contact-btn pb-3">
                                <a href="{{ route('frontend.login.index') }}" class="btn btn-primary">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ language('Send message') }}
                                </a>
                            </div>
                        @endif
                    </div>
                    <!-- /About Widget -->


                    <!-- LInk Widget -->
                    <div class="pro-post widget-box post-widget profile-link">
                        <h3 class="pro-title">{{ language('Profile Link') }}</h3>
                        <div class="pro-content">
                            <div class="form-group profile-group mb-0">
                                <div class="input-group">
                                    <input type="text" id="profile-link-copy" class="form-control"
                                           value="{{ $user->user_profile_link }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-success sub-btn" type="button" onclick="copyToClipboard()"><i class="fa fa-clone"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Link Widget -->

                </div>
                <!-- /Blog Sidebar -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->

    @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
        <!-- The Modal -->
        <div class="modal fade" id="proposal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ language('SEND INVITE') }}</h4>
                        <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                    </div>
                    <div class="modal-body">
                        <div class="modal-info">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin: 0 0 0 20px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('frontend.pay.go') }}" method="POST">
                                @csrf

                                <input type="hidden" name="freelancer_id" value="{{ $user->id }}">

                                <div class="feedback-form">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="price">{{ language('Your Projects') }}</label>
                                            <select class="form-control select" name="project_id" id="project_id">
                                                @foreach($projects_list as $project)
                                                <option  value="{{ $project->id }}" @if(old('project_id') == $project->id) selected @endif >{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_id' )<span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="price">{{ language('Your Price') }}</label>
                                            <input name="price" id="price" type="number" min="0" step="0.01" class="form-control" placeholder="{{ language('Your Price') }}" required="required" autocomplete="OFF" value="{{ old('price') }}">
                                            @error('price' )<span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="hours">{{ language('Estimated Days') }}</label>
                                            <input name="hours" id="hours" type="number" min="0" step="1" class="form-control" placeholder="{{ language('Example: 11 Days') }}" required="required" autocomplete="OFF" value="{{ old('hours') }}">
                                            @error('hours' )<span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <textarea name="letter" rows="5" class="form-control" placeholder="{{ language('Cover Letter') }}" autocomplete="OFF" value="{{ old('letter') }}"></textarea>
                                            @error('letter' )<span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 submit-section">
                                        <label class="custom_check">
                                            <input name="agree" type="checkbox" name="select_time" required="required" autocomplete="OFF" @if(old('agree')) checked="checked" @endif >
                                            <span class="checkmark"></span> {{ language('I agree to the') }} <a href="/page/terms-conditions" target="_blank">{{ language('Terms And Conditions') }}</a>
                                        </label>
                                        @error('agree' )<div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4 submit-section text-end">
                                        <button class="btn btn-primary submit-btn" type="submit">{{ language('SEND INVITE') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-2 mb-4 payment_address">
                            {{ setting('address',true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /The Modal -->
    @endif

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

    <script>
        $('#project_id').select2({
            width: '100%'
        });
    </script>
@endsection

