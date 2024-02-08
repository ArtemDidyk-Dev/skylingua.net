@extends('admin.layouts.index')
@section('title')
    Add Service
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
                            Add Service
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
                                <h3 class="card-label">Add Profile</h3>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.portfolio.store') }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="mb-15">
                                                <div class="form-group row form-user_category">
                                                    <label for="user_category" class="col-lg-3 col-form-label">Select User</label>
                                                    <div class="col-lg-4">
                                                        <select required class="form-control" name="user" id="user_category">

                                                            @foreach($users as $user)
                                                                <option
                                                                    value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('user')<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <!--  NAME START  -->
                                                <div class="form-group">
                                                    <span class="span-dvidder">Title</span>
                                                    <input
                                                        required
                                                        type="text"
                                                        name="title"
                                                        class=" form-control">
                                                    @error('title')
                                                    <span
                                                        class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!--  NAME END  -->


                                                <!--  Link START  -->
                                                <div class="form-group">
                                                    <span class="span-dvidder">link</span>
                                                    <input
                                                        type="text"
                                                        name="link"
                                                        class=" form-control">
                                                </div>
                                                <div class="card card-custom gutter-b">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <h3 class="card-label">Image</h3>
                                                        </div>

                                                    </div>

                                                    <div
                                                         class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <div class="custom-file-container">
                                                                    <input type="file" class="custom-file-input" name="image" id="customFile" accept="image/*" >
                                                                    <label class="custom-file-label" for="customFile">Choose Image</label>
                                                                </div>
                                                            </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Save
                                        </button>
                                    </form>
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
    <link href="https://cdn.rawgit.com/shabuninil/fileup/master/src/fileup.min.css" rel="stylesheet">
    <style>

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            background-color: #3699ff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .custom-file-input:lang(en)~.custom-file-label::after {
            content: "Browse";
            height: 100%;
            right: -8px;
        }
        .modal-backdrop.show {
            opacity: 1 !important;
        }

        .modal-backdrop {
            background-color: rgba(255, 255, 255, 0.71) !important;
        }

        @media (min-width: 576px) {
            .modal-content {
                -webkit-box-shadow: 0 0 1.5rem 0 rgba(0, 0, 0, 0.10);
                box-shadow: 0 0 1.5rem 0 rgba(0, 0, 0, 0.10);
            }
        }

        .projectUserNameResult {
            margin-top: 5px;
            margin-left: 3px;
            font-weight: 600;
            display: none;
        }
        .activeButtonAlone img {
            width: 400px !important;
            height: 400px !important;
        }
        .images-post-item {
            width: 400px !important;
            height: 400px !important;
        }
    </style>
@endsection

@section('js')

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });


    </script>


    <!--  TINYMCE START -->
    <script>
        tinymce.init({
            selector: '.tinymceEditor',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr portfoliobreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | portfoliobreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
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

    <!--  BUTTON TINYMCE IMAGE START  -->
    <script>

        $(document).on('click', '.activeButton', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderButton(x, y, 'Images');

        })

    </script>
    <!--  BUTTON TINYMCE IMAGE END  -->

    <!--  BUTTON IMAGE ALONE START  -->
    <script>

        $(document).on('click', '.activeButtonAlone', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderAloneButton(x, y, 'Images');

        })

    </script>
    <!--  BUTTON IMAGE ALONE END  -->



@endsection
@section('js')

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });


    </script>


    <!--  TINYMCE START -->
    <script>
        tinymce.init({
            selector: '.tinymceEditor',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr portfoliobreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | portfoliobreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
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

    <!--  BUTTON TINYMCE IMAGE START  -->
    <script>

        $(document).on('click', '.activeButton', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderButton(x, y, 'Images');

        })

    </script>
    <!--  BUTTON TINYMCE IMAGE END  -->

    <!--  BUTTON IMAGE ALONE START  -->
    <script>

        $(document).on('click', '.activeButtonAlone', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderAloneButton(x, y, 'Images');

        })

    </script>
    <!--  BUTTON IMAGE ALONE END  -->



@endsection

