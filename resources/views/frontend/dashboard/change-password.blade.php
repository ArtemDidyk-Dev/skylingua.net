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

                        <!-- Password Content -->
                        <div class="account-content setting-content">
                            <div class="pro-card">
                                <div class="pro-head">
                                    <h3 class="pro-title without-border mb-0">{{ language('Change Password') }}</h3>
                                </div>
                                <div class="pro-body">
                                    <div class="row">
                                        <div class="col-md-8">

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

                                            <form id="submit-form" action="{{ route('frontend.dashboard.change-password.store') }}" method="POST">
                                                @csrf

                                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                <div class="form-group">
                                                    <label for="old_password">{{ language('Old Password') }}</label>
                                                    <input autocomplete="OFF" id="old_password" type="password" name="old_password" value="" class="form-control" />
                                                    @error('old_password' )<span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">{{ language('New Password') }}</label>
                                                    <input autocomplete="OFF" id="new_password" type="password" name="new_password" value="" class="form-control" />
                                                    @error('new_password' )<span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">{{ language('Confirm Password') }}</label>
                                                    <input autocomplete="OFF" id="confirm_password" type="password" name="confirm_password" value="" class="form-control" />
                                                    @error('confirm_password' )<span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary click-btn btn-plan" type="submit">{{ language('Update') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Password Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
@endsection

