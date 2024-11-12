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
                        <h3>{{ language('Ongoing Services') }}</h3>
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
                                                        <div class="proposal-client">
                                                            <h4 class="title-info">{{ language('Accepted Price') }}</h4>
                                                            <div class="d-flex">
                                                                <h3 class="client-price me-2">{{ $project->price }}{{ language('frontend.currency') }}</h3>
                                                                <p class="amnt-type">( {{ language('Estimated') }} {{ $project->hours}} {{ language('Days') }} )</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="project-hire-info project">
                                                        <div class="content-divider"></div>
                                                        <div class="proposer-info project">
                                                            <div class="proposer-img">
                                                                <a
                                                                    target="_blank"><img
                                                                        src="{{ $project->employer->profile_photo ? asset('storage/profile/' .$project->employer->profile_photo) : asset('storage/no-image.jpg') }}"
                                                                        alt="{{ $project->employer->name}}"
                                                                        class="img-fluid"></a>
                                                            </div>
                                                            <div class="proposer-detail">
                                                                <h4>
                                                                    <a
                                                                        target="_blank">{{ $project->employer->name}}</a>
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
                                                            data-employer_id="{{ $project->employer->id }}"
                                                            data-id={{$project->id}}
                                                        >
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
                        <p>{{ language('No Services') }}</p>
                    @endif




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
                    <h4>{{ language('Complete Service') }}</h4>
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

                        <input class="project_id" type="hidden" name="employer_id" value="">
                        <input type="hidden"  name="id" value="id" class="id"  >
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
            let employer_id = $(this).data('employer_id');
            $('#complete-project .project_id').val(employer_id);
        });

        $('.hiredCancel').on('click', function (event) {
            let employer_id = $(this).data('employer_id');
            $('#cancel-project .project_id').val(employer_id);
        });

        $('.hiredComplete').on('click', function (event) {
            let id = $(this).data('id');
            $('#complete-project .id').val(id);
        });

        $('.hiredCancel').on('click', function (event) {
            let id= $(this).data('id');
            $('#cancel-project .id').val(id);
        });
    </script>

    @include('frontend.dashboard.freelancer._projectNavScript', ['user' => $user])
@endsection
