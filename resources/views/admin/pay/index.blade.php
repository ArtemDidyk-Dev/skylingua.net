@extends('admin.layouts.index')
@section('title')
    Pays
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Pays</h5>
                    <!--end::Pay Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Pays</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Pays
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
                        <h3 class="card-label">Pays</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">

                        </div>




                    </div>
                </div>

                <div class="card-body">
                    <!--  MYTABLE START  -->
                    <table class="table table-hover table-striped" data-sorting="true">
                        <thead class="thead-light">
                        <tr>
                            <th width="10" data-breakpoints="xs">ID</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Employer</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Freelancer</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Type</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Amount ($)</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Status</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Date</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable1">
                        @foreach($pays as $pay)
                            <tr class="table-id-{{ $pay->id }} sortableHandle1" data-index="{{ $pay->id }}" data-position="{{ $pay->sort }}">
                                <!-- ID -->
                                <td>{{$pay->id}}</td>
                                <td class="sortableHandle1">
                                    <a href="{{ route('admin.user.edit',$pay->employer_id) }}">{{ $pay->employer_name }}</a>
                                </td>
                                <td class="sortableHandle1">
                                    <a href="{{ route('admin.user.edit',$pay->freelancer_id) }}">{{ $pay->freelancer_name }}</a>
                                </td>
                                <td>
                                    @if($pay->type == 1)
                                        Pay
                                    @else
                                        Out
                                    @endif
                                </td>
                                <td>${{ $pay->amount }}</td>
                                <td class="text-end">
                                    @if($pay->status == 2)
                                        <span class="text-success">Success</span>
                                    @elseif($pay->status == 3)
                                        <span class="text-danger">Cancel</span>
                                    @else
                                        <span class="text-warning">Pending</span>
                                    @endif
                                </td>


                                <td>{{ $pay->created_at }}</td>

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
                                                    data-id="{{ $pay->id }}"
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
                                Total <b><span class="totalCount">{{ $pays->total() }}</span></b> item
                                @if($pays->hasPages())
                                    , <b>{{ $pays->lastPage() }}
                                </b> paydan  <b>{{ $pays->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $pays->appends(['search' => isset($searchText) ? $searchText : null])
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
                "empty": "No found",
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

            {{--/*   Status aktiv et START   */--}}
            {{--$(document).on('click', '.statusActive', function () {--}}
            {{--    var dataID = $(this).data('id');--}}
            {{--    var statusActive = '';--}}

            {{--    if ($(this).is(':checked')) {--}}
            {{--        statusActive = 1;--}}
            {{--    } else {--}}
            {{--        statusActive = 0;--}}
            {{--    }--}}


            {{--    $.ajax({--}}
            {{--        url: "{{ route('admin.pay.statusAjax') }}",--}}
            {{--        type: 'POST',--}}
            {{--        data: {id: dataID, statusActive: statusActive},--}}
            {{--        dataType: 'JSON',--}}
            {{--        success: function (data) {--}}
            {{--            if (data.success == true) {--}}
            {{--                if (data.data == 1) {--}}
            {{--                    toastr.success("Status activated");--}}
            {{--                } else {--}}
            {{--                    toastr.success("Status disabled");--}}
            {{--                }--}}
            {{--            } else {--}}
            {{--                toastr.error("An error occurred");--}}
            {{--            }--}}
            {{--        }--}}
            {{--    });--}}


            {{--})--}}
            {{--/*   Status aktiv et END   */--}}




            // /*   Sortable  START   */
            // $("#sortable").sortable({
            //     // handle: ".sortableHandle",
            //     update: function (event, ui) {
            //         $(this).children().each(function (index) {
            //             if ($(this).attr('data-position') != (index + 1)) {
            //                 $(this).attr('data-position', (index + 1)).addClass('updated');
            //             }
            //         });
            //         //Position yadda saxla
            //         saveNewPositions();
            //     }
            // });
            // $("#sortable").disableSelection();


        });


        {{--/*   Yeni Sort elave et function   */--}}
        {{--function saveNewPositions() {--}}
        {{--    var positions = [];--}}
        {{--    $('.updated').each(function () {--}}
        {{--        positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);--}}
        {{--        $(this).removeClass('updated');--}}
        {{--    });--}}


        {{--    $.ajax({--}}
        {{--        url: "{{ route('admin.pay.sortAjax') }}",--}}
        {{--        method: 'POST',--}}
        {{--        dataType: 'JSON',--}}
        {{--        data: {update: 1, positions: positions},--}}
        {{--        success: function (response) {--}}
        {{--            toastr.success("Successfully registered");--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        {{--/*   Sortable  END   */--}}


        /*   Delete START   */
        $(document).on('click', '.deleteButton', function () {
            let dataID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.pay.deleteAjax') }}",
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
                                    url: "{{ route('admin.pay.delete') }}",
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
                                    "Pay Deleted!",
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
