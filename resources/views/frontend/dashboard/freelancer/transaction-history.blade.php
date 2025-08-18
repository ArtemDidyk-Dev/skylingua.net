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

                    <div class="transaction-table card">
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    <h5 class="card-title">{{ language('All Transactions') }}</h5>
                                </div>
                                <div class="col-auto d-flex align-items-center flex-wrap transaction-shortby">

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-box">
                                <table class="table">
                                    <thead>
                                    <tr class="thead-pink">
                                        <th style="width: 100px;">{{ language('Detail') }}</th>
                                        <th>{{ language('Transaction ID') }}</th>
                                        <th>{{ language('Amount') }}</th>
                                        <th>{{ language('Status') }}</th>
                                        <th>{{ language('Paid On') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table table-hover table-center">

                                    @if($pays)
                                        @foreach($pays as $pay)
                                    <tr>
                                        <td>
                                            <a href="{{ route('frontend.dashboard.freelancer.view-invoice', $pay->id) }}" class="invoice-id">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>{{ $pay->transactionId ? $pay->transactionId : "---" }}</td>
                                        <td>{{ price_format($pay->amount) }}</td>
                                        <td>{!!  $pay->status_text !!}</td>
                                        <td>{{ $pay->date }}</td>
                                    </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">{{ language('No Transactions') }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                </div>
                                <div class="col-auto d-flex align-items-center flex-wrap transaction-shortby">
                                    <!--  PAGINATION START  -->
                                    <div class="card-footer d-flex justify-content-end">
                                        {{ $pays->appends(['search' => isset($searchText) ? $searchText : null])
    ->render('vendor.pagination.frontend.dashboard-pagination') }}
                                    </div>
                                    <!--  PAGINATION END  -->
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

