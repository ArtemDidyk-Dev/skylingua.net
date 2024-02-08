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
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="transaction-table card">
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    <h5 class="card-title">{{ language('Transaction History') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-box wallet-history">
                                <table class="table">
                                    <thead>
                                    <tr class="thead-pink">
                                        <th>{{ language('Date') }}</th>
                                        <th>{{ language('Recipient') }}</th>
                                        <th>{{ language('Project') }}</th>
                                        <th>{{ language('Transaction Id') }}</th>
                                        <th>{{ language('Status') }}</th>
                                        <th>{{ language('Amount') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table table-hover table-center">
                                    @if($pays)
                                        @foreach($pays as $pay)
                                            <tr>
                                                <td>{{ $pay->created_at_view }}</td>
                                                <td>
                                                    <a href="{{ route('frontend.profile.index', $pay->freelancer_id) }}"
                                                       target="_blank">{{ $pay->user_name }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('frontend.profile.index', $pay->project_id) }}"
                                                       target="_blank">{{ $pay->project_name }}</a>
                                                </td>
                                                <td>{{ $pay->orderId }}</td>
                                                <td>
                                                    @if($pay->status == 2)
                                                        <i class="fas fa-check-circle text-success"></i> {{ language('Settled') }}
                                                    @elseif($pay->status == 3)
                                                        <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                                        {{ language('Canceled') }}
                                                    @else
                                                        <img class="img-fluid"
                                                             src="{{ asset('frontend/assets/images/icon/icon-19.svg') }}"
                                                             alt=""> {{ language('Process') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($pay->status == 2)
                                                        <span class="text-success">{{ $pay->amount_view }}{{ language('frontend.currency') }}</span>
                                                    @elseif($pay->status == 3)
                                                        <span class="text-danger">{{ $pay->amount_view }}{{ language('frontend.currency') }}</span>
                                                    @else
                                                        <span class="text-danger">{{ $pay->amount_view }}{{ language('frontend.currency') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">{{ language('No Payments') }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                            </div>
                            <!-- pagination -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    {{ $getPays->appends(['search' => isset($searchText) ? $searchText : null])
                ->render('vendor.pagination.frontend.dashboard-pagination') }}
                                </div>
                            </div>
                            <!-- /pagination -->
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

