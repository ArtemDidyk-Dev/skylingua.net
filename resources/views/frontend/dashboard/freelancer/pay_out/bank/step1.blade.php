@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')


    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', compact($user))
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">

                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="alert alert-danger">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin:0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">



                                <div class="payment-list wallet card-body">
                                    <h3>{{ language('Pay Out') }}</h3>

                                    <form action="{{ route('frontend.dashboard.freelancer.pay.bank.step2') }}" method="post">
                                        @csrf

                                        @if($paymentDetails)
                                            {!! custom_input($paymentDetails, "Payment Fields") !!}
                                        @endif


                                        <div class="col-md-8 btn-pad">
                                            <button class="btn-primary click-btn">
                                                {{ language('Continue') }}
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


@endsection


@section('CSS')
    <style>
        .feeProsent {
            position: relative;
            top: -18px;
            font-size: 12px;
            color: red !important;
        }
    </style>
@endsection

@section('JS')
@endsection

