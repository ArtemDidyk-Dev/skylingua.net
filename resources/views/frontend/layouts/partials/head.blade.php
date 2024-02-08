<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<title>@yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta name="keywords" content="@yield('keywords')"/>
<meta name="description" content="@yield('description')"/>

<meta name="google-site-verification" content="RNgiK_F5NQG3rXLeVl85rsTEOrax-Rs_s8C9Zh7mK5s" />

<!-- Favicons -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage') }}/{{ setting('favicon') }}">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css')}}">

<!-- Global CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/global/plugins.bundle.css')}}">

<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fontawesome/css/all.min.css')}}">

<!-- Bootstrap Tag CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}">

<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap-datetimepicker.min.css')}}">

<!-- Fancybox CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fancybox/jquery.fancybox.min.css')}}">

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.theme.default.min.css')}}">

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/select2/css/select2.min.css')}}">

<!-- Datatables CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/datatables/datatables.min.css')}}">

<!-- Summernote CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/summernote/dist/summernote-lite.css')}}">
<!-- Aos CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/aos/aos.css')}}">
<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">

@if(Route::is(['frontend.dashboard.chats']) || Route::is(['frontend.dashboard.employer.employerProjectAdd']) || Route::is(['frontend.dashboard.employer.employerProjectEdit']))
    <!-- FileUp -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/fileup/fileup.min.css')}}">
@endif

<!-- Snarl -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/snarl/snarl.min.css')}}">

<!-- Toasty -->
<link rel="stylesheet" href="{{ asset('frontend/assets/plugins/toasty/css/toasty.min.css')}}">

<link rel="stylesheet" href="/css/nouislider.css">
@stack('css')
<style>
    .toast {
        transition: 0.32s all ease-in-out;
    }
    .toast-container--fade {
        right: 0;
        bottom: 0;
    }
    .toast-container--fade .toast-wrapper {
        display: inline-block;
    }
    .toast.fade-init {
        opacity: 0;
    }
    .toast.fade-show {
        opacity: 1;
    }
    .toast.fade-hide {
        opacity: 0;
    }
    
</style>

@yield('CSS')
