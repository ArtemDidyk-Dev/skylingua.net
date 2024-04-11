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

                    @if($projects)
                        @foreach($projects as $project)
                            <!-- Services list -->
                            <div class="my-projects-list">
                                <div class="row">
                                    <div class="col-lg-10 flex-wrap">
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
                                                                        <p>{{ language('Status') }}</p>
                                                                        <h5>
                                                                            @if($project->status == 1)
                                                                                <span class="badge badge-success">{{ language('Published') }}</span>
                                                                            @elseif($project->status == 2)
                                                                                <span class="badge badge-warning">{{ language('Pending') }}</span>
                                                                            @elseif($project->status == 3)
                                                                                <span class="badge badge-info">{{ language('Ongoing') }}</span>
                                                                            @elseif($project->status == 4)
                                                                                <span class="badge badge-success">{{ language('Completed') }}</span>
                                                                            @elseif($project->status == 5)
                                                                                <span class="badge badge-danger">{{ language('Canceled') }}</span>
                                                                            @else
                                                                                <span class="badge badge-secondary">{{ language('Unpublished') }}</span>
                                                                            @endif
                                                                        </h5>
                                                                    </div>
                                                                    <div class="slot mt-2">
                                                                        <p>{{ language('Approve') }}</p>
                                                                        <h5>
                                                                            @if($project->approve == 1)
                                                                                <span class="badge bg-success text-white">{{ language('Yes') }}</span>
                                                                            @else
                                                                                <span class="badge bg-danger text-white">{{ language('No') }}</span>
                                                                            @endif
                                                                        </h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="slot">
                                                                        <p>{{ language('Location') }}</p>
                                                                        <h5>
                                                                            <img
                                                                                src="{{ $project->user_country_image }}"
                                                                                height="13" alt="">
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
                                                            @if($project->hired)
                                                                <h3>${{ $project->hired->price }}</h3>
                                                                <h5>
                                                                    @if($project->status == 3 || $project->status == 4)
                                                                    {{ language('Taken Price') }}
                                                                    @else
                                                                    {{ language('Hired Price') }}
                                                                    @endif
                                                                </h5>
                                                            @else
                                                                @if($project->price > 0)
                                                                    <h3>${{ $project->price }}</h3>
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
                                                        <div class="projects-action text-center">
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}"
                                                               class="projects-btn">{{ language('View Services') }}</a>
                                                            @if($project->status <=1)
                                                            <a href="{{ route('frontend.dashboard.employer.employerProjectEdit',
                                                    $project->id) }}" class="projects-btn mb-2">{{ language('Edit Services') }}</a>
                                                            @elseif($project->status == 5)
                                                            <a href="#" class="projects-btn">{{ language('Repost') }} </a>
                                                            @endif


                                                            @if($project->status == 0 || $project->status == 1)
                                                            <form action="{{route('frontend.dashboard.employer.employerProjectPublish')}}" enctype="multipart/form-data" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $project->id }}">
                                                                @if($project->status == 0)
                                                                <button name="publish" value="1" class="projects-btn btn-success click-btn b-0" type="submit">{{ language('Publish Services') }}</button>
                                                                @elseif($project->status == 1)
                                                                <button name="publish" value="0" class="projects-btn btn-unpublish click-btn b-0" type="submit">{{ language('Unpublish Services') }}</button>
                                                                @endif
                                                            </form>
                                                            @endif

                                                            @if($project->hired)
                                                            <p class="hired-detail">
                                                                @if($project->status == 3 || $project->status == 4)
                                                                {{ language('Taken on') }} {{ \Carbon\Carbon::parse($project->hired->updated_at)->format('M d, Y') }}
                                                                @elseif($project->status == 5)
                                                                    {{ language('Canceled on') }} {{ \Carbon\Carbon::parse($project->hired->updated_at)->format('M d, Y') }}
                                                                @else
                                                                {{ language('Hired on') }} {{ \Carbon\Carbon::parse($project->hired->created_at)->format('M d, Y') }}
                                                                @endif
                                                            </p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 d-flex flex-wrap">
                                        <div class="projects-card flex-fill">
                                            <div class="card-body p-2">

                                                @if($project->hired)
                                                    <a href="{{ route('frontend.profile.index', $project->hired->freelancer_id) }}" class="prj-proposal-count text-center hired">
                                                        <h3>
                                                            @if($project->status == 3)
                                                            {{ language('Ongoing') }}
                                                            @elseif($project->status == 4)
                                                            {{ language('Completed') }}
                                                            @elseif($project->status == 5)
                                                            {{ language('Canceled') }}
                                                            @else
                                                            {{ language('Hired') }}
                                                            @endif
                                                        </h3>
                                                        <img src="{{ !empty($project->hired->user_profile_photo) ? asset('storage/profile/'. $project->hired->user_profile_photo) : asset('storage/no-photo.jpg') }}" alt="" class="img-fluid">
                                                        <p class="mb-0">{{ $project->hired->user_name }}</p>
                                                    </a>
                                                @else
                                                @if($project->proposals_count > 0)
                                                    <a href="{{ route('frontend.dashboard.employer.project.proposals', $project->id) }}"
                                                       class="prj-proposal-count text-center">
                                                        <span>{{ $project->proposals_count }}</span>
                                                        <h3>{{ language('Proposals') }}</h3>
                                                    </a>
                                                @else
                                                    <div class="prj-proposal-count text-center">
                                                        <span>0</span>
                                                        <h3>{{ language('Proposals') }}</h3>
                                                    </div>
                                                    @endif
                                                @endif
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
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')

    @include('frontend.dashboard.employer._projectNavScript', ['user' => $user])
@endsection

