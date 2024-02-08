@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content content-page">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    @include('frontend.dashboard.freelancer._paymentNav', ['user' => $user])

                    <div class="card pro-post">
                        <div class="card-body">
                            <div class="invoice-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="invoice-logo">
                                            <img src="/images/logo.svg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="invoice-details">
                                            <strong>{{ language('Order') }}:</strong> #{{ $pay->id }} <br>
                                            <strong>{{ language('Date') }}:</strong> {{ $pay->date  }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Item -->
                            <div class="invoice-item">
                                {!! payment_info($pay->paymentDetails, "Pay Details") !!}
                            </div>
                            <!-- /Invoice Item -->

                        </div>
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

