@extends('admin.layouts.index')
@section('title')
    Add Menu
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
                            Add Menu
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
            <div class="row">
                <div class="col-my-lg-8 ">

                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Add Menu</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.menu.addMenuName') }}" method="POST">
                                        @csrf

                                        <div class="card-body">

                                            <div class="mb-15">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Menu Name:</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="name" class="form-control form-control-lg"   placeholder="Name"/>
                                                        @error('name' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                            </div>


                                        </div>

                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>


                </div>
                <div class="col-my-lg-4 ">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Note</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class=" d-flex justify-content-end">
                                        <button type="submit" form="submit-form" class="btn btn-success btn-sm mr-2">Save</button>
                                    </div>
                                </div>

                            </div>


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
            $("#load").hide();

            $("#submit").click(function () {
                $("#load").show();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.menu.store.ajax') }}",
                    data: $('#formSerialize').serialize(),
                    dataType: "json",
                    cache: false,
                    success: function (data) {
                        console.log(data);
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
