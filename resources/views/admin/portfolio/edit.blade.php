@extends('admin.layouts.index')
@section('title')
    Edit Portfolio
@endsection

@section('content')

    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Portfolio Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Portfolio Title-->
                    <!--end::Portfolio Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.portfolio.index') }}" class="text-muted">Portfolios</a>
                        </li>

                        <li class="breadcrumb-item">
                            Edit Portfolio
                        </li>

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Portfolio Heading-->
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
                        <!--begin::Card header-->
                        <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a class="nav-link active" data-toggle="tab" href="#tab-portfolio-general">
                                            <span class="nav-text font-size-lg">ÜMUMİ</span>
                                        </a>
                                    </li>
                                    <!--end::Item-->
                                </ul>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <form class="form" id="submit-form" action="{{ route('admin.portfolio.update') }}"
                                  method="POST"
                            >
                                @csrf

                                <div style="padding-top: 0" class="tab-content">
                                    <!--begin::Tab-->
                                    <div class="tab-pane show active " id="tab-portfolio-general" role="tabpanel">

                                        {{-- Error messages--}}
                                        {{ myErrors($errors) }}

                                        <div class="row">
                                            <div class="col-md-12 ">


                                                <div style="padding: 0.25rem;" class="card-body">


                                                    <div class="row">
                                                        <div class="col-md-12 ">


                                                            <!--  NAME START  -->
                                                            <div class="form-group">
                                                                <span class="span-dvidder">Title</span>
                                                                <input
                                                                        type="text"
                                                                        name="title"
                                                                        value="{{ old('title', $portfolio->title) }}"
                                                                        class=" form-control">
                                                                @error('title')
                                                                <span class="text-danger">{{ myError($message) }}</span>
                                                                @enderror
                                                            </div>
                                                            <!--  NAME END  -->


                                                        </div>

                                                    </div>


                                                </div>


                                            </div>

                                        </div>

                                    </div>
                                    <!--end::Tab-->


                                </div>
                            </form>

                        </div>
                        <!--begin::Card body-->
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


                            <!--  ID  -->
                            <input type="hidden" form="submit-form" name="id" value="{{ $portfolio->id }}">


                            <!--  STATUS  -->
                            <div class="form-group row">
                                <label for="status" class="col-lg-3 col-form-label">Approve</label>
                                <div class="col-lg-9">
                                    <select form="submit-form" class="form-control" name="status">
                                        <option {{ $portfolio->approve == 1?'selected':'' }} value="1">Yes</option>
                                        <option {{ $portfolio->approve == 0?'selected':'' }} value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="save-tools-item">
                                        <div>Create date:</div>
                                        <div>{{ \Illuminate\Support\Carbon::parse($portfolio->created_at)->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div class="save-tools-item">
                                        <div>Update date:</div>
                                        <div>{{ $portfolio->updated_at }}</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer myCardFooterPadding">
                            <div class=" d-flex justify-content-end">
                                <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Save
                                </button>
                            </div>
                        </div>


                    </div>

                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Image</h3>
                            </div>

                        </div>


                        <div style="padding-top: 2px; padding-bottom: 2px;" class="card-body">

                            <!--  IMAGES CONTAINER START  -->
                            <div class="row">
                                <div class="col-md-12 ">

                                    <!--  IMAGES START  -->
                                    <div
                                            class="images-post-container">
                                        <div class="images-post-item">

                                            <div
                                                    style="display: {{ old('image',$portfolio->image) == null? 'none':'flex' }}"
                                                    tooltip="Delete"
                                                    class="notPhotoPost notPhotoPostAlone">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </div>
                                            <figure class="activeButton">

                                                <img src="{{old('image',$portfolio->image) == null ? asset('storage/no_image_portfolio.jpg') : asset('storage/portfolio/'. old('image',$portfolio->image)) }}" class="previewImage">

                                            </figure>
                                        </div>
                                    </div>

                                    <!--  IMAGE INPUT  -->
                                    <div class="image-post-input">
                                        <input type="text"
                                               id="image_label"
                                               name="image"
                                               value="{{ old('image', $portfolio->image) }}"
                                               form="submit-form"
                                        >

                                    </div>
                                    @error('image' )<span
                                            class="text-danger">{{ $message }}</span> @enderror


                                    <!--  IMAGES END  -->

                                </div>

                            </div>
                            <!--  IMAGES CONTAINER END  -->


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
    <style>
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


    <!--  BUTTON IMAGE START  -->
    <script>

        $(document).on('click', '.activeButton', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderAloneButton(x, y, 'Images');


        })


    </script>
    <!--  BUTTON IMAGE END  -->

@endsection
