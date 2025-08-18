@extends('admin.layouts.index')
@section('title')
    Languages
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Languages</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Languages</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Languages
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
                        <h3 class="card-label">Languages</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.language.search') }}" method="GET">
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
                                        <h5 class="modal-title">Add new language</h5>
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
                                        <form id="languageAddForm" action="" method="POST">
                                        @csrf
                                        <!--  Name  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Dil</label>
                                                <div class="col-md-6">
                                                    <select class="form-control countriesOverflow selectpicker"
                                                            name="name" data-size="5" data-live-search="true">
                                                        <option value="">Select</option>
                                                        @foreach($countriesAll as  $country)
                                                            <option value="{{ $country['code'] }}">
                                                                {{ $country['name'] }}
                                                                ({{ $country['nativeName'] }}) ({{ $country['code'] }})
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <!--  Qisa AD  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Short name</label>
                                                <div class="col-md-6">
                                                    <input class="form-control formAddShortName" name="short_name"
                                                           type="text">
                                                </div>
                                            </div>

                                            <!--  Sira  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Sort</label>
                                                <div class="col-md-6">
                                                    <input type="number" min="0" name="sort"
                                                           class="form-control formAddSort">
                                                </div>
                                            </div>

                                            <!-- Default  -->
                                        {{--                                            <div class="form-group row">--}}
                                        {{--                                                <label class="col-form-label text-right col-md-3">Default</label>--}}
                                        {{--                                                <div class="col-md-6">--}}
                                        {{--                                               <span class="switch switch-outline switch-icon switch-success">--}}
                                        {{--                                                <label>--}}
                                        {{--                                                 <input type="checkbox" name="default"/>--}}
                                        {{--                                                 <span></span>--}}
                                        {{--                                                </label>--}}
                                        {{--                                               </span>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}

                                        <!--  Status  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Status</label>
                                                <div class="col-md-6">
                                               <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                 <input class="formAddStatus" type="checkbox" name="status"/>
                                                 <span></span>
                                                </label>
                                               </span>
                                                </div>
                                            </div>

                                        </form>


                                        <!--end::Form-->

{{--                                          <textarea class="editorTiny" name="name"></textarea>--}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" class="btn languageAdd btn-success font-weight-bold">Save
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
                                        <form id="languageUpdateForm" action="" method="POST">
                                            @csrf
                                            <input type="hidden" name="formID" class="formID">
                                            <!--  Name  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Language</label>
                                                <div class="col-md-6">
                                                    <!--  Ajax Ile gelir  -->
                                                    <div class="LanguageList">
                                                        <select class="form-control countriesOverflow selectpicker"
                                                                name="name" data-size="5" data-live-search="true">
                                                            <option value="">Select</option>
                                                            @foreach($countriesAll as  $country)
                                                                <option value="{{ $country['code'] }}">
                                                                    {{ $country['name'] }}
                                                                    ({{ $country['nativeName'] }})
                                                                    ({{ $country['code'] }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--  Qisa AD  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Qisa ad</label>
                                                <div class="col-md-6">
                                                    <input class="form-control formShortName" name="short_name"
                                                           type="text">
                                                </div>
                                            </div>

                                            <!--  Sira  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Sıra</label>
                                                <div class="col-md-6">
                                                    <input type="number" min="0" name="sort"
                                                           class="form-control formSort">
                                                </div>
                                            </div>

                                            <!-- Default  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Default</label>
                                                <div class="col-md-6">
                                                   <span
                                                       class="switch switch-outline switch-icon switch-success">
                                                    <label>
                                                     <input class="fromDefault" type="checkbox" name="default"/>
                                                     <span></span>
                                                    </label>
                                                   </span>
                                                </div>
                                            </div>

                                            <!--  Status  -->
                                            <div class="form-group row">
                                                <label class="col-form-label text-right col-md-3">Status</label>
                                                <div class="col-md-6">
                                               <span class="switch switch-outline switch-icon switch-success">
                                                <label>
                                                 <input class="formStatus" type="checkbox" name="status"/>
                                                 <span></span>
                                                </label>
                                               </span>
                                                </div>
                                            </div>

                                        </form>


                                        <!--end::Form-->


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Bağla
                                        </button>
                                        <button type="button" class="btn languageUpdate btn-success font-weight-bold">
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
                            <th data-breakpoints="xs sm md">Short Name</th>
                            <th data-breakpoints="xs sm md">Code</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Default</th>
                            <th data-breakpoints="xs sm md" data-sortable="false">Status</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        @foreach($languages as $language)
                            <tr class="table-id-{{ $language->id }}" data-index="{{ $language->id }}" data-position="{{ $language->sort }}">
                                {{--                                <td>{{$loop->iteration}}</td>--}}
                                <td>{{$language->id}}</td>
                                <td class="sortableHandle">
                                    <span style="vertical-align: middle;" class="symbol symbol-20 symbol-circle mr-1">
                                        <img src="{{ countryFlag($language->code) }}"/>
                                    </span>
                                    {{ $language->name }}
                                </td>
                                <td>{{ $language->short_name }}</td>
                                <td>{{ $language->code }}</td>

                                <td>

                                    <form action="{{ route('admin.language.defaultStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $language->id }}">
                                        <button type="submit"
                                                {{ $language->default == 1? 'disabled':'' }}
                                                class="defaultButton btn {{ $language->default == 1? ' btn-outline-success ':' btn-outline-danger ' }}
                                                    font-weight-bold btn-sm btn-pill">
                                            {{ $language->default == 1? 'Active':'Passive' }}
                                        </button>
                                    </form>

                                </td>

                                <td>
                                    @if($language->default != 1)
                                        <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            <input
                                                class="statusActive"
                                                data-id="{{ $language->id }}"
                                                type="checkbox"
                                                {{ $language->status == 1? 'checked="checked"':"" }}
                                                name="select">
                                            <span></span>
                                        </label>
									</span>
                                    @endif
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
                                                    data-id="{{ $language->id }}"
                                                    data-code="{{ $language->code }}"
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
                                                    data-id="{{ $language->id }}"
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
                                Total <b><span class="totalCount">{{ $languages->total() }}</span></b> item
                                @if($languages->hasPages())
                                    , <b>{{ $languages->lastPage() }}
                                </b> səhifədən  <b>{{ $languages->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $languages->appends(['search' => isset($searchText) ? $searchText : null])
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
                // "expandFirst": true, //bunu yandirdiqda birinci aciq olmush formada gelecek
                // "expandAll": true, //Hamsni achir
                // "showHeader": false, //Headeri sondurur
                // "showToggle": false, //Achib baqliyani sondurur
                // "toggleColumn": "first", //AChib baqliyanin yerini deyishir first, last

                // "columns": [  {
                //     "formatter": function(value, options, rowData){
                //         return "<span>" + value + "</span>";
                //     }
                // }],  //columun en brinci deyeriyle oyanamq

                // "columns": [{
                //     "style": {
                //         "color": "red"
                //     }
                // }] , //Columlari renglemek

                // "columns": [{
                //     "title": "ID"
                // }], //thead ichindeki adlari deyishmek

                // "columns": [{
                //     "sortable": false
                // }]
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
                    url: "{{ route('admin.language.statusAjax') }}",
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
                handle: ".sortableHandle",
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
                url: "{{ route('admin.language.sortAjax') }}",
                method: 'POST',
                dataType: 'JSON',
                data: {update: 1, positions: positions},
                success: function (response) {
                    toastr.success("Successfully registered");
                }
            });
        }

        /*   Sortable  END   */

        /*   Add START   */

        $(document).on('click', '.addDataModalButton', function () {
            $('.errorsText').hide();
            $('.formAddShortName').val('');
            $('.formAddSort').val('');
            $('.formAddStatus').removeAttr('checked');

        })

        $(document).on('click', '.languageAdd', function () {

            var languageFormData = $("#languageAddForm").serialize();
            $('.errorsText ul').text('');

            $.ajax({
                url: "{{ route('admin.language.add') }}",
                type: 'POST',
                data: languageFormData,
                dataType: 'JSON',
                success: function (response) {
                    var errors = response.msg;
                    var countyExists = response.countyExists;

                    $.each(errors, function (index, error) {
                        $('.errorsText ul').append('<li>' + error + '</li>')
                        $('.errorsText').fadeIn();
                    })

                    if (response.error) {
                        $('.errorsText ul').append('<li>' + countyExists + '</li>')
                        $('.errorsText').fadeIn();
                    }

                    if (response.success) {
                        $('.errorsText').remove();
                        toastr.success("Dil əlavə olundu");
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.language.index') }}";
                        }, 2000);

                    }
                }
            });

        })
        /*   Add END   */

        /*   Edit START   */
        $(document).on('click', '.redakteEt', function () {

            $('.errorsText2').hide();

            var languageID = $(this).data('id');
            var languageCode = $(this).data('code');
            var fromDefault = false;
            var formStatus = false;

            /*   Lazim olan dili select et   */
            $('.LanguageList option[value="' + languageCode + '"]').attr('selected', 'selected');

            /*   Optionun ichindeki texti al   */
            var languageOptionText = $('.LanguageList option[value="' + languageCode + '"]').text();
            $('.LanguageList .filter-option-inner-inner').html(languageOptionText);
            $('.editMOdalTitle').text(languageOptionText)


            $.ajax({
                url: "{{ route('admin.language.editAjax') }}",
                type: 'POST',
                data: {languageID: languageID},
                dataType: 'JSON',
                success: function (response) {
                    $('.formShortName').val(response.formShortName);
                    $('.formID').val(response.formID);
                    $('.formSort').val(response.formSort);

                    if (response.fromDefault == 1) {
                        $('.fromDefault').attr('checked', 'checked');
                    } else {
                        $('.fromDefault').removeAttr('checked');
                    }

                    if (response.formStatus == 1) {
                        $('.formStatus').attr('checked', 'checked');
                    } else {
                        $('.formStatus').removeAttr('checked');
                    }


                }
            });


        })
        /*   Edit END   */


        /*   Update START   */
        $(document).on('click', '.languageUpdate', function () {

            var languageFormData = $("#languageUpdateForm").serialize();
            $('.errorsText2 ul').text('');

            $.ajax({
                url: "{{ route('admin.language.update') }}",
                type: 'POST',
                data: languageFormData,
                dataType: 'JSON',
                success: function (response) {
                    var errors = response.msg;
                    var countyExists = response.countyExists;
                    var message = response.message;

                    $.each(errors, function (index, error) {
                        $('.errorsText2 ul').append('<li>' + error + '</li>')
                        $('.errorsText2').fadeIn();
                    })

                    if (response.error) {
                        $('.errorsText2 ul').append('<li>' + message + '</li>')
                        $('.errorsText2').fadeIn();

                    }

                    if (response.success) {
                        $('.errorsText2').remove();
                        toastr.success("Dil redaktə olundu");
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.language.index') }}";
                        }, 2000);

                    }
                }
            });

        })
        /*   Update END   */


        /*   Delete START   */

        $(document).on('click', '.deleteButton', function () {
            var languageID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.language.deleteAjax') }}",
                type: 'POST',
                data: {id: languageID},
                dataType: 'JSON',
                success: function (response) {
                    if (response.error) {
                        // toastr.error(response.languageName+" default olaraq seçilidir.Silmək mümkün olmadı!",'Diqqət!');
                        Swal.fire({
                            title: "Diqqət!",
                            html: "<b>" + response.languageName + "</b> language is selected by default. Could not delete!",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "ok!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }

                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "Are you sure you want to delete the <b>" + response.languageName + "</b> language?" +
                                "When a language is deleted, all translations related to this language will be deleted!",
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
                                    url: "{{ route('admin.language.delete') }}",
                                    type: 'POST',
                                    data: {id:languageID},
                                    dataType: 'JSON',
                                    success: function (response) {

                                        if (response.success) {
                                            $('.table-id-'+languageID).fadeOut(1000);
                                            // $('.table-id-'+languageID).remove();
                                            var totalCount = $('.totalCount').text();
                                            $('.totalCount').text(parseInt(totalCount)-1);

                                        }
                                    }
                                });

                                Swal.fire(
                                    "Deleted!",
                                    "<b>" + response.languageName + "</b> successfully deleted!",
                                    "success"
                                )
                            }
                        });

                    }


                }
            });


        })

        /*   Delete END   */

        /*   EDITOR START   */
        tinymce.init({
            selector: "textarea.editorTiny",
            theme: "modern",
            height: 150,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

        });
        /*   EDITOR END   */

    </script>
@endsection
