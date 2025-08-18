@extends('admin.layouts.index')
@section('title')
    Dil Qrupları
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Dil Qrupları</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.languageGroup.index') }}" class="text-muted">Dil Qrupları</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Dil Qrupları
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
                        <h3 class="card-label">Dil Qrupları</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.languageGroup.search') }}" method="GET">
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

                        <button
                            tooltip="Add new"
                            flow="left"
                            data-toggle="modal"
                            data-target="#addDataModalButton"
                            class="btn addDataModalButton btn-icon btn-success btn-circle btn-lg">
                            <i class="flaticon-plus"></i>
                        </button>

                        <!--Elave et Modal START-->
                        <div class="modal fade" id="addDataModalButton" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalSizeLg" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add new group</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body ">

                                        <!--  Errors  -->
                                        <div class="errorsText">
                                            <div class="alert alert-custom alert-light-danger fade show mb-5"
                                                 role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!--begin::Form-->
                                        <form id="languageGroupAddForm" action="" method="POST">
                                        @csrf
                                             <!--  Name  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Name</label>
                                                <div class="col-md-6">
                                                         <input class="form-control formAddName" name="name"
                                                           type="text">
                                                </div>
                                            </div>

                                            <!--  Achiqlama  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Açıqlama</label>
                                                <div class="col-md-6">
                                                    <textarea rows="3" class="form-control formAddDescription" name="description"></textarea>
                                                </div>
                                            </div>

                                        </form>


                                        <!--end::Form-->

                                        {{--  <textarea class="aeditorTiny" name="name"></textarea>--}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Bağla
                                        </button>
                                        <button type="button" class="btn languageGroupAdd btn-success font-weight-bold">Yadda
                                            saxla
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Elave et Modal END-->


                        <!--Redakte et Modal START-->
                        <div class="modal fade" id="editDataModalButton" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalSizeLg" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title editMOdalTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body ">


                                        <!--  Errors  -->
                                        <div class="errorsText2">
                                            <div class="alert alert-custom alert-light-danger fade show mb-5"
                                                 role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                <div class="alert-text">
                                                    <ul></ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!--begin::Form-->
                                        <form id="languageGroupUpdateForm" action="" method="POST">
                                            @csrf
                                            <input type="hidden" name="formID" class="formID">

                                            <!--  Name  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Name</label>
                                                <div class="col-md-6">
                                                    <input class="form-control formAddName" name="name"
                                                           type="text">
                                                </div>
                                            </div>

                                            <!--  Achiqlama  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Açıqlama</label>
                                                <div class="col-md-6">
                                                    <textarea rows="3" class="form-control formAddDescription" name="description"></textarea>
                                                </div>
                                            </div>

                                        </form>


                                        <!--end::Form-->


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Bağla
                                        </button>
                                        <button type="button" class="btn languageGroupUpdate btn-success font-weight-bold">
                                            Yadda
                                            saxla
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Redakte et Modal END-->

                    </div>
                </div>

                <div class="card-body">
                    <!--  MYTABLE START  -->
                    <table class="table table-hover table-striped" data-sorting="true">
                        <thead class="thead-light">
                        <tr>
                            <th width="10" data-breakpoints="xs">ID</th>
                            <th>Name</th>
                            <th data-breakpoints="xs sm md">Açiqlama</th>
                            <th data-breakpoints="xs sm md">Say</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($languageGroups as $languageGroup)
                            <tr class="table-id-{{ $languageGroup->id }}">
                                <td>{{ $languageGroup->id }}</td>
                                <td><a href="{{ route('admin.languageGroup.detail',$languageGroup->id) }}">{{ $languageGroup->name }}</a></td>
                                <td>{{ $languageGroup->description }}</td>
                                <td>{{ count($languageGroup->countPhrase) }}</td>
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
                                                    data-id="{{ $languageGroup->id }}"
                                                    data-toggle="modal"
                                                    data-target="#editDataModalButton"
                                                    class="navi-item redakteEt">
                                                    <a href="#" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit now</span>
																		</span>
                                                    </a>
                                                </li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $languageGroup->id }}"
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
                                Total <b><span class="totalCount">{{ $languageGroups->total() }}</span></b> item
                                @if($languageGroups->hasPages())
                                    , <b>{{ $languageGroups->lastPage() }}
                                </b> səhifədən  <b>{{ $languageGroups->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $languageGroups->appends(['search' => isset($searchText) ? $searchText : null])
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
            var languageGroupID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.languageGroup.deleteAjax') }}",
                type: 'POST',
                data: {id: languageGroupID},
                dataType: 'JSON',
                success: function (response) {

                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "<b>" + response.languageGroupName + "</b> qrupunu silmək istədiyinizə əminsiniz?" +
                                "Qrup silindikde, bu qrupla bağlı olan bütün ifadələr silinəcək!",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function (result) {

                        if(result.value){

                            $.ajax({
                                url: "{{ route('admin.languageGroup.delete') }}",
                                type: 'POST',
                                data: {id:languageGroupID},
                                dataType: 'JSON',
                                success: function (response) {

                                    if (response.success) {

                                        $('.table-id-'+languageGroupID).fadeOut(1000);
                                        var totalCount = $('.totalCount').text();
                                        $('.totalCount').text(parseInt(totalCount)-1);

                                    }
                                }
                            });

                            Swal.fire(
                                "Deleted!",
                                "<b>" + response.languageGroupName + "</b> qrupu silindi!",
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
