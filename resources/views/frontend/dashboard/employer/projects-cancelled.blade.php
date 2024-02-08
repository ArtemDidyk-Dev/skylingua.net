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
                        <h3>{{ language('Cancelled Projects') }}</h3>
                    </div>
                    @include('frontend.dashboard.employer._projectNav', ['user' => $user])

                    @if($projects)
                        @foreach($projects as $project)
                            <!-- project list -->
                            <div class="my-projects-list">
                                <div class="row">
                                    <div class="col-lg-10 flex-wrap">
                                        <div class="projects-delete-details flex-fill">
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
                                                                            <span
                                                                                class="badge badge-danger">{{ language('Canceled') }}</span>
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
                                                                <h3>{{ $project->hired->price }}{{ language('frontend.currency') }}</h3>
                                                                <h5>{{ language('Hired Price') }}</h5>
                                                            @endif
                                                        </div>
                                                        <div class="content-divider"></div>
                                                        <div class="projects-action text-center">
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}"
                                                               class="projects-btn">{{ language('View Project') }}</a>
                                                            <a
                                                                data-bs-toggle="modal"
                                                                href="#repost-project"
                                                                class="btn btn-danger projects-btn project d-inline-block repostProject"
                                                                data-project_id="{{ $project->id }}">
                                                                {{ language('Repost') }}
                                                            </a>
                                                            @if($project->hired)
                                                                <p class="hired-detail">{{ language('Canceled on') }} {{ \Carbon\Carbon::parse($project->hired->updated_at)->format('M d, Y') }}</p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 d-flex flex-wrap">
                                        <div class="projects-delete-details flex-fill">
                                            <div class="card-body p-2">

                                                @if($project->hired)
                                                    <a href="{{ route('frontend.profile.index', $project->hired->freelancer_id) }}"
                                                       class="prj-proposal-count text-center hired">
                                                        <h3>{{ language('Canceled') }}</h3>
                                                        <img
                                                            src="{{ !empty($project->hired->user_profile_photo) ? asset('storage/profile/'. $project->hired->user_profile_photo) : asset('storage/no-photo.jpg') }}"
                                                            alt="" class="img-fluid">
                                                        <p class="mb-0">{{ $project->hired->user_name }}</p>
                                                    </a>
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


    <!-- The repostModal -->
    <div class="modal fade" id="repost-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Repost Project') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('Are you sure you repost this project?') }}</h3>
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0 0 0 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form id="repost-form" action="{{ route('frontend.dashboard.employer.projects-repost') }}" method="POST">
                        @csrf

                        <input class="project_id" type="hidden" name="project_id" value="">

                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('No') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn">{{ language('Yes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The repostModal -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <script>
        $('.repostProject').on('click', function (event) {
            let project_id = $(this).data('project_id');
            $('#repost-project .project_id').val(project_id);
        });
    </script>

    @include('frontend.dashboard.employer._projectNavScript', ['user' => $user])
@endsection

