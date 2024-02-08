@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="page-title">
                        <h3>{{ language('Ongoing Projects') }}</h3>
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

                    @include('frontend.dashboard.freelancer._projectNav', ['user' => $user])

                    @if($projects)
                        @foreach($projects as $project)
                            <!-- project list -->
                            <div class="my-projects-list">
                                <div class="row">
                                    <div class="col-lg-10 flex-wrap">
                                        <div class="projects-card flex-fill">
                                            <div class="card-body">
                                                <div class="projects-details align-items-center">
                                                    <div class="project-info project">
                                                        <span>{{ $project->user_categories_name }}</span>
                                                        <h2>
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a>
                                                        </h2>
                                                        <div class="proposal-client">
                                                            <h4 class="title-info">{{ language('Accepted Price') }}</h4>
                                                            <div class="d-flex">
                                                                <h3 class="client-price me-2">{{ $project->hired_price }}{{ language('frontend.currency') }}</h3>
                                                                <p class="amnt-type">( {{ language('Estimated') }} {{ $project->hired_hours }} {{ language('Days') }} )</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="project-hire-info project">
                                                        <div class="content-divider"></div>
                                                        <div class="proposer-info project">
                                                            <div class="proposer-img">
                                                                <a href="{{ route('frontend.profile.index', $project->user_id) }}"
                                                                   target="_blank"><img
                                                                        src="{{ $project->user_profile_photo }}"
                                                                        alt="{{ $project->user_name }}"
                                                                        class="img-fluid"></a>
                                                            </div>
                                                            <div class="proposer-detail">
                                                                <h4>
                                                                    <a href="{{ route('frontend.profile.index', $project->user_id) }}"
                                                                       target="_blank">{{ $project->user_name }}</a>
                                                                </h4>
                                                                <ul class="proposal-details">
                                                                    <li>{{ $project->user_category_name }}</li>
                                                                    <li><i class="fas fa-star text-primary"></i> {{ $project->review_count }} {{ language('Reviews') }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="content-divider"></div>
                                                        <div class="projects-action text-start project">
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}"
                                                               class="projects-btn project">{{ language('View Details') }}</a>
                                                            <p class="hired-detail">{{ language('Project taken on') }}</p>
                                                            <p class="hired-date">{{ $project->hired_updated_at_view }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 d-flex flex-wrap">
                                        <div class="projects-card flex-fill">
                                            <div class="card-body text-center pt-3">

                                                <div class="projects-details align-items-center">
                                                    <div class="text-center project mt-5">
                                                        <a
                                                            data-bs-toggle="modal"
                                                            href="#complete-project"
                                                            class="btn btn-success projects-btn project d-inline-block hiredComplete"
                                                            data-project_id="{{ $project->id }}">
                                                            <i class="fas fa-check"></i>
                                                            {{ language('Complete') }}
                                                        </a>
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
        </div>
    </div>
    <!-- /Page Content -->



    <!-- The completeModal -->
    <div class="modal fade" id="complete-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Complete Project') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('Are you sure you complete this project?') }}</h3>
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


                    <form id="complete-form" action="{{ route('frontend.dashboard.freelancer.project-hireds.complete') }}" method="POST">
                        @csrf

                        <input class="project_id" type="hidden" name="project_id" value="">

                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn"><i class="fas fa-check"></i> {{ language('Complete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The completeModal -->


@endsection


@section('CSS')
@endsection

@section('JS')
    <script>
        $('.hiredComplete').on('click', function (event) {
            let project_id = $(this).data('project_id');
            $('#complete-project .project_id').val(project_id);
        });

        $('.hiredCancel').on('click', function (event) {
            let project_id = $(this).data('project_id');
            $('#cancel-project .project_id').val(project_id);
        });
    </script>

    @include('frontend.dashboard.freelancer._projectNavScript', ['user' => $user])
@endsection

