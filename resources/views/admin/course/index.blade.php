@extends('admin.layouts.index')
@section('title')
    Course
@endsection

@section('content')


    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Blog Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Blog Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Course</h5>
                    <!--end::Blog Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Course</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Course
                            </li>
                        @endisset
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Blog Heading-->
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
                        <h3 class="card-label">Course</h3>
                    </div>
                    <div class="card-toolbar">


                        <a href="{{ route('admin.courses.create') }}">
                            <button
                                tooltip="Add new"
                                flow="left"
                                class="btn addDataModalButton btn-icon btn-success btn-circle btn-lg">
                                <i class="flaticon-plus"></i>
                            </button>
                        </a>


                    </div>
                </div>

                <div class="card-body">
                    <!--  MYTABLE START  -->
                    <table class="table table-hover table-striped" data-sorting="true">
                        <thead class="thead-light">
                        <tr>
                            <th width="10" data-breakpoints="xs">ID</th>
                            <th>Name</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        @foreach($courses as $cours)
                            <tr class="table-id-{{ $cours->id }} sortableHandle" data-index="{{ $cours->id }}" data-position="{{ $cours->sort }}">
                                <!-- ID -->
                                <td>{{$cours->id}}</td>

                                <!--  NAME  -->
                                <td class="sortableHandle1"><a href="{{ route('admin.courses.edit',$cours->id) }}">{{ $cours->name }}</a></td>

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
                                                    class="navi-item redakteEt">
                                                    <a href="{{ route('admin.courses.edit',$cours->id) }}" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit now</span>
																		</span>
                                                    </a>
                                                </li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $cours->id }}"
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
                                Total <b><span class="totalCount">{{ $courses->total() }}</span></b> item
                                @if($courses->hasPages())
                                    , <b>{{ $courses->lastPage() }}
                                </b> blogdan  <b>{{ $courses->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $courses->appends(['search' => isset($searchText) ? $searchText : null])
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



            /*   Sortable  START   */
            $("#sortable").sortable({
                // handle: ".sortableHandle",
                update: function (event, ui) {
                    $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index + 1)) {
                            $(this).attr('data-position', (index + 1)).addClass('updated');
                        }
                    });
                    //Position yadda saxla
                    saveNewPositions();
                }
            });
            $("#sortable").disableSelection();


        });



        $(document).on('click', '.deleteButton', function () {
            let dataID = $(this).data('id');

            Swal.fire({
                title: "Attention?",
                html: "Silmək istədiyinizə əminsiniz?",
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
                        url: `/lamratum/courses/delete/${dataID}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // Додаємо CSRF токен
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            if (response.success) {
                                $('.table-id-' + dataID).fadeOut(1000);
                                var totalCount = $('.totalCount').text();
                                $('.totalCount').text(parseInt(totalCount) - 1);
                                Swal.fire(
                                    "Deleted!",
                                    "Xidmət silindi!",
                                    "success"
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                "Error!",
                                "Could not delete the record!",
                                "error"
                            );
                        }
                    });
                }
            });
        });



    </script>
@endsection
