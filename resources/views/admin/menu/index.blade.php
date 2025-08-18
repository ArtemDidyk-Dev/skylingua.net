@extends('admin.layouts.index')
@section('title')
    Menus
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Menus</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            Menus
                        </li>
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
                        <h3 class="card-label">Menus</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('admin.menu.add') }}">
                            <button
                                tooltip="Add new"
                                flow="left"
                                data-toggle="modal"
                                data-target="#addDataModalButton"
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
                        <tbody>
                        @foreach($menuPositions as $menuPosition)
                            <tr class="table-id-{{ $menuPosition->id }}">
                                <td>{{ $menuPosition->id }}</td>
                                <td><a href="{{ route('admin.menu.edit',$menuPosition->id) }}">{{ $menuPosition->name }}</a></td>
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
                                                    data-toggle="modal"
                                                    data-target="#editDataModalButton"
                                                    class="navi-item redakteEt">
                                                    <a href="{{ route('admin.menu.edit',$menuPosition->id) }}" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit now</span>
																		</span>
                                                    </a>
                                                </li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $menuPosition->id }}"
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
                                Total <b><span class="totalCount">{{ $menuPositions->total() }}</span></b> item
                                @if($menuPositions->hasPages())
                                    , <b>{{ $menuPositions->lastPage() }}
                                </b> səhifədən  <b>{{ $menuPositions->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $menuPositions->appends(['search' => isset($searchText) ? $searchText : null])
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

        });


        /*   Add START   */

        $(document).on('click', '.addDataModalButton', function () {
            $('.errorsText').hide();
            $('.formAddName').val('');
            $('.formAddDescription').val('');

        })

        $(document).on('click', '.languageGroupAdd', function () {

            var languageGroupFormData = $("#languageGroupAddForm").serialize();
            $('.errorsText ul').text('');

            $.ajax({
                url: "{{ route('admin.languageGroup.add') }}",
                type: 'POST',
                data: languageGroupFormData,
                dataType: 'JSON',
                success: function (response) {
                    var errors = response.msg;
                    var countyExists = response.countyExists;

                    $.each(errors, function (index, error) {
                        $('.errorsText ul').append('<li>' + error + '</li>')
                        $('.errorsText').fadeIn();
                    })


                    if (response.success) {
                        $('.errorsText').remove();
                        toastr.success("Group əlavə olundu");
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.languageGroup.index') }}";
                        }, 2000);

                    }
                }
            });

        })
        /*   Add END   */

        /*   Edit START   */
        $(document).on('click', '.redakteEt', function () {

            $('.errorsText2').hide();

            var languageGroupID = $(this).data('id');


            $.ajax({
                url: "{{ route('admin.languageGroup.editAjax') }}",
                type: 'POST',
                data: {languageGroupID: languageGroupID},
                dataType: 'JSON',
                success: function (response) {
                    $('.editMOdalTitle').text(response.name);
                    $('.formAddName').val(response.name);
                    $('.formID').val(response.formID);
                    $('.formAddDescription').val(response.description);


                }
            });


        })
        /*   Edit END   */


        /*   Update START   */
        $(document).on('click', '.languageGroupUpdate', function () {

            var languageGroupFormData = $("#languageGroupUpdateForm").serialize();
            $('.errorsText2 ul').text('');

            $.ajax({
                url: "{{ route('admin.languageGroup.update') }}",
                type: 'POST',
                data: languageGroupFormData,
                dataType: 'JSON',
                success: function (response) {
                    var errors = response.msg;
                    var countyExists = response.countyExists;
                    var message = response.message;

                    $.each(errors, function (index, error) {
                        $('.errorsText2 ul').append('<li>' + error + '</li>')
                        $('.errorsText2').fadeIn();
                    })


                    if (response.success) {
                        $('.errorsText2').remove();
                        toastr.success("Group redaktə olundu");
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.languageGroup.index') }}";
                        }, 2000);

                    }
                }
            });

        })
        /*   Update END   */


        /*   Delete START   */

        $(document).on('click', '.deleteButton', function () {
            var dataItemID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.menu.position.delete.ajax') }}",
                type: 'POST',
                data: {id: dataItemID},
                dataType: 'JSON',
                success: function (response) {

                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "<b>" + response.name + "</b> menyusunu silmək istədiyinizə əminsiniz?<br />" +
                                "Menu silindikdə, bu menyu ilə bağlı olan bütün menyular silinəcək!",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            cancelButtonText: "Cancel!",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function (result) {

                        if(result.value){

                            $.ajax({
                                url: "{{ route('admin.menu.delete') }}",
                                type: 'POST',
                                data: {id:dataItemID},
                                dataType: 'JSON',
                                success: function (response) {

                                    if (response.success) {

                                        $('.table-id-'+dataItemID).fadeOut(1000);
                                        var totalCount = $('.totalCount').text();
                                        $('.totalCount').text(parseInt(totalCount)-1);

                                    }
                                }
                            });

                            Swal.fire(
                                "Deleted!",
                                "<b>" + response.name + "</b> menyusu silindi!",
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
