@extends('frontend.layouts.index')

@section('title',empty(language('frontend.forgot.password_reset')) ? language('frontend.forgot.name') : language('frontend.forgot.title'))
@section('keywords', language('frontend.forgot.keywords') )
@section('description',language('frontend.forgot.description') )


@section('content')



    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-6 offset-md-3">

                    <!-- Forgot Password Content -->
                    <div class="account-content">
                        <div class="align-items-center justify-content-center">
                            <div class="login-right">
                                <div class="login-header text-center">
                                    <a href="{{route('frontend.home.index')}}"><img width="220" height="30" src="{{ asset('build/website/images/logo.png') }}" alt="{{ language('general.title') }}" class="img-fluid"></a>
                                    <h3>{{ language('frontend.forgot.password_reset') }}</h3>
                                    <p>{{ language('frontend.forgot.password_reset_text') }}</p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('frontend.password_resets.store') }}" method="POST">
                                    @csrf
                                    <input name="email" type="hidden" value="{{ old('email', $data['email']) }}">
                                    <input name="token" type="hidden" value="{{ old('token', $data['token']) }}">
                                    <div class="form-group form-focus">
                                        <input name="password" type="password" class="form-control floating" value="" autocomplete="false">
                                        <label class="focus-label">{{ language('frontend.register.password') }}</label>
                                        @if($errors->has('password'))
                                            <div class="error text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group form-focus">
                                        <input name="password_confirmation" type="password" class="form-control floating" value="" autocomplete="false">
                                        <label class="focus-label">{{ language('frontend.register.confirm_password') }}</label>
                                        @if($errors->has('password_confirmation'))
                                            <div class="error text-danger">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ language('frontend.common.submit') }}</button>
                                    <div class="row form-row">
                                        <div class="col-6 text-start">
                                            <a class="forgot-link" href="{{ route('frontend.login.index') }}">{{ language('frontend.forgot.remember_your_password') }}</a>
                                        </div>
                                        <div class="col-6 text-end dont-have">

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Forgot Password Content -->

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

