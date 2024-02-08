@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content bookmark">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <div class="col-xl-9 col-md-8">
                    {{--                    <nav class="user-tabs mb-4">--}}
                    {{--                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link active" href="freelancer-favourites.html">Bookmarked Projects</a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link" href="freelancer-invitations.html">Invitations</a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </nav>--}}
                    <!-- project list -->
                    <!-- project list -->
                    <div class="my-projects-view favourite-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header d-flex">
                                        <h5 class="card-title">{{ language('Bookmarked Projects') }}</h5>
                                    </div>
                                    <div class="freelance-box book-mark bookmark-projects">
                                        <div class="row">
                                            @if($favourites_total > 0)
                                                <div class="col-md-12 col-lg-12 col-xl-12">
                                                    <div class="relavance-result d-flex align-items-center">
                                                        <h4>{{ language('Found') }} {{ $favourites_total }} {{ language('Results') }}</h4>
                                                    </div>
                                                </div>
                                                <!-- Project Content -->
                                                @foreach($favourites as $favourite)
                                                <div class="col-md-6 col-lg-12 col-xl-3">
                                                    <div class="freelance-widget widget-author">
                                                        <div class="freelance-content">
                                                            @if(auth()->check())
                                                                @if(\App\Services\CommonService::userRoleId(auth()->id()) == 4)
                                                                    <a
                                                                        data-project_id="{{ $favourite->id }}"
                                                                        href="javascript:void(0)"
                                                                        class="favourite projectAddFavorite @if($favourite->favourites == true) favourited @endif ">
                                                                        <i class="fas fa-star"></i>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            <div class="author-heading">
                                                                <div class="profile-img">
                                                                    <a href="{{ route('frontend.profile.index',$favourite->user_id) }}"
                                                                       target="_blank">
                                                                        <img
                                                                            src="{{ $favourite->user_profile_photo }}"
                                                                            alt="{{ $favourite->user_name }}">
                                                                    </a>
                                                                </div>
                                                                <div class="profile-name">
                                                                    <a href="{{ route('frontend.profile.index', $favourite->user_id) }}"
                                                                       target="_blank"
                                                                       class="author-location">{{ $favourite->user_name }}
                                                                        <i
                                                                            class="fas fa-check-circle text-success verified"></i></a>
                                                                </div>
                                                                <div class="freelance-info">
                                                                    <h3>
                                                                        <a href="{{ route('frontend.project.detail', $favourite->id) }}">{{ $favourite->name }}</a>
                                                                    </h3>
                                                                    <div class="freelance-location mb-1">
                                                                        <i class="fas fa-clock"></i>
                                                                        {{ $favourite->created_at_view }}
                                                                    </div>
                                                                    <div class="freelance-location">
                                                                        @if($favourite->user_country_name)
                                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                                        {{ $favourite->user_country_name }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="freelance-tags">
                                                                    @if($favourite->projects_categories)
                                                                        @foreach($favourite->projects_categories as $projects_category)
                                                                        <span class="badge badge-pill badge-design">{{ $projects_category }}</span>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="freelancers-price">
                                                                    @if($favourite->price > 0)
                                                                        {{ $favourite->price_view }}{{ language('frontend.currency') }}
                                                                    @else
                                                                        {{ language('Bidding Price') }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="counter-stats">
                                                                <ul>
                                                                    <li>
                                                                        <h3 class="counter-value">{{ \Carbon\Carbon::parse($favourite->deadline)->format('M d, Y') }}</h3>
                                                                        <h5>{{ language('Expiry') }}</h5>
                                                                    </li>
                                                                    <li>
                                                                        <h3 class="counter-value">0</h3>
                                                                        <h5>{{ language('Proposals') }}</h5>
                                                                    </li>
                                                                    <li>
                                                                        <h3 class="counter-value">
                                                                            <span class="jobtype">
                                                                                @if($favourite->price_type == 1)
                                                                                {{ language('Fixed Price') }}
                                                                                @elseif($favourite->price_type == 2)
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
                                                            <a href="{{ route('frontend.project.detail', $favourite->id) }}" class="btn-cart" tabindex="-1">{{ language('View Detail') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <p>{{ language('No favourites') }}</p>
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
@endsection

@section('JS')
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
@endsection

