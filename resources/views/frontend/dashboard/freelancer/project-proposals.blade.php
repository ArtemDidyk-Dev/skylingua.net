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
                        <h3>{{ language('Proposals') }}</h3>
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

                    <!-- Proposals list -->
                    <div class="proposals-section">
                        <h3 class="page-subtitle">{{ language('My Proposals') }}</h3>

                        @if($getProposals)
                            @foreach($getProposals as $proposal)
                                <!-- Proposals -->
                                <div class="freelancer-proposals">
                                    <div class="project-proposals align-items-center freelancer">
                                        <div class="proposals-info">
                                            <div class="proposals-detail">
                                                <h3 class="proposals-title">
                                                    <a href="{{ route('frontend.project.detail', $proposal->id) }}">{{ $proposal->name }}</a>
                                                </h3>
                                                <div class="proposals-content">
                                                    @if($proposal->employer_id > 0)
                                                    <div class="proposal-img">
                                                        <div class="text-md-center">
                                                            <a href="{{ route('frontend.profile.index', $proposal->employer_id) }}"
                                                                target="_blank">
                                                                
                                                                 <img src="{{ $proposal->employer->profile_photo ? asset('storage/profile/'.  $proposal->employer->profile_photo) : asset('storage/no-image.jpg') }}"
                                                                      alt="{{ $proposal->employer->name }}" class="img-fluid">
                                                                 <h4>{{ $proposal->employer->name}}</h4>
                                                             </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="proposal-client">
                                                        <h4 class="title-info">Price</h4>
                                                        <h3 class="client-price">
                                                            @if($proposal->price > 0)
                                                                {{ $proposal->price }}{{ language('frontend.currency') }}
                                                            @else
                                                                {{ language('Bidding Price') }}
                                                            @endif
                                                        </h3>
                                                    </div>
                                                    <div class="proposal-type">
                                                        <h4 class="title-info">{{ language('Price Type') }}</h4>
                                                        <h3>
                                                            @if($proposal->type == 1)
                                                                {{ language('Fixed Price') }}
                                                            @elseif($proposal->type == 2)
                                                                {{ language('Hourly Pricing') }}
                                                            @else
                                                                {{ language('Bidding Price') }}
                                                            @endif
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="project-hire-info">
                                                <div class="content-divider-1"></div>
                                                <div class="projects-amount">
                                                    <h5>{{ language('Estimated') }} {{ $proposal->hours }} {{ language('Days') }}</h5>
                                                </div>
                                                <div class="content-divider-1"></div>
                                                <div class="projects-action text-center">
                                                    <a
                                                        data-bs-toggle="modal"
                                                        href="#proposal"
                                                        data-proposal_id="{{ $proposal->id }}"
                                                        data-proposal_price="{{ $proposal->price }}"
                                                        data-proposal_hours="{{ $proposal->hours }}"
                                                        data-proposal_letter="{{ $proposal->letter }}"
                                                        class="projects-btn editProposal"
                                                    >{{ language('Edit Proposals') }}</a>
                                                    <a
                                                        data-bs-toggle="modal"
                                                        href="#proposal-delete"
                                                        class="proposal-delete deleteProposal"
                                                        data-id="{{ $proposal->id }}"
                                                    >{{ language('Delete Proposal') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        @if( $proposal->letter)
                                            <div class="description-proposal">
                                                <p>{{ $proposal->letter }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Proposals -->
                            @endforeach
                        @else
                            <p>{{ language('No Proposals') }}</p>
                        @endif


                    </div>
                    <!-- /Proposals list -->


                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->



    <!-- The deleteModal -->
    <div class="modal fade" id="proposal-delete">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Delete Proposals') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('This proposal will be permanently deleted. Are you sure?') }}</h3>
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


                    <form id="delete-form"
                          action="{{ route('frontend.dashboard.freelancer.project-proposals.delete') }}" method="POST">
                        @csrf

                        <input id="deleteId" type="hidden" name="id" value="{{ old('id') }}">

                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn">{{ language('Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The deleteModal -->


    <!-- The Modal -->
    <div class="modal fade" id="proposal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ language('EDIT PROPOSALS') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="modal-info">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin: 0 0 0 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('frontend.dashboard.freelancer.project-proposals.edit') }}"
                              method="POST">
                            @csrf

                            <input type="hidden" name="project_id" id="project_id" value="{{ old('project_id') }}">

                            <div class="feedback-form">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="price">{{ language('Your Price') }}</label>
                                        <input name="price" id="price" type="number" min="0" step="0.01"
                                               class="form-control" placeholder="{{ language('Your Price') }}" required="required"
                                               autocomplete="OFF" value="{{ old('price') }}">
                                        @error('price' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="hours">{{ language('Estimated Days') }}</label>
                                        <input name="hours" id="hours" type="number" min="0" step="1"
                                               class="form-control" placeholder="{{ language('Example: 11 Days') }}" required="required"
                                               autocomplete="OFF" value="{{ old('hours') }}">
                                        @error('hours' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea name="letter" id="letter" rows="5" class="form-control"
                                                  placeholder="{{ language('Cover Letter') }}" autocomplete="OFF"
                                                  value="{{ old('letter') }}"></textarea>
                                        @error('letter' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 submit-section">
                                    <label class="custom_check">
                                        <input name="agree" type="checkbox" name="select_time" required="required"
                                               autocomplete="OFF" @if(old('agree')) checked="checked" @endif >
                                        <span class="checkmark"></span> {{ language('I agree to the Terms And Conditions') }}
                                    </label>
                                    @error('agree' )
                                    <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-12 submit-section text-end">
                                    <button class="btn btn-primary submit-btn" type="submit">{{ language('EDIT PROPOSAL') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /The Modal -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <!-- Jquery Cookie STAST -->
    <script src="{{ asset('frontend/assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>

    <script>
        $('.editProposal').on('click', function (event) {
            $.cookie("proposalModal", 1);

            let proposal_id = $(this).data('proposal_id');
            let proposal_price = $(this).data('proposal_price');
            let proposal_hours = $(this).data('proposal_hours');
            let proposal_letter = $(this).data('proposal_letter');

            $('#proposal #project_id').val(proposal_id);
            $('#proposal #price').val(proposal_price);
            $('#proposal #hours').val(proposal_hours);
            $('#proposal #letter').val(proposal_letter);

        });

        @if(session()->has('message'))
        $.removeCookie("proposalModal");
        @endif

        $('#proposal').on('hidden.bs.modal', function () {
            $.removeCookie("proposalModal");
        });

        $(window).on('load', function () {
            if ($.cookie("proposalModal") == 1) {
                $('#proposal').modal('show');
            }
        });

        $('.deleteProposal').on('click', function (event) {
            let proposal_id = $(this).data('id');

            $('#proposal-delete #deleteId').val(proposal_id);
        });
    </script>

    @include('frontend.dashboard.freelancer._projectNavScript', ['user' => $user])
@endsection

