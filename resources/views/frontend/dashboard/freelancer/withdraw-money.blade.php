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
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    @include('frontend.dashboard.freelancer._paymentNav', ['user' => $user])

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


                                <div class="transaction-table card">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <h5 class="card-title">{{ language('Wallet') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 d-flex">
                                                <div class="wallet-group d-flex align-items-center">
                                                    <div class="wallet-img">
                                                        <img class="img-fluid" src="{{ asset('frontend/assets/images/wallet-icon-1.svg') }}" alt="">
                                                    </div>
                                                    <div class="balance-total">
                                                        <h3>{{ language('Available Balance') }}</h3>
                                                        <h2>{{ price_format($money['availableBalance']) }}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 d-flex">
                                                <div class="wallet-group total-credit d-flex align-items-center">
                                                    <div class="wallet-img">
                                                        <img class="img-fluid" src="{{ asset('frontend/assets/images/wallet-icon-2.svg') }}" alt="">
                                                    </div>
                                                    <div class="balance-total">
                                                        <h3>{{ language('Total Credit') }}</h3>
                                                        <h2>{{ price_format($money['totalCredit']) }}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 d-flex">
                                                <div class="wallet-group total-depit d-flex align-items-center">
                                                    <div class="wallet-img">
                                                        <img class="img-fluid" src="{{ asset('frontend/assets/images/wallet-icon-3.svg') }}" alt="">
                                                    </div>
                                                    <div class="balance-total">
                                                        <h3>{{ language('Money on hold') }}</h3>
                                                        <h2>{{ price_format($money['moneyHold']) }}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-list wallet card-body">
                                    <h3>{{ language('Pay Out') }}</h3>

                                    <form action="{{ route('frontend.dashboard.freelancer.pay.bank.step1') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ Config::get('pay.currencyLiteral') }}" name="currency">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="card_number">{{ language('Amount') }}</label>
                                                    <div class="input-group">
                                                        <input
                                                            name="amount"
                                                            type="number"
                                                            step="0.01"
                                                            min="0.01"
                                                            class="form-control"
                                                            placeholder="0"
                                                            id="paymentBankSumInput"
                                                            value="{{ old('amount') }}"
                                                            required="required"
                                                        >
                                                        <div class="input-group-prepend">
                                                            <button class="btn dol-btn" type="submit">{{ language('frontend.currency') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name">{{ language('Country
') }}</label>
                                                    <select
                                                        name="receiverCountry"
                                                        class="form-control select"
                                                        id="paymentCountrySelectOptionBox"
                                                        required="required"
                                                    >
                                                        <option value="">{{ language('frontend.common.select') }}</option>
                                                        @foreach($countriesAll as $country)

                                                            <option value="{{ $country['code'] }}" @if(old('receiverCountry') == $country['code']) selected @endif >{{ $country['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="last_name">{{ language('Payment description') }}</label>
                                                    <textarea
                                                        name="paymentProps"
                                                        class="form-control"
                                                        id="paymentPropsInput"
                                                        required="required"
                                                        rows="5"
                                                    >{{ old('paymentProps') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-8 btn-pad">
                                                <button class="btn-primary click-btn">
                                                    {{ language('Continue') }}
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
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
@endsection

@section('JS')
@endsection

