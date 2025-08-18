@extends('admin.layouts.index')
@section('title')
    Phrases
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Phrases</h5>
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
                                <a href="{{ route('admin.languagePhrase.index') }}" class="text-muted">Phrases</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.languageGroup.index') }}" class="text-muted">Dil Qrupları</a>
                            </li>
                            <li class="breadcrumb-item">
                                Phrases
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
                        <h3 class="card-label">Phrases</h3>


                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.languagePhrase.search') }}" method="GET">
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
                        <div class="modal fade" id="addDataModalButton" role="dialog"
                             aria-labelledby="exampleModalSizeLg" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add a new expression</h5>
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
                                        <form id="languagePhraseAddForm" action="" method="POST">
                                        @csrf

                                        <!--  Key  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Key</label>
                                                <div class="col-md-6">
                                                    <input class="form-control formAddKey" name="key"
                                                           type="text">
                                                </div>
                                            </div>

                                            <!--  Qrup  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Qrup</label>
                                                <div class="col-md-6">

                                                        <select name="groupID" class="form-control formAddGroup countriesOverflow selectpicker"
                                                                data-size="5" data-live-search="true">
                                                            <option value="">Select</option>
                                                            @foreach($languageGroups as  $item)
                                                                <option
                                                                    value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                </div>
                                            </div>

                                            <!--  Editor  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Editor</label>
                                                <div class="col-md-6">
                                                  <span class="switch switch-outline switch-icon switch-success ">
                                                    <label>
                                                     <input class="editorActive" type="checkbox" checked="checked"
                                                            name="editorActive"/>
                                                     <span></span>
                                                    </label>
                                                   </span>
                                                </div>
                                            </div>

                                            <!--  Tercume  -->
                                            <div class="form-group row mt-10 ">
                                                <div class="col-md-12">
                                                    <ul class="nav nav-tabs mt-5" role="tablist">
                                                        @foreach($languages as $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link @if($loop->first) active @endif "
                                                                   id="{{$language->code}}" data-toggle="tab"
                                                                   href="#tab-{{$language->code}}">
																	<span class="mr-1">
																		<img class="h-15px w-15px rounded-sm"
                                                                             src="{{ countryFlag($language->code) }}"
                                                                             alt="{{ $language->code }}">
																	</span>
                                                                    <span
                                                                        class="nav-text">{{ $language->short_name }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content mt-5">
                                                        @foreach($languages as $language)
                                                            <div
                                                                class="tab-pane fade @if($loop->first) active @endif show"
                                                                id="tab-{{$language->code}}" role="tabpanel"
                                                                aria-labelledby="{{$language->code}}">

                                                                <div class="default-editor">
                                                                              <textarea rows="6"
                                                                                        name="translate[{{$language->id}}]"
                                                                                        class="form-control translate"></textarea>
                                                                </div>

                                                                <div class="tiny-editor">
                                                                              <textarea
                                                                                  id="editorTiny-{{$language->id}}"
                                                                                  data-index="editorTiny-{{$language->id}}"
                                                                                  rows="6"
                                                                                  name="translateEditor[{{$language->id}}]"
                                                                                  class="form-control editorTiny translateEditor"></textarea>
                                                                </div>


                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </form>


                                        <!--end::Form-->


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Bağla
                                        </button>
                                        <button type="button"
                                                class="btn languagePhraseAdd btn-success font-weight-bold">Yadda
                                            saxla
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Elave et Modal END-->


                        <!--Redakte et Modal START-->
                        <div class="modal fade" id="editDataModalButton"  role="dialog"
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

                                            <!--  Key  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Key</label>
                                                <div class="col-md-6">
                                                    <input class="form-control formAddKey" name="key"
                                                           type="text">
                                                </div>
                                                <input type="hidden" name="phraseID" class="phraseID">
                                            </div>



                                            <!--  Qrup  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Qrup</label>
                                                <div class="col-md-6">
                                                    <div class="LanguageGroupList">
                                                        <select name="groupID" class="form-control countriesOverflow selectpicker"
                                                                data-size="5" data-live-search="true">
                                                            <option value="">Select</option>
                                                            @foreach($languageGroups as  $item)
                                                                <option
                                                                    value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <!--  Editor  -->
                                            <div class="form-group row mt-10 ">
                                                <label class="col-form-label text-right col-md-3">Editor</label>
                                                <div class="col-md-6">
                                                  <span class="switch switch-outline switch-icon switch-success ">
                                                    <label>
                                                     <input id="editorActive" class="editorActive" type="checkbox"
                                                            name="editorActive"/>
                                                     <span></span>
                                                    </label>
                                                   </span>
                                                </div>
                                            </div>

                                            <!--  Tercume  -->
                                            <div class="form-group row mt-10 ">
                                                <div class="col-md-12">
                                                    <ul class="nav nav-tabs mt-5" role="tablist">
                                                        @foreach($languages as $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link @if($loop->first) active @endif "
                                                                   id="{{$language->code}}" data-toggle="tab"
                                                                   href="#tabEdit-{{$language->code}}">
																	<span class="mr-1">
																		<img class="h-15px w-15px rounded-sm"
                                                                             src="{{ countryFlag($language->code) }}"
                                                                             alt="{{ $language->code }}">
																	</span>
                                                                    <span
                                                                        class="nav-text">{{ $language->short_name }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content mt-5">
                                                        @foreach($languages as $language)
                                                            <div
                                                                class="tab-pane fade @if($loop->first) active @endif show"
                                                                id="tabEdit-{{$language->code}}" role="tabpanel"
                                                                aria-labelledby="{{$language->code}}">

                                                                <div class="default-editor">
                                                                              <textarea rows="6"
                                                                                        id="translateEdit-{{$language->id}}"
                                                                                        data-index="{{$language->id}}"
                                                                                        name="translate[{{$language->id}}]"
                                                                                        class="form-control translateEdit"></textarea>
                                                                </div>

                                                                <div class="tiny-editor">
                                                                              <textarea rows="6"
                                                                                        id="editorTinyEdit-{{$language->id}}"
                                                                                        data-index="{{$language->id}}"
                                                                                        name="translateEditor[{{$language->id}}]"
                                                                                        class="form-control editorTiny translateEditEditor"></textarea>
                                                                </div>


                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </form>


                                        <!--end::Form-->


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Bağla
                                        </button>
                                        <button type="button"
                                                class="btn languagePhraseUpdate  btn-success font-weight-bold">
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
                            <th>Qrup</th>
                            <th>Key</th>
                            @foreach($languages as $language)
                                <th data-breakpoints="xs sm md">{{ $language->name }}</th>
                            @endforeach
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($languagePhrases as $languagePhrase)
                            <tr class="table-id-{{ $languagePhrase->id }}">
                                <td>{{ $languagePhrase->id }}</td>
                                <td>
                                    <a href="{{ route('admin.languageGroup.detail',$languagePhrase->languageGroups->id ) }}">
                                        {{ $languagePhrase->languageGroups->name }}
                                    </a>
                                </td>
                                <td
                                    class="copyClipboard"
                                    id="kt_clipboard_{{ $languagePhrase->id }}"
                                    data-clipboard="true"
                                    data-clipboard-target="#kt_clipboard_{{ $languagePhrase->id }}"
                                >
                                    {{ $languagePhrase->key }}
                                </td>

                                @foreach($languagePhrase->translate as $translate)
                                    <td>
                                        @if(empty($translate->value))
                                            <span class="text-danger">Empty</span>
                                        @else
                                            {!!   strip_tags(Str::limit($translate->value,50,'...'))  !!}
                                        @endif
                                    </td>
                                @endforeach

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
                                                    data-id="{{ $languagePhrase->id }}"
                                                    data-groupID="{{ $languagePhrase->languageGroups->id }}"
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
                                                    data-id="{{ $languagePhrase->id }}"
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
                                Total <b><span class="totalCount">{{ $languagePhrases->total() }}</span></b> item
                                @if($languagePhrases->hasPages())
                                    , <b>{{ $languagePhrases->lastPage() }}
                                </b> səhifədən  <b>{{ $languagePhrases->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $languagePhrases->appends(['search' => isset($searchText) ? $searchText : null])
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
            $('.formAddKey').val('');
            $('.translate').val('');

            if ($('.editorActive').is(':checked')) {
                $('.editorActive').removeAttr('checked');
            }

            $('.editorTiny').each(function (index, value) {
                var id = $(this).data('index');
                tinymce.get(id).setContent("");

            })

        })

        $(document).on('click', '.languagePhraseAdd', function () {

            //Ajax sorgu zamani olan problemi aradan qaldirir (deyerler gonderilmediyi ucun)
            tinyMCE.triggerSave();

            var languageGroupFormData = $("#languagePhraseAddForm").serialize();
            $('.errorsText ul').text('');


            $.ajax({
                url: "{{ route('admin.languagePhrase.add') }}",
                type: 'POST',
                data: languageGroupFormData,
                dataType: 'JSON',
                success: function (response) {
                    var errors = response.msg;

                    <!--  Butun errorlari yaz  -->
                    $.each(errors, function (index, error) {
                        $('.errorsText ul').append('<li>' + error + '</li>')
                        $('.errorsText').fadeIn();
                    })


                    if (response.success) {
                        $('.errorsText').remove();
                        toastr.success("Key və tərcümə əlavə olundu");
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.languagePhrase.index') }}";
                        }, 2000);

                    }

                }
            });

        })
        /*   Add END   */

        /*   Edit START   */
        $(document).on('click', '.redakteEt', function () {

            $('.errorsText2').hide();

            var languagePhraseID = $(this).data('id');

            var LanguageGroupID = $(this).attr('data-groupID');



            /*   Lazim olan dili select et   */
            $('.LanguageGroupList option[value="' + LanguageGroupID + '"]').attr('selected', 'selected');

            /*   Optionun ichindeki texti al   */
            var languageGroupOptionText = $('.LanguageGroupList option[value="' + LanguageGroupID + '"]').text();
            $('.LanguageGroupList .filter-option-inner-inner').html(languageGroupOptionText);
            $('.editMOdalTitle').text(languageGroupOptionText)




            $.ajax({
                url: "{{ route('admin.languagePhrase.editAjax') }}",
                type: 'POST',
                data: {languagePhraseID: languagePhraseID},
                dataType: 'JSON',
                success: function (response) {
                    var key = response.success.phraseKey;
                    var phraseID = response.success.phraseID;
                    $('.formAddKey').val(key);
                    $('.phraseID').val(phraseID);

                    $('.translateEdit').each(function (index, value) {
                        var id = $(this).data('index');
                        $('#translateEdit-'+id).val(response.success.translate[id]);

                        var emptytext = '';
                        if(!response.success.translate[id]){
                            emptytext = '';
                        }else{
                            emptytext = response.success.translate[id];
                        }
                         tinymce.get('editorTinyEdit-'+id).setContent(emptytext);

                    })



                    if(response.success.editor == 1){
                       $('.editorActive').attr('checked','checked')
                        $('.default-editor').hide();
                        $('.tiny-editor').show();
                    }else{
                        $('.editorActive').removeAttr('checked')
                        $('.tiny-editor').hide();
                        $('.default-editor').show();
                    }




                }
            });


        })
        /*   Edit END   */


        /*   Update START   */
        $(document).on('click', '.languagePhraseUpdate', function () {
            //Ajax sorgu zamani olan problemi aradan qaldirir (deyerler gonderilmediyi ucun)
            tinyMCE.triggerSave();

            var languageGroupFormData = $("#languageGroupUpdateForm").serialize();
            $('.errorsText2 ul').text('');


            $.ajax({
                url: "{{ route('admin.languageGroup.phraseUpdate') }}",
                type: 'POST',
                data: languageGroupFormData,
                dataType: 'JSON',
                success: function (response) {

                    var errors = response.msg;


                    $.each(errors, function (index, error) {
                        $('.errorsText2 ul').append('<li>' + error + '</li>')
                        $('.errorsText2').fadeIn();
                    })


                    if (response.success) {
                        $('.errorsText2').remove();
                        toastr.success("Key və tərcümə redaktə olundu");
                        setTimeout(function () {
                            window.location.href = "{{ route('admin.languagePhrase.index') }}";
                        }, 2000);

                    }


                }
            });

        })
        /*   Update END   */


        /*   Delete START   */

        $(document).on('click', '.deleteButton', function () {


            var languagePhraseID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.languagePhrase.deleteAjax') }}",
                type: 'POST',
                data: {id: languagePhraseID},
                dataType: 'JSON',
                success: function (response) {

                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "<b>" + response.languagePhraseKey + "</b> keyini silmək istədiyinizə əminsiniz?" +
                                "Key silindikdə, bu keylə bağlı olan bütün ifadələr silinəcək!",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function (result) {

                            if (result.value) {

                                $.ajax({
                                    url: "{{ route('admin.languagePhrase.delete') }}",
                                    type: 'POST',
                                    data: {id: languagePhraseID},
                                    dataType: 'JSON',
                                    success: function (response) {

                                        if (response.success) {

                                            $('.table-id-' + languagePhraseID).fadeOut(1000);
                                            var totalCount = $('.totalCount').text();
                                            $('.totalCount').text(parseInt(totalCount) - 1);

                                        }
                                    }
                                });

                                Swal.fire(
                                    "Deleted!",
                                    "<b>" + response.languagePhraseKey + "</b> keyi silindi!",
                                    "success"
                                )
                            }

                        });

                    }


                }
            });


        })

        /*   Delete END   */


        /*   EDITOR ACTIVE START   */
        $(function () {
            $(document).on('click', '.editorActive', function () {

                if ($(this).is(':checked')) {
                    $('.default-editor').hide();
                    $('.tiny-editor').show();
                } else {
                    $('.tiny-editor').hide();
                    $('.default-editor').show();
                }
            })
        })
        /*   EDITOR ACTIVE END   */


    </script>


    <!--  TINYMCE START -->
    <script>
        tinymce.init({
            selector: '.editorTiny',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 300,
            forced_root_block: "", // Bunu yandirdiqda adi vaxti <p> tagi ichine alirdisa artiq almiyacaq
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
            entity_encoding: "raw",
            entities: "nbsp",
            relative_urls: false,
            remove_script_host: true,
            file_picker_callback(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight
                let fileType = meta.filetype;

                /*   BUTTON FUNCTION START   */
                ckfinderTinyMCEButton(x, y, fileType);

            }
        });


    </script>
    <!--  TINYMCE END -->

@endsection
