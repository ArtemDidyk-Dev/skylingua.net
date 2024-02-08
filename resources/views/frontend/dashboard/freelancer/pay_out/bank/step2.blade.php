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

                    @if($user->balance < ($paymentField['amount'] + $response_international->commissionAmount) )
                        <div class="alert alert-warning">
                            <ul style="margin:0;">
                                <li><i class="fa-solid fa-triangle-exclamation"></i> {{ language('frontend.cabinet_pay.balans_low') }}</li>
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">



                                <div class="payment-list wallet card-body">
                                    <h3>{{ language('Pay Out') }}</h3>

                                    <form action="{{ route('frontend.dashboard.freelancer.pay.bank.step3') }}" method="post">
                                        @csrf

                                        @if($paymentField && $response_international)

                                            <input type="hidden" name="transactionId" value="{{ $response_international->transactionId }}">
                                            <input type="hidden" name="clientOrderId" value="{{ $paymentField['clientOrderId'] }}">
                                            <input type="hidden" name="amount" value="{{ $paymentField['amount'] }}">

                                            <div class="card mb-4">
                                                <div class="card-body row">
                                                    <h3>{{ language('Payment Info') }}</h3>
                                                    <div class="col-12 col-md-6">
                                                        <label for="paymentField_amount" class="form-label">{{ language('Transaction ID') }}</label>
                                                        <div class="input-group mb-3">
                                                            {{ $response_international->transactionId }}
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6 mt-0">
                                                        <div class="form-group ">
                                                            <label for="paymentField_receiverCountry" class="mb-2">{{ language('Commission Amount') }}</label>
                                                            <div class="input-group mb-3">
                                                                {{ $response_international->commissionAmount }}&pound;
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {!! payment_info($paymentField, "Payer Info") !!}
                                        @endif


                                        <div class="col-md-8 btn-pad">
                                            <a href="{{ route('frontend.dashboard.freelancer.withdraw-money') }}" class="btn-danger click-btn">
                                                <i class="fas fa-ban"></i>
                                                {{ language('Cancel') }}
                                            </a>
                                            @if($user->balance > ($paymentField['amount'] + $response_international->commissionAmount) )
                                            <button class="btn-success click-btn ms-2">
                                                <i class="fas fa-check"></i>
                                                {{ language('Confirm') }}
                                            </button>
                                            @endif
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
        .list {
            max-height: 200px;
            overflow-y: auto !important;
        }
    </style>
@endsection

@section('JS')
@endsection

