@extends('admin.layouts.index')
@section('title')
    Blogs
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Blogs</h5>
                    <!--end::Blog Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Blogs</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Blogs
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
                        <h3 class="card-label">Blogs</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.blog.search') }}" method="GET">
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

                        <a href="{{ route('admin.blog.add') }}">
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
                            <th data-breakpoints="xs sm md" data-sortable="false">Tarix</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Status</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        @foreach($blogs as $blog)
                            <tr class="table-id-{{ $blog->id }} sortableHandle" data-index="{{ $blog->id }}" data-position="{{ $blog->sort }}">
                               <!-- ID -->
                                <td>{{$blog->id}}</td>

                                <!--  NAME  -->
                                <td class="sortableHandle1"><a href="{{ route('admin.blog.edit',$blog->id) }}">{{ $blog->blogsTranlations[0]->name }}</a></td>

                                <!--  Tarix  -->
                                <td>{{ updateDate($blog->updated_at,$blog->blogsTranlations) }}</td>


                                <!--  STATUS  -->
                                <td width="100">

                                        <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            <input
                                                class="statusActive"
                                                data-id="{{ $blog->id }}"
                                                type="checkbox"
                                                {{ $blog->status == 1? 'checked="checked"':"" }}
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
                                                    <span class="font-size-lg">Settings:</span>
                                                    <i class="flaticon2-information icon-md text-muted"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="Click to learn more..."></i>
                                                </li>
                                                <li class="navi-separator mb-3 opacity-70"></li>

                                                <li
                                                    class="navi-item redakteEt">
                                                    <a href="{{ route('admin.blog.edit',$blog->id) }}" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit now</span>
																		</span>
                                                    </a>
                                                </li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $blog->id }}"
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
                                Total <b><span class="totalCount">{{ $blogs->total() }}</span></b> item
                                @if($blogs->hasPages())
                                    , <b>{{ $blogs->lastPage() }}
                                </b> blogdan  <b>{{ $blogs->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $blogs->appends(['search' => isset($searchText) ? $searchText : null])
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
                    url: "{{ route('admin.blog.statusAjax') }}",
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


        /*   Yeni Sort elave et function   */
        function saveNewPositions() {
            var positions = [];
            $('.updated').each(function () {
                positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                $(this).removeClass('updated');
            });


            $.ajax({
                url: "{{ route('admin.blog.sortAjax') }}",
                method: 'POST',
                dataType: 'JSON',
                data: {update: 1, positions: positions},
                success: function (response) {
                    toastr.success("Successfully registered");
                }
            });
        }

        /*   Sortable  END   */


        /*   Delete START   */

        $(document).on('click', '.deleteButton', function () {
            let dataID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.blog.deleteAjax') }}",
                type: 'POST',
                data: {id: dataID},
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {

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
                                    url: "{{ route('admin.blog.delete') }}",
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
                                    "Xidmət silindi!",
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
