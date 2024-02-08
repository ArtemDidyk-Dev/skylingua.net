@extends('admin.layouts.index')
@section('title')
    Pay Out
@endsection

@section('content')


    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Pay Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Pay Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Pay Out</h5>
                    <!--end::Pay Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Pay Out</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Pay Out
                            </li>
                        @endisset
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Pay Heading-->
            </div>
            <!--end::Info-->

        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Pay Out</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.payout.search') }}" method="GET">
                                <div class="input-group">
                                    <input
                                        type="search"
                                        class="form-control"
                                        value="@isset($searchText){{ $searchText }}@endisset"
                                        autocomplete="off"
                                        name="search"
                                        placeholder="Search user...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success" type="button">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <!--  MYTABLE START  -->
                    <table class="table table-hover table-striped" data-sorting="true">
                        <thead class="thead-light">
                        <tr>
{{--                            <th width="10" data-breakpoints="xs">ID</th>--}}
                            <th data-breakpoints="" data-sortable="false">User</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Type</th>
                            <th data-breakpoints="" data-sortable="false">Amount</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Status</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Date</th>
                            <th data-breakpoints="all" data-sortable="false">Transaction ID</th>
                            <th data-breakpoints="all" data-sortable="false">Payment ID</th>
                            <th data-breakpoints="all" data-sortable="false">Sender account</th>
                            <th data-breakpoints="all" data-sortable="false">Receiver country</th>
                            <th data-breakpoints="all" data-sortable="false">Commission amount</th>
                            <th data-breakpoints="all" data-sortable="false">Exchange rate</th>
                            <th data-breakpoints="all" data-sortable="false">Billing amount</th>
                            <th data-breakpoints="all" data-sortable="false">Billing fee</th>
                            <th data-breakpoints="all" data-sortable="false">Purpose code</th>
                            <th data-breakpoints="all" data-sortable="false">Bank code</th>
                            <th data-breakpoints="all" data-sortable="false">Payment error</th>
                            <th data-breakpoints="all" data-sortable="false">Payment details</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable1">
                        @foreach($payOuts as $payOut)
                            <tr class="table-id-{{ $payOut->id }} sortableHandle1" data-index="{{ $payOut->id }}" data-position="{{ $payOut->sort }}">
                                <!-- ID -->
{{--                                <td>{{$payOut->id}}</td>--}}

                                <!-- Name -->
                                <td class="sortableHandle1">
                                    <a href="{{ route('admin.payout.searchID',$payOut->user_id) }}">{{ $payOut->user_name }} ({{ $payOut->user_email }})</a>
                                </td>
                                <!-- Type -->
                                <td>
                                    @if($payOut->type == 1)
                                        Card
                                    @else
                                        Bank
                                    @endif
                                </td>
                                <!-- Amount -->
                                <td>{{ $payOut->amount }} {{ $payOut->currency }}</td>

                                <!-- Status -->
                                <td class="text-end">
                                    @if($payOut->status == 0)
                                        <span class="text-default">Created</span>
                                    @elseif($payOut->status == 1)
                                        <span class="text-primary">Processing</span>
                                    @elseif($payOut->status == 2)
                                        <span class="text-danger">Payment error</span>
                                    @elseif($payOut->status == 3)
                                        <span class="text-warning">Progress</span>
                                    @elseif($payOut->status == 4)
                                        <span class="text-success">Success</span>
                                    @endif
                                </td>

                                <!-- Date -->
                                <td>{{ $payOut->created_at }}</td>

                                <!--  transactionId  -->
                                <td>{{ $payOut->transactionId }}</td>

                                <!--  paymentId  -->
                                <td>{{ $payOut->paymentId }}</td>

                                <!--  senderAccount  -->
                                <td>{{ $payOut->senderAccount }}</td>

                                <!--  receiverCountry  -->
                                <td>{{ $payOut->countryName }}</td>

                                <!--  commissionAmount  -->
                                <td>{{ $payOut->commissionAmount }} {{ $payOut->currency }}</td>

                                <!--  exchangeRate  -->
                                <td>{{ $payOut->exchangeRate }}</td>

                                <!--  billingAmount  -->
                                <td>{{ $payOut->billingAmount }}</td>

                                <!--  billingFee  -->
                                <td>{{ $payOut->billingFee }}</td>

                                <!--  purposeCode  -->
                                <td>{{ $payOut->purposeCode }}</td>

                                <!--  bankCode  -->
                                <td>{{ $payOut->bankCode }}</td>


                                <!--  paymentError  -->
                                <td>{!!  $payOut->paymentError !!}</td>

                                <!--  paymentDetail  -->
                                <td>
                                    <!-- Large modal -->
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-detail-modal-lg-{{$payOut->id}}">View Detail</button>

                                    <div class="modal fade bd-detail-modal-lg-{{$payOut->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Payment Detail</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body d-block">
                                                    {!! payment_info_admin($payOut->paymentDetails,'Sender Detail') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!--  Settings  -->
                                <td>
                                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title=""
                                         data-placement="left" data-original-title="Quick actions">
                                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </a>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
                                             style="">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover">
                                                <li class="navi-header font-weight-bold py-4">
                                                    <span class="font-size-lg">Settings:</span>
                                                    <i class="flaticon2-information icon-md text-muted"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="Click to learn more..."></i>
                                                </li>
                                                <li class="navi-separator mb-3 opacity-70"></li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $payOut->id }}"
                                                >
                                                    <a href="#" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label  label-xl label-inline label-light-danger">Delete</span>
																		</span>
                                                    </a>
                                                </li>

                                            </ul>
                                            <!--end::Navigation-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--  MYTABLE END  -->
                </div>
                <div class="card-footer">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center py-3">
                            <span class="text-muted">
                                Total <b><span class="totalCount">{{ $payOuts->total() }}</span></b> item
                                @if($payOuts->hasPages())
                                    , <b>{{ $payOuts->lastPage() }}
                                </b> paydan  <b>{{ $payOuts->currentPage() }}</b> views.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $payOuts->appends(['search' => isset($searchText) ? $searchText : null])
                                 ->render('vendor.pagination.backend.my-pagination') }}
                        </div>
                        <!--  Paginate END -->
                    </div>

                </div>
            </div>


        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection

@section('CSS')

@endsection

@section('js')

    <script>
        jQuery(function ($) {
            $('.table').footable({
                "empty": "Məlumat tapılmadı",
            });
        });
    </script>

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        });




        /*   Delete START   */
        $(document).on('click', '.deleteButton', function () {
            let dataID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.payout.deleteAjax') }}",
                type: 'POST',
                data: {id: dataID},
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "Are you sure you want to delete?",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            cancelButtonText: "Cancel",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function (result) {
                            if (result.value) {

                                $.ajax({
                                    url: "{{ route('admin.payout.delete') }}",
                                    type: 'POST',
                                    data: {id:dataID},
                                    dataType: 'JSON',
                                    success: function (response) {

                                        if (response.success) {
                                            $('.table-id-'+dataID).fadeOut(1000);
                                            // $('.table-id-'+languageID).remove();
                                            var totalCount = $('.totalCount').text();
                                            $('.totalCount').text(parseInt(totalCount)-1);

                                        }
                                    }
                                });

                                Swal.fire(
                                    "Deleted!",
                                    "Pay Out Deleted!",
                                    "success"
                                )
                            }
                        });

                    }


                }
            });

        })
        /*   Delete END   */
    </script>
@endsection
