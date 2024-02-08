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
                        <h3>{{ language('Proposals') }}</h3>
                    </div>
                    @include('frontend.dashboard.employer._projectNav', ['user' => $user])


                    <!-- project list -->
                    <div class="my-projects-list">
                        <div class="row">
                            <div class="col-lg-10 flex-wrap">
                                <div class="projects-card flex-fill">
                                    <div class="card-body">
                                        <div class="projects-details align-items-center">
                                            <div class="project-info">
                                                @if($project->projects_categories)
                                                    @foreach($project->projects_categories as $projects_category)
                                                        <span class="me-2">{{ $projects_category->user_category_name }}</span>
                                                    @endforeach
                                                @endif
                                                <h2>
                                                    <a href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a>
                                                </h2>
                                                <div class="customer-info">
                                                    <ul class="list-details">
                                                        <li>
                                                            <div class="slot">
                                                                <p>{{ language('Status') }}</p>
                                                                <h5>
                                                                    @if($project->status == 0)
                                                                        <span class="badge badge-warning">{{ language('Unpublished') }}</span>
                                                                    @else
                                                                        <span class="badge badge-success">{{ language('Published') }}</span>
                                                                    @endif
                                                                </h5>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="slot">
                                                                <p>{{ language('Location') }}</p>
                                                                <h5>
                                                                    <img src="{{ $project->user_country_image }}" height="13" alt="">
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
                                                </div>
                                                <div class="content-divider"></div>
                                                <div class="projects-action">
                                                    <a href="{{ route('frontend.project.detail',
                                                    $project->id) }}"
                                                       class="projects-btn">{{ language('View Project') }}</a>
                                                    <a href="{{ route('frontend.dashboard.employer.employerProjectEdit',
                                                    $project->id) }}" class="projects-btn">{{ language('Edit Project') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex flex-wrap">
                                <div class="projects-card flex-fill">
                                    <div class="card-body p-2">
                                        <a href="{{ route('frontend.dashboard.employer.project.proposals', $project->id) }}" class="prj-proposal-count text-center">
                                            <span>{{ $project->proposals_count }}</span>
                                            <h3>{{ language('Proposals') }}</h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /project list -->

                    @if($proposals)
                        <!-- Proposals list -->
                        <div class="proposals-section mb-4">
                            <h3 class="page-subtitle">{{ language('Proposals By freelancer') }}</h3>
                            <div class="proposal-card">

                                @foreach($proposals as $proposal)
                                    <!-- Proposals -->
                                    <div class="project-proposals align-items-center">
                                        <div class="proposals-info">
                                            <div class="proposer-info">
                                                <div class="proposer-img">
                                                    <img src="{{ $proposal->user_profile_photo }}" alt="{{ $proposal->user_name }}" class="img-fluid">
                                                </div>
                                                <div class="proposer-detail">
                                                    <h4>{{ $proposal->user_name }}</h4>
                                                    <ul class="proposal-details">
                                                        <li> {{ $proposal->updated_at_view }}</li>
                                                        <li><i class="fas fa-star text-primary"></i> {{ $proposal->reviews_count }} {{ language('Reviews') }}</li>
                                                        <li><a href="{{ route('frontend.profile.index', $proposal->freelancer_id) }}"
                                                               class="font-semibold text-primary">{{ language('View Profile') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="proposer-bid-info">
                                                <div class="proposer-bid">
                                                    <h3>{{ $proposal->price_view }}{{ language('frontend.currency') }}</h3>
                                                    <h5>{{ language('Estimated') }} {{ $proposal->hours }} {{ language('Days') }}</h5>
                                                </div>
                                                <div class="proposer-confirm">
                                                    <a
                                                            data-bs-toggle="modal"
                                                            href="#hire-project"
                                                            class="projects-btn hireProject"
                                                            data-freelancer_id="{{ $proposal->freelancer_id }}"
                                                    >{{ language('Hire Now') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        @if($proposal->letter)
                                            <div class="description-proposal">
                                                <p>{{ $proposal->letter }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Proposals -->
                                @endforeach


                            </div>
                        </div>
                        <!-- /Proposals list -->
                    @endif

                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- The hireModal -->
        <div class="modal fade" id="hire-project">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>{{ language('Hire Project') }}</h4>
                        <span class="modal-close">
                        <a href="#" data-bs-dismiss="modal" aria-label="{{ language('Close') }}">
                            <i class="far fa-times-circle orange-text"></i>
                        </a>
                    </span>
                    </div>
                    <div class="modal-body text-center">
                        <div class="port-title">
                            <h3>{{ language('Are you sure to choose this freelancer?') }}</h3>
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


                        <form id="hire-form" action="{{ route('frontend.pay.go') }}" method="POST">
                            @csrf

                            @if(session()->exists('proposal.freelancer_id'))
                                <input id="freelancer_id" type="hidden" name="freelancer_id" value="{{ session()->get('proposal.freelancer_id') }}">
                            @else
                                <input id="freelancer_id" type="hidden" name="freelancer_id" value="{{ old('freelancer_id', app('request')->freelancer_id) }}">
                            @endif
                            <input id="project_id" type="hidden" name="project_id" value="{{ $project->id }}">


                            @if(session()->exists('proposal.id'))
                                <div class="p-3 pb-0 mb-4 text-left" style="background-color: #f7f7f9; text-align: left">
                                    <div class="row">
                                        @if(session()->exists('proposal.price'))
                                            <div class="col-md-6 form-group">
                                                <label for="price" class="d-block">{{ language('Price') }}</label>
                                                {{ session()->get('proposal.price') }}£
                                            </div>
                                        @endif
                                        @if(session()->exists('proposal.hours'))
                                            <div class="col-md-6 form-group">
                                                <label for="hours" class="d-block">{{ language('Estimated') }}</label>
                                                {{ session()->get('proposal.hours') }} {{ language('days') }}
                                            </div>
                                        @endif
                                        @if(session()->exists('proposal.letter'))
                                            <div class="col-md-12 form-group">
                                                <label for="letter" class="d-block">{{ language('Letter') }}</label>
                                                {{ session()->get('proposal.letter') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="submit-section text-right">
                                <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary submit-btn">{{ language('Hire&Pay') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-2 mb-4 payment_address text-center">
                            {{ setting('address',true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /The hireModal -->

        @endsection


        @section('CSS')
        @endsection

        @section('JS')
            <script>
                $('.hireProject').on('click', function (event) {

                    let freelancer_id = $(this).data('freelancer_id');
                    $('#hire-form #freelancer_id').val(freelancer_id);

                });
            </script>
            @if(session()->exists('freelancer_id'))
                <script>
                    $('#hire-project').modal('toggle');
                </script>
    @endif

    @include('frontend.dashboard.employer._projectNavScript', ['user' => $user])
@endsection

