@extends('admin.layouts.index')
@section('title')
    Users
@endsection

@section('content')


    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">

                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($search)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.user.index') }}" class="text-muted">Users</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Users
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
                        <h3 class="card-label">Users</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.users.search') }}" method="GET">
                                <div class="input-group">
                                    <input
                                        type="search"
                                        class="form-control"
                                        value="@isset($search){{ $search }}@endisset"
                                        autocomplete="off"
                                        name="search"
                                        placeholder="Search...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success" type="button">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <a href="{{ route('admin.user.add') }}">
                            <button
                                tooltip="Add New User"
                                flow="left"
                                class="btn btn-icon btn-success btn-circle btn-lg">
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
                            <th>Image</th>
                            <th data-breakpoints="xs sm md">Name</th>
                            <th data-breakpoints="xs sm md">Role</th>
                            <th data-breakpoints="xs sm md">E-mail</th>
                            <th data-breakpoints="xs sm md">Date</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Status</th>
                            <th data-breakpoints="xs">Approve</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        @foreach($users as $key =>  $user)
                            <tr class="table-id-{{ $user->id }}" data-index="{{ $user->id }}">

                                <!--  ID  -->
                                <td>{{$user->id}}</td>

                                <!--  USER NAME  -->
                                <td>
                                    <img src="{{ !empty($user->profile_photo) ? asset('storage/profile/'. $user->profile_photo) : asset('storage/no-image.png') }}" alt="" style="width:70px; height:70px;">
                                </td>

                                <!--  AD  -->
                                <td>{{ $user->name }}</td>


                                <!--  Icaze  -->
                                <td>{{ $user->roles[0]->name }}</td>


                                <!--  E-mail  -->
                                <td>{{ $user->email }}</td>

                                <!--  Tarix  -->
                                <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d H:i') }}</td>


                                <!--  Status  -->
                                <td>
                                    @if($user->id != 1)
                                        <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            <input
                                                class="statusActive"
                                                data-id="{{ $user->id }}"
                                                type="checkbox"
                                                {{ $user->status == 1? 'checked="checked"':"" }}
                                                name="select">
                                            <span></span>
                                        </label>
									</span>
                                    @endif
                                </td>

                                <!--  Approve  -->
                                <td>
                                    @if($user->approve == 1)
                                        <span style="background-color: #5cbb5f" class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->id != 1)
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
                                                        class="navi-item">
                                                        <a href="{{ route('admin.user.edit', $user->id ) }}"
                                                           class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit</span>
																		</span>
                                                        </a>
                                                    </li>

                                                    <li
                                                        class="navi-item deleteButton"
                                                        data-id="{{ $user->id }}"
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
                                    @endif
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
                                Total <b><span class="totalCount">{{ $users->total() }}</span></b> item
                                @if($users->hasPages())
                                    , <b>{{ $users->lastPage() }}
                                </b> səhifədən  <b>{{ $users->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">

                            {{ $users->appends([
                                  'search' => isset($search) ? $search : null,
                                  ])->render('vendor.pagination.backend.my-pagination') }}


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
                "empty": "Not Found",
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
                    url: "{{ route('admin.user.statusAjax') }}",
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


            /*   Delete START   */

            $(document).on('click', '.deleteButton', function () {
                var dataID = $(this).data('id');


                $.ajax({
                    url: "{{ route('admin.user.deleteAjax') }}",
                    type: 'POST',
                    data: {id: dataID},
                    dataType: 'JSON',
                    success: function (response) {
                        if(response.checkAdmin){

                            Swal.fire({
                                title: "Warning!",
                                html: "You do not have permission to do this!",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "ok!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });


                        }else {
                            if (response.success) {
                                Swal.fire({
                                    title: "Attention?",
                                    html: "You are sure that you want to delete the user named <b>" + response.name + "</b>?<br /> <b class='text-danger'>When deleting this user, all that belong to him will be deleted!</b>",
                                    icon: "error",
                                    showCancelButton: true,
                                    confirmButtonText: "Delete!",
                                    cancelButtonText: "Cancel",
                                    customClass: {
                                        confirmButton: "btn btn-light-danger font-weight-bold",
                                        cancelButton: 'btn btn-light-primary font-weight-bold',
                                    }
                                }).then(function (result) {

                                    if (result.isConfirmed) {

                                        $.ajax({
                                            url: "{{ route('admin.user.delete') }}",
                                            type: 'POST',
                                            data: {id:dataID},
                                            dataType: 'JSON',
                                            success: function (response) {

                                                if (response.success) {
                                                    $('.table-id-'+dataID).fadeOut(1000);
                                                    // $('.table-id-'+dataID).remove();
                                                    var totalCount = $('.totalCount').text();
                                                    $('.totalCount').text(parseInt(totalCount)-1);

                                                }
                                            }
                                        });

                                        toastr.success("Silindi");
                                    }
                                });

                            }
                        }



                    }
                });


            })

            /*   Delete END   */

        });


    </script>
@endsection
