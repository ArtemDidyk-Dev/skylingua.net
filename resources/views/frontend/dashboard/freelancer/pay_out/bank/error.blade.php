@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')


    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="account-onborad complte-board back-home">
                <img src="{{ asset('frontend/assets/images/warning.png') }}" class="img-fluid" alt="">

                <h2>{{ language('Payment') }} {{ language('frontend.common.error') }}</h2>

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
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                        <ul>
                            <li>{{ session()->get('message') }}</li>
                        </ul>
                    </div>
                @endif

                @if(\App\Services\CommonService::userRoleId(auth()->id()) == 4)
                    <a href="{{ route('frontend.dashboard.freelancer.transaction-history') }}" class="btn btn-primary">{{ language('Go to Transactions') }}</a>
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

