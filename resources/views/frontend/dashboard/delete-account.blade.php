@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @if ($user->role_id == 3)
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                    @elseif ($user->role_id == 4)
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                    @endif
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="pro-pos">
                        @if ($user->role_id == 3)
                        @include('frontend.dashboard.employer._profileNav', ['user' => $user])
                        @elseif ($user->role_id == 4)
                        @include('frontend.dashboard.freelancer._profileNav', ['user' => $user])
                        @endif

                        <div class="setting-content">
                            <div class="pro-card">
                                <div class="pro-head">
                                    <h3 class="pro-title without-border mb-0">{{ language('Delete Account') }}</h3>
                                </div>
                                <div class="pro-body">


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

                                    <form id="submit-form" action="{{ route('frontend.dashboard.delete-account.store') }}" id="submit-form" method="POST">
                                        @csrf

                                        <input type="hidden" name="user_id" value="{{ $user->id }}">


                                        <div class="form-group">
                                            <label for="reason">{{ language('Please Explain Further**') }}</label>
                                            <textarea id="reason" name="reason" class="form-control" rows="5">{{ old('reason') }}</textarea>
                                            @error('reason')<span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">{{ language('Password*') }}</label>
                                            <input autocomplete="OFF" id="password" type="password" name="password" value="" class="form-control" />
                                            @error('password' )<span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a class="btn btn-primary click-btn btn-plan" data-bs-toggle="modal" href="#delete-acc">{{ language('Delete Account') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- The Modal -->
    <div class="modal fade custom-modal" id="delete-acc">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body del-modal">
                    <div class="text-center pt-0 mb-5">
                        <i class="fas fa-exclamation-triangle fa-3x"></i>
                        <h3>{{ language('Are you sure? Want to delete Account') }}</h3>
                    </div>
                    <div class="submit-section text-center">
                        <button data-bs-dismiss="modal" class="btn btn-primary black-btn click-btn btn-plan">{{ language('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary click-btn btn-plan" form="submit-form">{{ language('Submit') }}</button>
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
@endsection

