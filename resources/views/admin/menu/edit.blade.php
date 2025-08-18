@extends('admin.layouts.index')
@section('title')
    Edit Menu ({{ $menuPosition->name }})
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
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.menu.index') }}" class="text-muted">Menus</a>
                        </li>

                        <li class="breadcrumb-item">
                            Edit Menu ({{ $menuPosition->name }})
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
                        <h3 class="card-label">Edit Menu ({{ $menuPosition->name }})</h3>
                    </div>

                    <div class="card-toolbar">

                        <div id="nestable-menu">
                            <button id="close-all-menu" tooltip="Hide sub menus" data-action="collapse-all" flow="left"
                                    class="btn btn-icon btn-success btn-circle btn-lg">
                                <i data-action="collapse-all" class="far fa-eye-slash"></i>
                            </button>

                            <button id="open-all-menu" style="display: none;" tooltip="Show sub menus"
                                    data-action="expand-all" flow="left"
                                    class="btn btn-icon btn-success btn-circle btn-lg">
                                <i data-action="expand-all" class="far fa-eye"></i>
                            </button>

                        </div>


                    </div>


                </div>

                <div class="card-body">
                    {{--                    <div style="display: none" id="load"></div>--}}


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="menu-position">
                                <form action="{{ route('admin.menu.positionAdd') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class=" form-control" placeholder="Name"
                                               value="{{ $menuPosition->name }}">
                                        @error('name' )<span class="text-danger">{{ $message }}</span> @enderror

                                        <input type="hidden" name="menu_position_id"
                                               value="{{ $menuPosition->id }}">
                                        @error('menu_position_id' )<span
                                            class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Positions</label>

                                        <div class="checkbox-list">

                                            @foreach(config('menu.menu_position_name') as $key => $value)
                                                <label class="checkbox checkbox-success">
                                                    <input
                                                        type="checkbox"
                                                        value="{{ $key }}"
                                                        {{ in_array($key,json_decode($menuPosition->position,true)) ?"checked":'' }}
                                                        name="menu_position[]"
                                                    />
                                                    <span></span>
                                                    {{ $value }}
                                                </label>
                                            @endforeach

                                            @error('menu_position' )<span
                                                class="text-danger">{{ $message }}</span> @enderror
                                        </div>


                                    </div>

                                    <div class="menu-position-submit-button">
                                        <button class="btn btn-success btn-sm">Save</button>
                                    </div>
                                </form>
                            </div>

                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">

                                    @foreach(cache('key-all-languages') as $key => $language)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $key == 0 ? 'active': null }}" data-toggle="tab"
                                               href="#language-{{ $language->id }}-tab">
                                                <span class="nav-icon">
                                                     <img src="{{ countryFlag($language->code) }}"/>
                                                </span>
                                                <span class="nav-text">
                                                         {{ $language->short_name }}
                                                    </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <form action="" id="formSerialize">

                                <div class="tab-content">
                                    <div class="alert alert-my-danger">
                                        <ul>
                                            <li>Name required</li>
                                        </ul>
                                    </div>

                                    @foreach(cache('key-all-languages') as $key => $language)

                                        <div class="tab-pane fade show {{ $key == 0 ? 'active': null }}"
                                             id="language-{{ $language->id }}-tab" role="tabpanel"
                                             aria-labelledby="language-{{ $language->id }}-tab">

                                            <div class="form-group">
                                                <label>Name
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="label[{{ $language->id }}]"
                                                       class="languageLabel form-control" placeholder="Name" required>
                                                <span
                                                    class="text-danger language-label-message">Name required</span>
                                            </div>


                                            <div class="form-group">
                                                <label>Link
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="link[{{ $language->id }}]"
                                                       class="languageLink form-control" placeholder="Link" required>
                                            </div>

                                        </div>

                                    @endforeach


                                </div>


                                <input type="hidden" name="menu_position_id" value="{{ $menuPosition->id }}">
                                <input type="hidden" name="id" id="id">
                            </form>
                            <div class="menuSubmit">
                                <button id="submit" class="btn btn-success btn-sm">Add</button>
                                <button id="reset" class="btn btn-warning btn-sm">Refresh</button>
                            </div>


                        </div>
                        <div class="col-lg-8">
                            <div class="cf nestable-lists">
                                <div class="dd" id="nestable">
                                    {!! $menus !!}
                                </div>
                            </div>
                            <p></p>
                            <input type="hidden" id="nestable-output">
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection

@section('CSS')

    <link href="{{ asset('backend/assets/plugins/jquery/nestable.css') }}" rel="stylesheet" type="text/css"/>

    <style>
        .language-label-message, .alert-my-danger {
            display: none;
        }
    </style>
@endsection

@section('js')

    <script src="{{ asset('backend/assets/plugins/jquery/jquery.nestable.js') }}"></script>

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

    </script>

    <script>

        $(document).ready(function () {

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1
            })
                .on('change', updateOutput);


            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('#nestable-menu').on('click', function (e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('#open-all-menu').hide();
                    $('#close-all-menu').show();
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('#close-all-menu').hide();
                    $('#open-all-menu').show();
                    $('.dd').nestable('collapseAll');
                }
            });


        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('keyup', '.languageLabel', function () {
                $(this).next('.language-label-message').hide();
                $('.tab-content .alert-my-danger').fadeOut(100);
            })


            $("#load").hide();

            $("#submit").click(function () {
                $("#load").show();

                let languageLabel = $('.languageLabel');

                var inputIndexSay = 0;
                languageLabel.each(function (index, item) {
                    let languageLabelValue = this.value.trim().length
                    if (languageLabelValue == '') {
                        $(this).next('.language-label-message').show();
                        $('.tab-content .alert-my-danger').fadeIn(500);
                    } else {

                        inputIndexSay = inputIndexSay+1;

                        if (languageLabel.length == inputIndexSay) {

                            $.ajax({
                                type: "POST",
                                url: "{{ route('admin.menu.store.ajax') }}",
                                data: $('#formSerialize').serialize(),
                                dataType: "json",
                                cache: false,
                                success: function (data) {

                                    if (data.type == 'add') {
                                        $("#menu-id").append(data.menu);
                                    } else if (data.type == 'edit') {

                                        $('#label_show' + data.id).html(data.label);
                                        $('#link_show' + data.id).html(data.link);
                                    }
                                    $('.languageLabel').val('');
                                    $('.languageLink').val('');
                                    $('#id').val('');
                                    $("#load").hide();
                                }, error: function (xhr, status, error) {
                                    alert(error);
                                },
                            });

                        }
                    }
                });


            });

            $('.dd').on('change', function () {
                $("#load").show();

                var dataString = {
                    data: $("#nestable-output").val(),
                };


                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.menu.change.ajax') }}",
                    data: dataString,
                    cache: false,
                    success: function (data) {

                        $("#load").hide();
                    }, error: function (xhr, status, error) {
                        // alert(error);
                    },
                });
            });

            $(document).on("click", ".del-button", function () {

                var id = $(this).attr('id');

                $("#load").show();

                Swal.fire({
                    title: "Attention?",
                    html: "Bu menyunu silmək istədiyinizə əminsiniz?",
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
                            type: "POST",
                            url: "{{ route('admin.menu.delete.ajax') }}",
                            data: {id: id},
                            cache: false,
                            success: function (data) {
                                $("#load").hide();
                                $('.languageLabel').val('');
                                $('.languageLink').val('');
                                $('#id').val('');
                                $("li[data-id='" + id + "']").remove();
                            }, error: function (xhr, status, error) {
                                alert(error);
                            },
                        });

                        Swal.fire(
                            "Deleted!",
                            "<b>" + response.languageName + "</b> dili silindi!",
                            "success"
                        )
                    }
                });


            });

            $(document).on("click", ".edit-button", function () {
                var id = $(this).attr('id');
                $("#id").val(id);


                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.menu.edit.ajax') }}",
                    data: {id: id},
                    success: function (data) {
                        $.each(data, function (i, item) {
                            $('#language-' + item.language + '-tab  .languageLabel').val(item.label);
                            $('#language-' + item.language + '-tab  .languageLink').val(item.link);
                        });

                    }
                });

            });

            $(document).on("click", "#reset", function () {
                $('.languageLabel').val('');
                $('.languageLink').val('');
                $('#id').val('');
            });

        });

    </script>
@endsection
