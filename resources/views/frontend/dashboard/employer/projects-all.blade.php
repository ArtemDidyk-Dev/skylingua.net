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
                    <div class="page-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>{{ language('Manage Servicess') }}</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                {{-- <a href="{{ route('frontend.dashboard.employer.employerProjectAdd') }}"
                                   class="btn btn-primary back-btn mb-4">{{ language('Post a Services') }}</a> --}}
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                            <ul>
                                <li>{{ session()->get('message') }}</li>
                            </ul>
                        </div>
                    @endif

                    @include('frontend.dashboard.employer._projectNav', ['user' => $user])

                    @if($getProposals)
                        @foreach($getProposals as $project)
                            <!-- Services list -->
                            <div class="my-projects-list">
                                <div class="row">
                                    <div class="col-lg-12 flex-wrap">
                                        <div class="projects-card flex-fill">
                                            <div class="card-body">
                                                <div class="projects-details align-items-center">
                                                    <div class="project-info">
                                                        <span>{{ $project->user_categories_name }}</span>
                                                        <h2>{{ $project->name }}</h2>
                                                        <div class="customer-info">
                                                            <ul class="list-details">
                                                                <li>
                                                                    <div class="slot">
                                                                        <p>{{ language('Expiry') }}</p>
                                                                        <h5>
                                                                            {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                                                                        </h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('frontend.profile.index', $project->freelancer_id) }}"
                                                                       class="prj-proposal-count text-center hired">
                                                                        <img
                                                                            src="{{ !empty($project->user_profile_photo) ? asset('storage/profile/'. $project->user_profile_photo) : asset('storage/no-photo.jpg') }}"
                                                                            alt="" class="img-fluid">
                                                                        <p class="mb-0">{{ $project->user_name }}</p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="project-hire-info">
                                                        <div class="content-divider"></div>
                                                        <div class="projects-amount">
                                                            @if($project->hired)
                                                                <h3>€{{ $project->hired->price }}</h3>
                                                                <h5>
                                                                    @if($project->status == 3 || $project->status == 4)
                                                                        {{ language('Taken Price') }}
                                                                    @else
                                                                        {{ language('Hired Price') }}
                                                                    @endif
                                                                </h5>
                                                            @else
                                                                @if($project->price > 0)
                                                                    <h3>€{{ $project->price }}</h3>
                                                                @endif
                                                                <h5>
                                                                    @if($project->price_type == 1)
                                                                        {{ language('Fixed Price') }}
                                                                    @elseif($project->price_type == 2)
                                                                        {{ language('Hourly Pricing') }}
                                                                    @else
                                                                        {{ language('Bidding Price') }}
                                                                    @endif
                                                                </h5>
                                                            @endif
                                                        </div>
                                                        <div class="content-divider"></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /project list -->
                        @endforeach
                    @else
                        {{ language('Not Result') }}
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')

    @include('frontend.dashboard.employer._projectNavScript', ['user' => $user])
@endsection
