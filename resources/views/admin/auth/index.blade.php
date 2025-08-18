<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <meta name="robots" content="noindex, nofollow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('backend/assets/css/pages/login/classic/login-4.css') }}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('backend/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('backend/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('backend/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('backend/assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('backend/assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('backend/assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('backend/assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet"
          type="text/css"/>

    <!--  FONTAWESEMO 5  -->
    <link href="{{ asset('assets/plugins/fontawesemo5/css/all.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
    <!--end::Layout Themes-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage') }}/{{ setting('favicon') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage') }}/{{ setting('favicon') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage') }}/{{ setting('favicon') }}">
    <!-- Hotjar Tracking Code for keenthemes.com -->
    <script>(function (h, o, t, j, a, r) {
            h.hj = h.hj || function () {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {hjid: 1070954, hjsv: 6};
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');</script>

    <style>

        .showPassword{
            /*position: relative;*/
        }

        .show-icon {
            position: relative;
            cursor: pointer;
        }

        .showPass {
            position: absolute;
            right: 5px;
            top: -45px;
            background: rgba(255, 255, 255, 0);
            padding: 10px;
            font-size: 22px;
        }


        .hidePass{
            position: absolute;
            right: 5px;
            top: -45px;
            background: rgba(255, 255, 255, 0);
            padding: 10px;
            font-size: 22px;
            display: none;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
             style="background-image: url('{{ asset('backend/assets/media/bg/bg-3.jpg') }}');">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="{{ route('frontend.home.index') }}">
                        <img src="{{ asset('storage/'. setting('logo')) }}" class="max-h-75px"
                             alt=""/>
                    </a>
                </div>
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="login-signin">
                    @if ($errors->any())
                        <div class="alert alert-danger text-left">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form" action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text"
                                   placeholder="E-mail" name="email" value="{{ old('email') }}"
                                   autocomplete="off"/>
                        </div>
                        <div class="form-group mb-5">
                            <span class="showPassword">
                            <input id="password" class="form-control h-auto form-control-solid py-4 px-8" type="password"
                                   placeholder="Password" name="password"/>
                                <div class="show-icon">
                                    <i class="far fa-eye showPass"></i>
                                    <i class="far fa-eye-slash hidePass"></i>
                                </div>
                                </span>
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                            <div class="checkbox-inline">
                                <label class="checkbox m-0 text-muted">
                                    <input type="checkbox" name="remember"/>
                                    <span></span>Remember Me</label>
                            </div>
                            {{--                            <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a>--}}
                        </div>
                        <button class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Enter</button>
                    </form>
                    {{--                    <div class="mt-10">--}}
                    {{--                        <span class="opacity-70 mr-4">Don't have an account yet?</span>--}}
                    {{--                        <a href="javascript:;" id="kt_login_signup" class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>--}}
                    {{--                    </div>--}}
                </div>
                <!--end::Login Sign in form-->
{{--                <!--begin::Login Sign up form-->--}}
{{--                <div class="login-signup">--}}
{{--                    <div class="mb-20">--}}
{{--                        <h3>Sign Up</h3>--}}
{{--                        <div class="text-muted font-weight-bold">Enter your details to create your account</div>--}}
{{--                    </div>--}}
{{--                    <form class="form" id="kt_login_signup_form">--}}
{{--                        <div class="form-group mb-5">--}}
{{--                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text"--}}
{{--                                   placeholder="Fullname" name="fullname"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group mb-5">--}}
{{--                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text"--}}
{{--                                   placeholder="Email" name="email" autocomplete="off"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group mb-5">--}}
{{--                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"--}}
{{--                                   placeholder="Password" name="password"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group mb-5">--}}
{{--                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"--}}
{{--                                   placeholder="Confirm Password" name="cpassword"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group mb-5 text-left">--}}
{{--                            <div class="checkbox-inline">--}}
{{--                                <label class="checkbox m-0">--}}
{{--                                    <input type="checkbox" name="agree"/>--}}
{{--                                    <span></span>I Agree the--}}
{{--                                    <a href="#" class="font-weight-bold ml-1">terms and conditions</a>.</label>--}}
{{--                            </div>--}}
{{--                            <div class="form-text text-muted text-center"></div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group d-flex flex-wrap flex-center mt-10">--}}
{{--                            <button id="kt_login_signup_submit"--}}
{{--                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up--}}
{{--                            </button>--}}
{{--                            <button id="kt_login_signup_cancel"--}}
{{--                                    class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <!--end::Login Sign up form-->--}}
{{--                <!--begin::Login forgot password form-->--}}
{{--                <div class="login-forgot">--}}
{{--                    <div class="mb-20">--}}
{{--                        <h3>Forgotten Password ?</h3>--}}
{{--                        <div class="text-muted font-weight-bold">Enter your email to reset your password</div>--}}
{{--                    </div>--}}
{{--                    <form class="form" id="kt_login_forgot_form">--}}
{{--                        <div class="form-group mb-10">--}}
{{--                            <input class="form-control form-control-solid h-auto py-4 px-8" type="text"--}}
{{--                                   placeholder="Email" name="email" autocomplete="off"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group d-flex flex-wrap flex-center mt-10">--}}
{{--                            <button id="kt_login_forgot_submit"--}}
{{--                                    class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Request--}}
{{--                            </button>--}}
{{--                            <button id="kt_login_forgot_cancel"--}}
{{--                                    class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <!--end::Login forgot password form-->--}}
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('backend/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('backend/assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('backend/assets/js/pages/custom/login/login-general.js') }}"></script>

<script>
    $(function () {
        $(document).on('click','.showPass',function (){
            $(this).hide();
            $('.hidePass').show();
            $('#password').attr('type','text');

        })

        $(document).on('click','.hidePass',function (){
            $(this).hide();
            $('.showPass').show();
            $('#password').attr('type','password');
        })
    })
</script>

<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
