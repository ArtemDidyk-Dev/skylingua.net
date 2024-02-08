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
                        <h3>{{ language('Complated Projects') }}</h3>
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
                                                                <h3 class="client-price me-2">
                                                                    {{ $project->hired_price }}{{ language('frontend.currency') }}</h3>
                                                                <p class="amnt-type">(
                                                                    {{ language('Estimated') }} {{ $project->hired_hours }} {{ language('Days') }} )</p>
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
                                                                    <li>
                                                                        <i class="fas fa-star text-primary"></i>
                                                                        {{ $project->review_count }}
                                                                        {{ language('Reviews') }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="content-divider"></div>
                                                        <div class="projects-action text-start project">
                                                            <a href="{{ route('frontend.project.detail', $project->id) }}"
                                                               class="projects-btn project">{{ language('View Details') }}</a>
                                                            <p class="hired-detail">{{ language('Project complete on') }}</p>
                                                            <p class="hired-date">{{ $project->hired_updated_at_view }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 d-flex flex-wrap">
                                        <div class="projects-card flex-fill">
                                            <div class="card-body text-center">

                                                <div class="projects-details align-items-center">
                                                    <div class="text-center project mt-3">
                                                        @if($project->review_true == false)
                                                        <a
                                                            data-bs-toggle="modal"
                                                            href="#review-project"
                                                            class="btn projects-btn project d-inline-block reviewPrpject"
                                                            data-project_id="{{ $project->id }}">
                                                            <i class="fas fa-comment"></i>
                                                            {{ language('Review') }}
                                                        </a>
                                                        @endif

                                                        @if($project->hired_status == 2)
                                                            <h4 class="waiting-badge"><span><i
                                                                        class="fas fa-clock me-2"></i></span>{{ language('Waiting confirmation') }}</h4>
                                                        @else
                                                            <h4 class="completed-badge"><span><i
                                                                        class="fas fa-medal me-2"></i></span>{{ language('Completed') }}
                                                            </h4>
                                                        @endif

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



    <!-- The reviewModal -->
    <div class="modal fade custom-modal" id="review-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-modal">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="port-title text-center pt-0 mb-4">
                        <h3>{{ language('Write a comment for the employer') }}</h3>
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


                    <form id="review-form" action="{{ route('frontend.dashboard.freelancer.project-completed.review') }}"
                          method="POST">
                        @csrf

                        <input class="project_id" type="hidden" name="project_id" value="">

                        <div class="modal-info">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <div class="star-rating">
                                            <span class="my-rating"></span>
                                            <span class="live-rating">0.0</span>
                                        </div>
                                        <input name="rating" id="rating" type="hidden" value="0">
                                    </div>
                                    <div class="form-group reivew_block">
                                        <textarea class="form-control" name="review" id="review" rows="5"
                                                  placeholder="Your review"></textarea>
                                        <span id="reivew_simvols">200</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section text-center">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn"><i
                                    class="fas fa-check"></i> {{ language('Send Review') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The reviewModal -->

@endsection


@section('CSS')
    <!-- RateIt CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/star-rating-svg/css/star-rating-svg.css')}}">
@endsection

@section('JS')
    <!-- RateIt JS -->
    <script src="{{ asset('frontend/assets/plugins/star-rating-svg/jquery.star-rating-svg.js')}}"></script>

    <script>
        var max = 200;
        var input = $('#review-form #review'),
            count = $('#review-form #reivew_simvols').text(max);

        // input.keypress(function(e) {
        input.bind('keydown', function (e) {
            setTimeout(function () {
                let input_length = input.val().length;
                input_length = max - input_length;
                count.text(input_length);
            }, 4);

            if (e.which < 0x20) {
                // e.which < 0x20, then it's not a printable character
                // e.which === 0 - Not a character
                return;     // Do nothing
            }
            if (this.value.length == max) {
                e.preventDefault();
            } else if (this.value.length > max) {
                // Maximum exceeded
                this.value = this.value.substring(0, max);
            }
        });


        $("#review-form .star-rating .my-rating").starRating({
            unload: false,
            starSize: 25,
            disableAfterRate: false,
            onHover: function (currentIndex, currentRating, $el) {
                $('#review-form .star-rating .live-rating').text(currentIndex);
            },
            onLeave: function (currentIndex, currentRating, $el) {
                $('#review-form .star-rating .live-rating').text(currentRating);
            },
            callback: function (currentRating, $el) {
                $('#review-form #rating').val(currentRating);
            }
        });
    </script>

    <script>
        $('.reviewPrpject').on('click', function (event) {
            let project_id = $(this).data('project_id');
            $('#review-project .project_id').val(project_id);
        });
    </script>

    @include('frontend.dashboard.freelancer._projectNavScript', ['user' => $user])
@endsection

