@extends('frontend.layouts.index')

@section('title',empty(language('frontend.pay.title')) ? language('frontend.pay.name') : language('frontend.pay.title'))
@section('keywords', language('frontend.pay.keywords') )
@section('description',language('frontend.pay.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="account-onborad complte-board back-home">

                <img src="{{ asset('frontend/assets/images/select-03.png') }}" class="img-fluid" alt="">


                <h2>{{ language('Payment') }} {{ language('frontend.common.success') }}</h2>

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


                @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                    <a href="{{ route('frontend.dashboard.employer.projects-all') }}" class="btn btn-primary">{{ language('Go to Projects') }}</a>
                @else
                    <a href="{{ route('frontend.dashboard.freelancer.project-hireds') }}" class="btn btn-primary">{{ language('Go to Projects') }}</a>
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

