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
                        <h3>{{ language('Completed Services') }}</h3>
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
                            <!-- project list -->
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
                                                                            <span
                                                                                class="badge badge-success">{{ language('Completed') }}</span>
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
                                                                <h5>{{ language('Taken Price') }}</h5>
                                                            @endif
                                                        </div>
                                                        <div class="content-divider"></div>
                                                        <div class="projects-action text-center">

                                                            @if(!$project->accept)
                                                                <a
                                                                    data-bs-toggle="modal"
                                                                    href="#accept-project"
                                                                    class="btn btn-success projects-btn d-inline-block acceptPrpject"
                                                                    data-freelancer_id="{{ $project->freelancer->id }}"
                                                                    data-id={{$project->id}}
                                                                >

                                                                    <i class="fas fa-check"></i>
                                                                    {{ language('Accept Job') }}
                                                                </a>

                                                                <a
                                                                    data-bs-toggle="modal"
                                                                    href="#correct-project"
                                                                    class="projects-btn d-inline-block correctPrpject"
                                                                    data-freelancer_id="{{ $project->freelancer->id}}"
                                                                    data-id={{$project->id}}
                                                                >
                                                                    <i class="fas fa-check"></i>
                                                                    {{ language('Correction Job') }}
                                                                </a>
                                                            @else
                                                                <h4 class="completed-badge"><span><i
                                                                            class="fas fa-medal me-2"></i></span>{{ language('Completed') }}
                                                                </h4>
                                                            @endif

                                                            @if($project->hired)
                                                                <p class="hired-detail">{{ language('Completed on') }} {{ \Carbon\Carbon::parse($project->hired->updated_at)->format('M d, Y') }}</p>
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
                                                @if($project->status)
                                                    <a href="{{ route('frontend.profile.index', $project->freelancer->id) }}"
                                                       class="prj-proposal-count text-center hired">
                                                        <h3>{{ language('Completed') }}</h3>
                                                        <img
                                                            src="{{ !empty($project->freelancer->profile_photo) ? asset('storage/profile/'. $project->freelancer->profile_photo) : asset('storage/no-photo.jpg') }}"
                                                            alt="" class="img-fluid">
                                                        <p class="mb-0">{{ $project->freelancer->user_name }}</p>
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


                </div>
            </div>
        </div>
    </div>

    <!-- /Page Content -->


    <!-- The acceptModal -->
    <div class="modal fade custom-modal" id="accept-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-modal">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="port-title text-center pt-0 mb-4">
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


                    <form id="accept-form" action="{{ route('frontend.dashboard.employer.projects-completed.accept') }}"
                          method="POST">
                        @csrf

                        <input class="freelancer_id" type="hidden" name="freelancer_id" value="">
                        <input class="id" type="hidden" name="id" value="">
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
                                    class="fas fa-check"></i> {{ language('Review & Accept') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The acceptModal -->


    <!-- The correctModal -->
    <div class="modal fade custom-modal" id="correct-project">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-modal">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="port-title text-center pt-0 mb-4">
                        <h3>{{ language('Are you sure you correct this project?') }}</h3>
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


                    <form id="correct-form" action="{{ route('frontend.dashboard.employer.projects-completed.correct') }}"
                          method="POST">
                        @csrf

                        <input class="freelancer_id" type="hidden" name="freelancer_id" value="">
                        <input class="id" type="hidden" name="id" value="">

                        <div class="modal-info">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="letter" id="letter" rows="5"
                                                  placeholder="{{ language('Your letter') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section text-center">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn"><i
                                    class="fas fa-check"></i> {{ language('Send Correcting') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The correctModal -->


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
        var input = $('#accept-form #review'),
            count = $('#accept-form #reivew_simvols').text(max);

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


        $("#accept-form .star-rating .my-rating").starRating({
            unload: false,
            starSize: 25,
            disableAfterRate: false,
            onHover: function (currentIndex, currentRating, $el) {
                $('#accept-form .star-rating .live-rating').text(currentIndex);
            },
            onLeave: function (currentIndex, currentRating, $el) {
                $('#accept-form .star-rating .live-rating').text(currentRating);
            },
            callback: function (currentRating, $el) {
                $('#accept-form #rating').val(currentRating);
            }
        });
    </script>

    <script>
        $('.acceptPrpject').on('click', function (event) {
            let freelancer_id = $(this).data('freelancer_id');
            $('#accept-project .freelancer_id').val(freelancer_id);
        });

        $('.correctPrpject').on('click', function (event) {
            let freelancer_id = $(this).data('freelancer_id');
            $('#correct-project .freelancer_id').val(freelancer_id);
        });

        $('.acceptPrpject').on('click', function (event) {
            let id = $(this).data('id');
            $('#accept-project .id').val(id);
        });

        $('.correctPrpject').on('click', function (event) {
            let id = $(this).data('id');
            $('#correct-project .id').val(id);
        });
    </script>


    @include('frontend.dashboard.employer._projectNavScript', ['user' => $user])
@endsection
