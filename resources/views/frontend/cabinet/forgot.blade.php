@extends('frontend.layouts.index')

@section('title',empty(language('frontend.forgot.title')) ? language('frontend.forgot.name') : language('frontend.forgot.title'))
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
                                    <h3>{{ language('frontend.forgot.find_your_account') }}</h3>
                                    <p>{{ language('frontend.forgot.text1') }}</p>
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

                                <form action="{{ route('frontend.forgot.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group form-focus">
                                        <input name="email" type="email" class="form-control floating" value="{{ old('email', $user->email) }}">
                                        <label class="focus-label">{{ language('frontend.forgot.your_email') }}</label>
                                        @if($errors->has('email'))
                                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ language('frontend.forgot.find_out_password') }}</button>
                                    <div class="row form-row">
                                        <div class="col-6 text-start">
                                            <a class="forgot-link" href="{{ route('frontend.login.index') }}">{{ language('frontend.forgot.remember_your_password') }}</a>
                                        </div>
                                        <div class="col-6 text-end dont-have">{{ language('frontend.forgot.new_to_frelance') }} <a href="{{ route('frontend.cabinet.register') }}"> {{ language('frontend.forgot.sign_up') }}</a></div>
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

