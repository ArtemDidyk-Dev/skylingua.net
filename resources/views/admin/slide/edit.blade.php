@extends('admin.layouts.index')
@section('title')
    Edit Slide
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
                            <a href="{{ route('admin.slide.index') }}" class="text-muted">Slides</a>
                        </li>

                        <li class="breadcrumb-item">
                            Edit Slide
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
                                <h3 class="card-label">Edit Slide</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            {{-- Error messages--}}
                            {{ myErrors($errors) }}

                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.slide.update') }}"
                                          method="POST">
                                        @csrf

                                        <div class="card-body">


                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="card-toolbar">
                                                        <ul class="nav nav-tabs nav-bold nav-tabs-line">

                                                            @foreach(cache('key-all-languages') as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link {{ $key == 0 ? 'active': null }}"
                                                                       data-toggle="tab"
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


                                                    <div class="tab-content">


                                                        @foreach(cache('key-all-languages') as $key => $language)


                                                            <div
                                                                class="tab-pane fade show {{ $key == 0 ? 'active': null }} "
                                                                id="language-{{ $language->id }}-tab"
                                                                role="tabpanel"
                                                                aria-labelledby="language-{{ $language->id }}-tab">
                                                                <!--  Title  -->
                                                                <div class="form-group">


                                                                    <span class="span-dvidder">Title ({{ $language->code }})</span>
                                                                    <textarea
                                                                        name="title[{{ $language->id }}]"
                                                                        class="tinymceEditor form-control">{{ old('title.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'title')) }}</textarea>
                                                                    @error('title.'. $language->id )<span
                                                                        class="text-danger">{{ myError($message) }}</span> @enderror
                                                                </div>

                                                                <div class="hr-dvidder"></div>

                                                                <!--  Sub Title  -->
                                                                <div class="form-group">
                                                                    <span class="span-dvidder">Sub Title ({{ $language->code }})</span>
                                                                    <textarea
                                                                        name="sub_title[{{ $language->id }}]"
                                                                        class="tinymceEditor form-control">{{ old('sub_title.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'sub_title')) }}</textarea>
                                                                    @error('sub_title.'. $language->id )<span
                                                                        class="text-danger">{{ myError($message) }}</span> @enderror
                                                                </div>


                                                                <div class="hr-dvidder"></div>

                                                                <!--  Button Name  -->
                                                                <div class="form-group">
                                                                    <span class="span-dvidder">Button Name ({{ $language->code }})</span>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="button_name[{{ $language->id }}]"
                                                                           value="{{ old('button_name.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'button_name')) }}">
                                                                    @error('button_name.'. $language->id )<span
                                                                        class="text-danger">{{ myError($message) }}</span> @enderror
                                                                </div>

                                                                <!--  Button URL  -->
                                                                <div class="form-group">
                                                                    <span class="span-dvidder">Button URL ({{ $language->code }})</span>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="button_url[{{ $language->id }}]"
                                                                           value="{{ old('button_url.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'button_url')) }}">
                                                                    @error('button_url.'. $language->id )<span
                                                                        class="text-danger">{{ myError($message) }}</span> @enderror
                                                                </div>


                                                            </div>

                                                        @endforeach


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
                    <!--  QEYD  -->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Note</h3>
                            </div>


                        </div>

                        <div class="card-body">
                            <input type="hidden" form="submit-form" name="id" value="{{ $slide->id }}">

                            <!--  STATUS  -->
                            <div class="form-group row">
                                <label for="status" class="col-lg-3 col-form-label">Status</label>
                                <div class="col-lg-9">
                                    <select form="submit-form" class="form-control" name="status">
                                        <option {{ $slide->status == 1?'selected':'' }} value="1">Active</option>
                                        <option {{ $slide->status == 0?'selected':'' }} value="0">Passive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="save-tools-item">
                                        <div>Create date:</div>
                                        <div>{{ \Illuminate\Support\Carbon::parse($slide->created_at)->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div class="save-tools-item">
                                        <div>Update date:</div>
                                        <div>{{ updateDate($slide->updated_at,$slide->slidesTranlations) }}</div>
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

                    <!--  POSITION  -->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Position</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <div class="radio-list">
                                    <label class="radio">

                                        <input form="submit-form" type="radio" {{ old('position',$slide->position) == 2 ? 'checked': null }} name="position" value="2">
                                        <span></span>Left</label>
                                    <label class="radio">
                                        <input form="submit-form"  type="radio" {{ old('position',$slide->position) == 1 ? 'checked': null }} name="position" value="1">
                                        <span></span>Center</label>
                                    <label class="radio">
                                        <input form="submit-form" type="radio" {{ old('position',$slide->position) == 3 ? 'checked': null }}  name="position" value="3">
                                        <span></span>Right</label>
                                </div>
                            </div>

                        </div>


                    </div>

                    <!--  IMAGES  -->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Image</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <!--  IMAGES CONTAINER START  -->
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card-toolbar">
                                        <ul class="nav nav-tabs nav-bold nav-tabs-line">

                                            @foreach(cache('key-all-languages') as $key => $language)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $key == 0 ? 'active': null }}"
                                                       data-toggle="tab"
                                                       href="#language-images-{{ $language->id }}-tab">
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


                                    <div class="tab-content">

                                        @foreach(cache('key-all-languages') as $key => $language)


                                            <div
                                                class="tab-pane fade show {{ $key == 0 ? 'active': null }}"
                                                id="language-images-{{ $language->id }}-tab"
                                                role="tabpanel"
                                                aria-labelledby="language-images-{{ $language->id }}-tab">

                                                <!--  IMAGES START  -->
                                                <div
                                                    class="images-post-container">
                                                    <div class="images-post-item imageLoad">


                                                        <div
                                                            style="{{ old('image.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'image')) == null?"display:none;":"display:flex;" }}"
                                                            data-languageID="{{ $language->id }}"
                                                            tooltip="Delete"
                                                            class="notPhotoPost notPhotoPost_{{ $language->id }}">
                                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                        </div>
                                                        <figure
                                                            data-languageID="{{ $language->id }}"
                                                            class="activeButton"
                                                        >

                                                            <img
                                                                src="{{ old('image.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'image')) == null?asset('storage/no-image.png'): old('image.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'image')) }}"
                                                                class="previewImage_{{ $language->id }}"
                                                            >

                                                        </figure>
                                                    </div>
                                                </div>

                                                <!--  IMAGE INPUT  -->
                                                <div class="image-post-input">
                                                    <input type="text"
                                                           id="image_label_{{ $language->id }}"
                                                           name="image[{{ $language->id }}]"
                                                           value="{{ old('image.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'image')) == null? '': old('image.'. $language->id,getTranslateData($slide->slidesTranlations,$language->id,'image')) }}"

                                                           form="submit-form"
                                                    >

                                                </div>
                                                @error('image.'. $language->id )<span
                                                    class="text-danger">{{ myError($message) }}</span> @enderror


                                            <!--  IMAGES END  -->

                                            </div>



                                        @endforeach


                                    </div>


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

    <!--  BUTTON IMAGE START  -->
    <script>

        $(document).on('click', '.activeButton', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderButton(x, y, 'Images');


        })


    </script>
    <!--  BUTTON IMAGE END  -->

@endsection
