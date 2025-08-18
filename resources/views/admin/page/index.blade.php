@extends('admin.layouts.index')
@section('title')
    Pages
@endsection

@section('content')


    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Pages</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Pages</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Pages
                            </li>
                        @endisset
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
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
                        <h3 class="card-label">Pages</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.page.search') }}" method="GET">
                                <div class="input-group">
                                    <input
                                        type="search"
                                        class="form-control"
                                        value="@isset($searchText){{ $searchText }}@endisset"
                                        autocomplete="off"
                                        name="search"
                                        placeholder="Search...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success" type="button">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <a href="{{ route('admin.page.add') }}">
                            <button
                                tooltip="Add Page"
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
                            <th data-breakpoints="xs sm md" data-sortable="false">Date</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Status</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Setting</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr class="table-id-{{ $page->id }}" data-index="{{ $page->id }}" data-position="{{ $page->sort }}">
                               <!-- ID -->
                                <td>{{$page->id}}</td>

                                <!--  NAME  -->
                                <td><a href="{{ route('admin.page.edit',$page->id) }}">{{ $page->pagesTranlations[0]->name }}</a></td>

                                <!--  Tarix  -->
                                <td>{{ updateDate($page->updated_at,$page->pagesTranlations) }}</td>


                                <!--  STATUS  -->
                                <td width="100">

                                        <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            <input
                                                class="statusActive"
                                                data-id="{{ $page->id }}"
                                                type="checkbox"
                                                {{ $page->status == 1? 'checked="checked"':"" }}
                                                name="select">
                                            <span></span>
                                        </label>
									</span>

                                </td>

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
                                                    <span class="font-size-lg">Setting:</span>
                                                    <i class="flaticon2-information icon-md text-muted"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="Click to learn more..."></i>
                                                </li>
                                                <li class="navi-separator mb-3 opacity-70"></li>

                                                <li
                                                    class="navi-item redakteEt">
                                                    <a href="{{ route('admin.page.edit',$page->id) }}" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit</span>
																		</span>
                                                    </a>
                                                </li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $page->id }}"
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
                                Total <b><span class="totalCount">{{ $pages->total() }}</span></b> items
                                @if($pages->hasPages())
                                    , <b>{{ $pages->lastPage() }}
                                </b> səhifədən  <b>{{ $pages->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $pages->appends(['search' => isset($searchText) ? $searchText : null])
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

            /*   Status aktiv et START   */
            $(document).on('click', '.statusActive', function () {
                var dataID = $(this).data('id');
                var statusActive = '';

                if ($(this).is(':checked')) {
                    statusActive = 1;
                } else {
                    statusActive = 0;
                }


                $.ajax({
                    url: "{{ route('admin.page.statusAjax') }}",
                    type: 'POST',
                    data: {id: dataID, statusActive: statusActive},
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            if (data.data == 1) {
                                toastr.success("Status activated");
                            } else {
                                toastr.success("Status disabled");
                            }
                        } else {
                            toastr.error("An error occurred");
                        }
                    }
                });


            })
            /*   Status aktiv et END   */


        });





        /*   Delete START   */

        $(document).on('click', '.deleteButton', function () {
            let dataID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.page.deleteAjax') }}",
                type: 'POST',
                data: {id: dataID},
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "Are you sure you want to delete the page?",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            cancelButtonText: "No",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function (result) {
                            if (result.value) {

                                $.ajax({
                                    url: "{{ route('admin.page.delete') }}",
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
                                    "The page has been deleted!",
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
