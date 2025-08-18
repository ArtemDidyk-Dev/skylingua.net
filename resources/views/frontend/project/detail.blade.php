@extends('frontend.layouts.index')

@section('title', $project->name ." - Projects")
@section('keywords', language('frontend.project.keywords') )
@section('description',language('frontend.project.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="developer-box project-box-view">
                        <h2>{{ $project->name }}</h2>
                        <ul class="develope-list-rate project-rate align-items-center">
                            <li><i class="fas fa-clock"></i>{{ $project->created_at_view }}</li>
                            <li class="full-time">
                                @if($project->price > 0)
                                @if($project->price_type == 1) {{ language('Fixed Price') }}
                                @elseif($project->price_type == 2) {{ language('Hourly Pricing') }}
                                @else {{ language('Bidding Price') }}
                                @endif
                                @else
                                {{ language('Bidding Price') }}
                                @endif
                            </li>
                        </ul>
                        <div class="proposal-box">

                            @if($project->price > 0)
                            <div class="proposal-value">
                                <h4>{{ $project->price_view }}{{ language('frontend.currency') }}</h4>
                                <span>(
                                    @if($project->price_type == 1) {{ language('Fixed Price') }}
                                    @elseif($project->price_type == 2) {{ language('Hourly Pricing') }}
                                    @else {{ language('Bidding Price') }}
                                    @endif
                                )</span>
                            </div>
                            @endif

                            @if(auth()->check())

                                @if(\App\Services\CommonService::userRoleId(auth()->id()) == 4)
                                <a
                                    data-project_id="{{ $project->id }}"
                                    href="javascript:void(0)"
                                    class="btn favourites-btn btn-primary favour-border projectAddFavorite @if($project->favourites == true) favourited @endif @if($project->price <= 0) ms-0 @endif ">
                                    {{ language('Favourite') }}
                                    <i class="fas fa-heart"></i>
                                </a>

                                    @if($project->status == 1 && !$proposal)
                                    <a data-bs-toggle="modal" href="#proposal" class="btn proposal-btn btn-primary">
                                        {{ language('Send Proposal') }}
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </a>
                                    @else
                                        <button disabled class="btn proposal-btn btn-primary">
                                            {{ language('Your sent a Proposal') }}
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </button>
                                    @endif
                                @endif

                            @else
                            <a href="{{ route('frontend.login.index') }}" class="btn favourites-btn btn-primary favour-border" @if($project->price <= 0) style="margin-left:0" @endif >
                                {{ language('Favourite') }}
                                <i class="fas fa-heart"></i>
                            </a>
                            <a href="{{ route('frontend.login.index') }}" class="btn proposal-btn btn-primary">
                                {{ language('Send Proposal') }}
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="pro-view project-details-view">
                        <!-- Job Detail -->
                        <div class="post-widget">
                            <div class="pro-content">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 d-flex">
                                        <div class="pro-post job-type d-flex align-items-center">
                                            <div class="pro-post-head">
                                                <p>{{ language('Job Expiry') }}</p>
                                                <h6>{{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</h6>
                                            </div>
                                            <div class="post-job-icon blue-color">
                                                <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/icon/icon-15.svg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 d-flex">
                                        <div class="pro-post job-type d-flex align-items-center">
                                            <div class="pro-post-head">
                                                <p>{{ language('Location') }}</p>
                                                <h6><img src="{{ $project->user_country_image }}" height="16" alt="" style="margin-top: -6px;"
                                                    > {{ $project->user_country_name }}</h6>
                                            </div>
                                            <div class="post-job-icon orange-color">
                                                <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/icon/icon-14.svg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 d-flex">
                                        <div class="pro-post job-type d-flex align-items-center">
                                            <div class="pro-post-head">
                                                <p>{{ language('Proposals') }}</p>
                                                <h6>{{ $project->proposals_count }} {{ language('Received') }}</h6>
                                            </div>
                                            <div class="post-job-icon pink-color">
                                                <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/icon/icon-13.svg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 d-flex">
                                        <div class="pro-post job-type d-flex align-items-center">
                                            <div class="pro-post-head">
                                                <p>{{ language('Price type') }}</p>
                                                <h6>
                                                    @if($project->price_type == 1) {{ language('Fixed Price') }}
                                                    @elseif($project->price_type == 2) {{ language('Hourly Pricing') }}
                                                    @else {{ language('Bidding Price') }}
                                                    @endif
                                                </h6>
                                            </div>
                                            <div class="post-job-icon green-color">
                                                <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/icon/icon-12.svg') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Job Detail -->

                        <!-- Senior Animator  -->
                        <div class="pro-post widget-box">
                            <h3 class="pro-title">{{ language('Overview') }}</h3>
                            <div class="pro-content">
                                {!! $project->description !!}
                            </div>
                        </div>
                        <!-- /Senior Animator  -->

                        @if($projects_categories)
                            <!-- Desired areas of expertise  -->
                            <div class="pro-post project-widget widget-box">
                                <h3 class="pro-title">{{ language('Desired areas of expertise') }}</h3>
                                <div class="pro-content">
                                    <div class="tags">
                                        @foreach($projects_categories as $projects_category)
                                            <span class="badge badge-pill badge-design">{{ $projects_category->user_category_name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /Desired areas of expertise  -->
                        @endif

                        @if($project->links)
                        <!-- Links  -->
                        <div class="pro-post project-widget widget-box">
                            <h3 class="pro-title">{{ language('Links') }}</h3>
                            <div class="pro-content pt-0">
                                <div class="link-box">
                                    <ul class="latest-posts mb-3">
                                    @foreach($project->links as $link)
                                        <li><a href="{{ $link }}" target="_blank" rel="nofollow">{{ $link }}</a></li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /Links  -->
                        @endif

                        @if($project->document)
                        <!-- Project Requirements  -->
                        <div class="pro-post project-widget widget-box">
                            <h3 class="pro-title">{{ language('Project requirements') }}</h3>
                            <div class="pro-content">
                                @foreach($project->document as $document)
                                <a href="{{ asset('storage/project-documents/'. $document) }}"
                                   target="_blank" download class="mb-2 mr-2" style="display:inline-block; margin: 0 2px;">
                                    <div class="requirement-img" style="width:150px;">
                                        <img class="img-fluid" alt="" src="{{ asset('frontend/assets/images/require-01.jpg') }}">
                                        <div class="file-name">
                                            <h4 style="overflow:hidden; height:17px; width:104px;">{{ pathinfo
                                            (public_path('storage/project-documents/'. $document))['basename'] }}</h4>
                                            <h5 class="text-uppercase">{{ pathinfo(public_path('storage/project-documents/'. $document))
                                            ['extension'] }}</h5>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <!-- Project Requirements  -->
                        @endif

                    </div>
                </div>

                <!-- Blog Sidebar -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar project-client-view">

                    <div class="freelance-widget widget-author mt-2 pro-post">
                        <div class="freelance-content">
                            <div class="author-heading">
                                <div class="profile-img">
                                    <a href="{{ route('frontend.profile.index', $project->user_id) }}" target="_blank">
                                        <img src="{{ $project->user_profile_photo }}" alt="{{ $project->user_name }}">
                                        <span class="project-verified"><i class="fas fa-check-circle"></i></span>
                                    </a>
                                </div>
                                <div class="profile-name">
                                    <div class="author-location"><a href="{{ route('frontend.profile.index', $project->user_id) }}" target="_blank">{{ $project->user_name }}</a></div>
                                </div>
                                <div class="freelance-info">
                                    <h4>{{ $project->user_category_name }}</h4>
                                    <div class="rating">
                                        <span class="rating-stars" data-rating="{{ $average_rating }}"></span>
                                        <span class="average-rating">{{ $average_rating }} <b>({{ $reviews_count }})</b></span>
                                    </div>
                                    <div class="freelance-location"><i class="fas fa-map-marker-alt me-1"></i>
                                        @if($project->user_postalcode){{ $project->user_postalcode }}, @endif
                                        @if($project->user_address) {{ $project->user_address }}, @endif
                                        {{ $project->user_country_name }}
                                    </div>
                                </div>

                                <div class="pro-member">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-start mb-0">
                                                {{ language('Member Since') }}
                                            </h6>
                                        </div>
                                        <div class="col-auto">
                                            <span>{{ \Carbon\Carbon::parse($project->user_created_at)->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class=" text-start mb-0">
                                                {{ language('Total Jobs') }}
                                            </h6>
                                        </div>
                                        <div class="col-auto">
                                            <span>{{ $projects_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    @if($project->user_social)
                    <!-- Social Widget -->
                    <div class="pro-post widget-box post-widget develop-social-link">
                        <h3 class="pro-title">{{ language('Social links') }}</h3>
                        <ul class="social-link-profile">
                            @foreach($project->user_social as $social)
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

                    <!-- Link Widget -->
                    <div class="pro-post widget-box post-widget link-project">
                        <h3 class="pro-title">{{ language('Profile Link') }}</h3>
                        <div class="pro-content pt-0">
                            <div class="form-group profile-group mb-0">
                                <div class="input-group">
                                    <input type="text" id="profile-link-copy" class="form-control" value="{{ route('frontend.profile.index', $project->user_id) }}">
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


    @if(!$proposal && \App\Services\CommonService::userRoleId(auth()->id()) == 4)
    <!-- The Modal -->
    <div class="modal fade" id="proposal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ language('SEND PROPOSALS') }}</h4>
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

                        <form action="{{ route('frontend.dashboard.freelancer.project-proposals.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <div class="feedback-form">
                                <div class="row">
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
                                <div class="col-md-12 submit-section">
                                    <label class="custom_check">
                                        <input name="agree" type="checkbox" name="select_time" required="required" autocomplete="OFF" @if(old('agree')) checked="checked" @endif >
                                        <span class="checkmark"></span> {{ language('I agree to the') }} <a href="/page/terms-conditions" target="_blank">{{ language('Terms And Conditions') }}</a>
                                    </label>
                                    @error('agree' )<div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-12 submit-section text-end">
                                    <button class="btn btn-primary submit-btn" type="submit">{{ language('SUBMIT PROPOSAL') }}</button>
                                </div>
                            </div>
                        </form>
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

    <!-- Jquery Cookie STAST -->
    <script src="{{ asset('frontend/assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>

    <script>
        $('.proposal-btn').on('click', function (event) {
            $.cookie("proposalModal", 1);
        });

        @if(session()->has('message'))
        $.removeCookie("proposalModal");
        @endif

        $('#proposal').on('hidden.bs.modal', function () {
            $.removeCookie("proposalModal");
        });

        $(window).on('load', function() {
            if ($.cookie("proposalModal") == 1) {
                $('#proposal').modal('show');
            }
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

<script>
    function copyToClipboard() {
        var textBoxCopy = document.getElementById("profile-link-copy");
        textBoxCopy.select();
        document.execCommand("copy");
    }
</script>
@endsection

