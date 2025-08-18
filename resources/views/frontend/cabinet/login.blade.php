@extends('frontend.layouts.index')

@section('title',empty(language('frontend.login.title')) ? language('frontend.login.name') : language('frontend.login.title'))
@section('keywords', language('frontend.login.keywords') )
@section('description',language('frontend.login.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">

                    <!-- Login Content -->
                    <div class="account-content">
                        <div class="align-items-center justify-content-center">
                            <div class="login-right">
                                <div class="login-header text-center">
                                    <a href="{{route('frontend.home.index')}}"><img width="220" height="30" src="{{ asset('build/website/images/logo.png') }}" alt="{{ language('general.title') }}" class="img-fluid"></a>
                                    <h3>{{ language('frontend.login.welcome_back') }}</h3>
                                    <p>{{ language('frontend.login.text1') }}</p>
                                </div>

                                @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul style="margin: 0 0 0 20px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('frontend.login.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group form-focus">
                                        <input name="email" type="email" class="form-control floating" value="{{ old('name') }}">
                                        <label class="focus-label">{{ language('frontend.login.your_email') }}</label>
                                        @if($errors->has('email'))
                                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group form-focus">
                                        <input name="password" type="password" class="form-control floating" value="" autocomplete="off">
                                        <label class="focus-label">{{ language('frontend.login.password') }}</label>
                                        @if($errors->has('password'))
                                            <div class="error text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="custom_check">
                                            <input name="remember" type="checkbox" id="remember-me" value="1">
                                            <span class="checkmark"></span> {{ language('frontend.login.remember_me') }}
                                        </label>
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ language('frontend.login.sing_in') }}</button>

                                    <div class="row">
                                        <div class="col-6 text-start">
                                            <a class="forgot-link" href="{{ route('frontend.forgot.index') }}">{{ language('frontend.login.forgot') }}</a>
                                        </div>
                                        <div class="col-6 text-end dont-have">{{ language('frontend.login.new_to_frelance') }} <a href="{{ route('frontend.cabinet.register') }}"> {{ language('frontend.login.sign_up') }}</a></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Login Content -->

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

