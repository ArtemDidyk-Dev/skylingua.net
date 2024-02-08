@extends('frontend.layouts.index')

@section('title',empty(language('frontend.register.title')) ? language('frontend.register.name') : language('frontend.register.title'))
@section('keywords', language('frontend.register.keywords') )
@section('description',language('frontend.register.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="account-content">
                        <div class="align-items-center justify-content-center">
                            <div class="login-right">
                                <div class="login-header text-center">
                                    <a href="{{route('frontend.home.index')}}"><img width="220" height="30" src="{{ asset('build/website/images/logo.png') }}" alt="{{ language('general.title') }}" class="img-fluid"></a>
                                    <h3>{{ language('frontend.register.join_freelance') }}</h3>
                                    <p>{{ language('frontend.register.text1') }}</p>
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

                                <form action="{{ route('frontend.cabinet.registerStore') }}" method="POST">
                                    @csrf

                                    <nav class="user-tabs mb-4">
                                        <ul class="nav nav-pills nav-justified">
                                            <li class="nav-item">
                                                <div class="radio">
                                                    <label for="roles4" class="nav-link  custom_radio text-uppercase text-center d-block @if(old('roles', $user->roles) == 4) active @endif">
                                                        <input name="roles" type="radio" id="roles4" value="4" @if(old('roles', $user->roles) == 4) checked @endif>
                                                         {{ language('frontend.register.freelancer') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <div class="radio">
                                                    <label for="roles3" class="custom_radio nav-link text-uppercase text-center d-block @if(old('roles', $user->roles) == 3) active @endif">
                                                        <input name="roles" id="roles3" type="radio" value="3" @if(old('roles', $user->roles) == 3) checked @endif>
                                                        {{ language('frontend.register.employer') }}
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>

                                        @if($errors->has('roles'))
                                            <div class="error">{{ $errors->first('roles') }}</div>
                                        @endif

                                    </nav>

                                    <div class="form-group form-focus">
                                        <input name="name" type="text" class="form-control floating" value="{{ old('name', $user->name) }}">
                                        <label class="focus-label">{{ language('frontend.register.your_name') }}</label>
                                        @if($errors->has('name'))
                                            <div class="error text-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group form-focus">
                                        <input name="email" type="email" class="form-control floating" value="{{ old('email', $user->email) }}">
                                        <label class="focus-label">{{ language('frontend.register.your_email') }}</label>
                                        @if($errors->has('email'))
                                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group form-focus">
                                        <input name="password" type="password" class="form-control floating" value="">
                                        <label class="focus-label">{{ language('frontend.register.password') }}</label>
                                        @if($errors->has('password'))
                                            <div class="error text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group form-focus mb-0">
                                        <input name="password_confirmation" type="password" class="form-control floating" value="">
                                        <label class="focus-label">{{ language('frontend.register.confirm_password') }}</label>
                                        @if($errors->has('password_confirmation'))
                                            <div class="error text-danger">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                    <div class="dont-have">
                                        <label class="custom_check">
                                            <input name="agree" type="checkbox" id="remember-me" value="1" @if(old('agree', $user->agree) == 1) checked @endif>
                                            <input type="checkbox" name="rem_password">
                                            <span class="checkmark"></span> {!! language('frontend.register.agree') !!}
                                        </label>
                                    </div>
                                    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ language('frontend.register.sign_up') }}</button>

                                    <div class="row">
                                        <div class="col-6 text-start">
                                            <a class="forgot-link" href="{{ route('frontend.forgot.index') }}">{{ language('frontend.register.forgot') }}</a>
                                        </div>
                                        <div class="col-6 text-end dont-have">{{ language('frontend.register.already') }} <a href="{{ route('frontend.login.index') }}">{{ language('frontend.register.sign_in') }}</a></div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


    </div>
    <!-- /Main Wrapper -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <script>
        $( ".nav-item label" ).click(function() {
            $( ".nav-item label" ).removeClass('active');
            $( this).addClass('active');
        });
    </script>
@endsection

