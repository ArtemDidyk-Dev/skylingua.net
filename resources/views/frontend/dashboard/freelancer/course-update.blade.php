@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content"  x-data="course()" x-cloak>
        <div class="container">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="portfolio-item">
                        <div class="pro-head p-0 pb-2">
                            <h3 class="mb-0">{{ language('Courses update') }}: {{$course->name}}</h3>
                        </div>

                        <div>
                            <div class="row">
                                <div >
                                    <form @submit.prevent="submit()" class="form" id="submit-form"
                                          action="{{route('frontend.dashboard.courses.update', $course->id)}}"
                                          method="POST">
                                        <div >
                                            <!--begin::Tab-->
                                            <div class="tab-pane show active " id="tab-country-general" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <div style="padding: 0.25rem;" class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 ">
                                                                    <div >
                                                                        <div class="form-group row form-user_category">
                                                                            <label for="user_category"
                                                                                   class="col-lg-3 col-form-label">Type
                                                                                Access</label>
                                                                            <div class="col-lg-4">
                                                                                <select required class="form-control"
                                                                                        name="user"
                                                                                        x-model="formData.access_select">
                                                                                    <template
                                                                                        x-for="(accessItem, index) in access"
                                                                                        :key="index">
                                                                                        <option :value="index"
                                                                                                x-text="accessItem" :selected="index == formData.access_select"></option>
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
                                                                            <label for="promo_img" class="col-lg-3 col-form-label">Update Promo Image</label>
                                                                            <div class="col-lg-9">
                                                                                <input type="file" @change="uploadPromo($event)" name="promo_img" class="form-control image">
                                                                                <img :src="imgPromo" alt="">
                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            class="tab-pane fade show active"
                                                                            role="tabpanel"
                                                                            aria-labelledby="language-tab">
                                                                            <!--  NAME START  -->
                                                                            <div class="form-group">
                                                                                <span class="span-dvidder">Title</span>
                                                                                <input
                                                                                    type="text"
                                                                                    name="name"
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
                                                                                    class="tinymceEditor form-control">{{$course->description}}</textarea>

                                                                            </div>
                                                                            <!--  CONTENT END  -->

                                                                            <div x-show="errors" class="error__list">
                                                                                <ul>
                                                                                    <template
                                                                                        x-for="(error, key) in errors"
                                                                                        :key="key">
                                                                                        <li class="color: red"
                                                                                            x-text="error"></li>
                                                                                    </template>
                                                                                </ul>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <span class="span-dvidder">Upload Files</span>
                                                                                <template x-for="(file, index) in formData.file"
                                                                                          :key="index">
                                                                                    <div class="mb-3">
                                                                                        <div class="file-promo-tex">
                                                                                            <input x-show="!file.promo"
                                                                                                   type="file"
                                                                                                   :name="'files[' + index + ']'"
                                                                                                   class="form-control image"
                                                                                                   @change="updateFile($event, index)">
                                                                                            <a :href="file.path" x-show="file.promo"><span x-text="`Name:  ${file.name}`"></span></a>
                                                                                            <img width="300"  :src="file.promo" alt="">
                                                                                        </div>
                                                                                        <button type="button"
                                                                                                class="btn btn-danger btn-sm mt-2"
                                                                                                @click="removeFile(index, file?.link)">
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
                                                                                    class="btn btn-success btn-sm ">Update
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('CSS')
    <!-- CROPPER CSS  -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/cropper/croppie.css') }}">
    <style>
        [x-cloak] { display: none !important; }
        .course__item + .course__item {
            margin-top: 25px;
        }

        .course__item-content {
            margin-top: 20px;
        }

        .course__item-files {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-left: -25px;
        }

        .single__tab-files-item {
            display: flex;
            flex-basis: calc(25% - 25px);
            margin-left: 25px;
            flex-direction: column;
        }

        @media (max-width: 1200px) {
            .course__item-files {
                margin-left: 0px;
            }

            .single__tab-files-item {
                flex-basis: 100%;
                margin-left: 0px;
            }

            .single__tab-files-item img {
                width: 100%;
                height: 100%;
            }

            .course {
                margin-left: 0px;
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
            color: #f4542f;
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
        .file-promo-tex {
            display: flex;
            flex-direction: column;
        }
        .form-control.image {
            min-height: auto;
            padding-left: 10px;
        }
    </style>
@endsection

@section('JS')
    <!--  TINYMCE START -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.1/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinymceEditor',
            height: 263,
            resize: false,
            menubar: false,
            block_formats: "Paragraph=p;Heading 1=h1;Heading 2=h2",
            valid_elements: "p,h1,h2,ul,ol,li,strong,em,a[href],br",
            invalid_elements: "script,iframe,object,embed",
            forced_root_block: 'p',
            toolbar: 'undo redo |   h2   |  removeformat | bullist numlist |',
            valid_styles: {},
            plugins: 'paste lists',
            paste_as_text: true,
        });

        function course() {
            return {
                link: "{{route('frontend.dashboard.courses.update', $course->id)}}",
                errors: '',
                loadingProgress: false,
                result: '',
                access: @json($accessTypes),
                imgPromo: "{{$imgPromo}}",
                formData: {
                    user: "{{$course->user_id}}",
                    access_select: @json($access_select->type),
                    title: @json($course->name),
                    description: @json($course->description),
                    file: @json($files),
                    price: "{{$course->access->price}}",
                },
                addFile() {
                    this.formData.file.push({});
                },
                async  removeFile(index, link = null) {
                    this.formData.file.splice(index, 1);
                    if(link) {
                        await fetch(link, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    }
                },
                updateFile(event, index) {
                    this.formData.file[index] = event.target.files[0];
                },
                async uploadPromo(event) {
                    const file = event.target.files[0];
                    if (file) {

                        this.formData.promoImage = file;
                    }
                },
                async submit() {
                    this.formData.description = tinymce.activeEditor.getContent();
                    const formData = new FormData();
                    Object.keys(this.formData).forEach(key => {
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
                            this.loadingProgress = false;
                            location.reload();
                            return;

                        }
                        this.errors = result.errors;
                        return this.loadingProgress = false;
                    } catch (error) {

                    }

                }
            }
        }
    </script>
    <!--  TINYMCE END -->
    <script>

    </script>

@endsection
