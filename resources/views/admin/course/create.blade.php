@extends('admin.layouts.index')
@section('title')
    Add Course
@endsection

@section('content')

    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Country Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Country Title-->
                    <!--end::Country Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            Add Course
                        </li>

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Country Heading-->
            </div>
            <!--end::Info-->

        </div>
    </div>
    <!--end::Subheader-->



    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid" x-data="course()" x-cloak>
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-my-lg-12 ">

                    <div class="card card-custom gutter-b">
                        <!--begin::Card header-->
                        <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a class="nav-link active" data-toggle="tab" href="#tab-country-general">
                                            <span class="nav-text font-size-lg">GENERAL</span>
                                        </a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <!--end::Item-->
                                </ul>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <form @submit.prevent="submit()" class="form" id="submit-form"
                                  action="{{ route('admin.courses.store') }}"
                                  method="POST">

                                <div style="padding-top: 0" class="tab-content">
                                    <!--begin::Tab-->
                                    <div class="tab-pane show active " id="tab-country-general" role="tabpanel">

                                        {{-- Error messages--}}
                                        {{ myErrors($errors) }}

                                        <div class="row">
                                            <div class="col-md-12 ">


                                                <div style="padding: 0.25rem;" class="card-body">


                                                    <div class="row">
                                                        <div class="col-md-12 ">


                                                            <div class="tab-content">


                                                                <div
                                                                    class="tab-pane fade show active"

                                                                    role="tabpanel"
                                                                    aria-labelledby="language-tab">

                                                                    <div class="form-group row form-user_category">
                                                                        <label for="user_category"
                                                                               class="col-lg-3 col-form-label">Select
                                                                            User</label>
                                                                        <div class="col-lg-4">
                                                                            <select required class="form-control"
                                                                                    name="user" x-model="formData.user">
                                                                                <option disabled value="">Select User
                                                                                </option>
                                                                                <template x-for="user in users"
                                                                                          :key="user.id">
                                                                                    <option :value="user.id"
                                                                                            x-text="user.name"></option>
                                                                                </template>
                                                                            </select>

                                                                            @error('user')<span
                                                                                class="text-danger">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group row form-user_category">
                                                                        <label for="user_category"
                                                                               class="col-lg-3 col-form-label">Type
                                                                            Access</label>
                                                                        <div class="col-lg-4">
                                                                            <select required class="form-control"
                                                                                    name="user"
                                                                                    x-model="formData.access_select">
                                                                                <option disabled>Select Type (Default
                                                                                    Show All)
                                                                                </option>
                                                                                <template
                                                                                    x-for="(accessItem, index) in access"
                                                                                    :key="index">
                                                                                    <option :value="index"
                                                                                            x-text="accessItem"></option>
                                                                                </template>
                                                                            </select>

                                                                        </div>
                                                                    </div>

                                                                    <div x-show="formData.access_select != 'open_to_everyone' &&  formData.access_select != 'subscribers_only'">
                                                                        <div  class="form-group row">
                                                                            <label for="price"
                                                                                   class="col-lg-3 col-form-label">Price</label>
                                                                            <div class="col-lg-12">
                                                                                <input id="price" type="number" name="price"
                                                                                       :value="formData.price"
                                                                                       x-model="formData.price"
                                                                                       class="form-control form-control-lg"
                                                                                       placeholder="Enter price"
                                                                                       step="0.01" min="0.01" />
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row"  x-show="formData.access_select != 'open_to_everyone'">
                                                                        <label for="promo_img" class="col-lg-3 col-form-label">Promo Image</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="file" @change="uploadPromo($event)" name="promo_img" class="form-control">
                                                                        </div>
                                                                    </div>


                                                                    <!--  NAME START  -->
                                                                    <div class="form-group">
                                                                        <span class="span-dvidder">Title</span>
                                                                        <input
                                                                            type="text"
                                                                            name="title"
                                                                            value=""
                                                                            x-model="formData.title"
                                                                            class="form-control">
                                                                    </div>


                                                                    <!--  NAME END  -->

                                                                    <!--  CONTENT START  -->
                                                                    <div class="form-group">
                                                                        <span class="span-dvidder">Description </span>
                                                                        <textarea
                                                                            type="text"
                                                                            name="text"
                                                                            class="tinymceEditor form-control"></textarea>

                                                                    </div>

                                                                    <!--  CONTENT END  -->

                                                                    <div x-show="errors" class="error__list">
                                                                        <ul>
                                                                            <template x-for="(error, key) in errors"
                                                                                      :key="key">
                                                                                <li class="color: red"
                                                                                    x-text="error"></li>
                                                                            </template>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <span class="span-dvidder">Upload file</span>
                                                                        <template
                                                                            x-for="(file, index) in formData.file"
                                                                            :key="index">
                                                                            <div class="mb-3">
                                                                                <input
                                                                                    type="file"
                                                                                    :name="`file[${index}]`"
                                                                                    class="form-control"
                                                                                    @change="updateFile($event, index)"
                                                                                >
                                                                                <button type="button"
                                                                                        class="btn btn-danger btn-sm mt-2"
                                                                                        @click="removeFile(index)">
                                                                                    Remove
                                                                                </button>
                                                                            </div>
                                                                        </template>
                                                                        <button type="button"
                                                                                class="btn btn-primary btn-sm"
                                                                                @click="addFile()">Add File
                                                                        </button>
                                                                    </div>
                                                                    <button type="submit"
                                                                            class="btn btn-success btn-sm ">Save
                                                                    </button>
                                                                    <div x-show="loadingProgress"
                                                                         class="loading-progress">
                                                                        <div class="lds-ring">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="result mt-3" x-text="result"></div>
                                                                </div>


                                                            </div>

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


            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->

@endsection

@section('CSS')
    <style>

        [x-cloak] {
            display: none !important;
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

        .result {
            margin-top: 10px;
            color: #00ff00;
        }

        .loading-progress {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .lds-ring {
            /* change color here */
            color: #1c4c5b
        }

        .lds-ring,
        .lds-ring div {
            box-sizing: border-box;
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid currentColor;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: currentColor transparent transparent transparent;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
@endsection

@section('js')
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

        function course() {
            return {
                users: @json($users),
                link: "{{route('admin.courses.store')}}",
                access: @json($accessTypes),
                errors: '',
                loadingProgress: false,
                result: '',
                formData: {
                    user: "",
                    title: "",
                    description: "",
                    file: [],
                    access_select: @json(key($access_select)),
                    price: null,
                },
                addFile() {
                    this.formData.file.push({});
                },
                removeFile(index) {
                    this.formData.file.splice(index, 1);
                },
                updateFile(event, index) {
                    this.formData.file[index] = event.target.files[0]; // Correct `files` usage
                },
                async submit() {
                    this.formData.description = tinymce.activeEditor.getContent();
                    const formData = new FormData();
                    Object.keys(this.formData).forEach(key => {
                        console.log(key)
                        if (key === 'file') {
                            this.formData.file.forEach((file, index) => {
                                formData.append(`file[${index}]`, file);
                            });
                        }
                        else if(key === 'promoImage') {
                            formData.append(`file[promoImage]`, this.formData[key]);
                        }
                        else {
                            formData.append(key, this.formData[key]);
                        }
                    });
                    try {
                        this.loadingProgress = true;
                        this.errors = '';
                        this.result = '';
                        const response = await fetch(this.link, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const result = await response.json();
                        if (response.ok) {
                            this.result = result.message;
                            location.reload();
                            return this.loadingProgress = false;
                        }
                        this.errors = result.errors;
                        f
                        return this.loadingProgress = false;
                    } catch (error) {

                    }

                },
                async uploadPromo(event) {
                    const file = event.target.files[0];
                    if (file) {

                        this.formData.promoImage = file;
                    }
                }

            }
        }
    </script>
    <!--  TINYMCE END -->
    <script>

    </script>

@endsection
