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
                        <h3>{{ language('Hired Projects') }}</h3>
                    </div>
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
                                                        <h2>
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a>
                                                        </h2>
                                                        <div class="proposal-client">
                                                            <h4 class="title-info">{{ language('Hired Price') }}</h4>
                                                            <div class="d-flex">
                                                                <h3 class="client-price me-2">{{ $project->price }}{{ language('frontend.currency') }}</h3>
                                                                <p class="amnt-type">( {{ language('Estimated') }} {{ $project->hours }} {{ language('Days') }} )</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="project-hire-info project">
                                                        <div class="content-divider"></div>
                                                        <div class="proposer-info project">

                                                            <div class="proposer-detail">
                                                                <h4>
                                                                    <a
                                                                        target="_blank">{{ $project->employer->name }}</a>
                                                                </h4>

                                                            </div>
                                                        </div>
                                                        <div class="content-divider"></div>
                                                        <div class="projects-action text-start project">
                                                            <p class="hired-detail">{{ language('Project hired on') }}</p>
                                                            <p class="hired-date">{{ $project->hired_created_at_view }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if( $project->letter)
                                                    <div class="description-proposal ps-0 pe-0">
                                                        <h5 class="desc-title">Hired Letter</h5>
                                                        <p>{{ $project->letter }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 d-flex flex-wrap">
                                        <div class="projects-card flex-fill">
                                            <div class="card-body text-center">

                                                <div class="projects-details align-items-center">
                                                    <div class="text-center project mt-3">
                                                        <a
                                                            data-bs-toggle="modal"
                                                            href="#accept-project"
                                                            class="btn btn-success projects-btn project d-inline-block hiredAccept"
                                                            data-employer_id="{{ $project->employer->id }}"
                                                            data-id={{$project->id}}
                                                        >
                                                            <i class="fas fa-check"></i>
                                                            {{ language('Accept') }}
                                                        </a>
                                                        <a
                                                            data-bs-toggle="modal"
                                                            href="#cancel-project"
                                                            class="btn btn-danger projects-btn project d-inline-block hiredCancel"
                                                            data-employer_id="{{ $project->employer->id }}"
                                                            data-id={{$project->id}}
                                                        >
                                                            <i class="fas fa-ban"></i>
                                                            {{ language('Cancel') }}
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
                        <p>{{ language('No Hireds') }}</p>
                    @endif




                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


    <!-- The acceptModal -->
    <div class="modal fade" id="accept-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Accept Project') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('Are you sure you accept this project?') }}</h3>
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


                    <form id="accept-form" action="{{ route('frontend.dashboard.freelancer.project-hireds.accept') }}" method="POST">
                        @csrf
                        <input class="employer_id" type="hidden" name="employer_id" value="">
                        <input type="hidden"  name="id" value="id" class="id"  >
                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn"><i class="fas fa-check"></i> {{ language('Accept') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The acceptModal -->

    <!-- The cancelModal -->
    <div class="modal fade" id="cancel-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Cancel Project') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('Are you sure you cancel this project?') }}</h3>
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


                    <form id="cancel-form" action="{{ route('frontend.dashboard.freelancer.project-hireds.cancel') }}" method="POST">
                        @csrf

                        <input class="employer_id" type="hidden" name="employer_id" value="">
                        <input class="id" type="hidden" name="id" value="">
                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('No') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn">{{ language('Yes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The cancelModal -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <script>
        $('.hiredAccept').on('click', function (event) {
            let employer_id = $(this).data('employer_id');
            $('#accept-project .employer_id').val(employer_id);

            let id = $(this).data('id');
            $('#accept-project .id').val(id);

        });

        $('.hiredCancel').on('click', function (event) {
            let employer_id = $(this).data('employer_id');
            $('#cancel-project .employer_id').val(employer_id);

            let id = $(this).data('id');
            $('#cancel-project .id').val(id);
        });
    </script>

    @include('frontend.dashboard.freelancer._projectNavScript', ['user' => $user])
@endsection
