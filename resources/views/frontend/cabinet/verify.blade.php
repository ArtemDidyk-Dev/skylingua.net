@extends('frontend.layouts.index')

@section('title',empty(language('frontend.register.title')) ? language('frontend.register.name') : language('frontend.register.title'))
@section('keywords', language('frontend.register.keywords') )
@section('description',language('frontend.register.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="account-onborad complte-board back-home">
                @if($data['status'] == true)
                    <img src="{{ asset('frontend/assets/images/select-03.png') }}" class="img-fluid" alt="">
                @else
                    <img src="{{ asset('frontend/assets/images/warning.png') }}" class="img-fluid" alt="">
                @endif

                @if($data['status'] == true)
                    <h2>{{ language('frontend.common.success') }}</h2>
                @else
                    <h2>{{ language('frontend.common.error') }}</h2>
                @endif

                <p>{{ $data['message'] }}</p>

                @if($data['status'] == true)
                    <a href="{{ route('frontend.login.index') }}" class="btn btn-primary">{{ language('frontend.register.sign_in') }}</a>
                @else
                    <a href="{{ route('frontend.home.index') }}" class="btn btn-primary"> {{ language('frontend.common.back_to_home') }}</a>
                @endif
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
@endsection

