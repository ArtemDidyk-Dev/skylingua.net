@extends('admin.layouts.index')
@section('title')
    Edit Subscriber {{$subscriber->name}}
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
                            Edit Subscriber {{$subscriber->name}}
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
                <div class="col-12 ">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Edit Subscriber {{$subscriber->name}}</h3>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.subscriber.update', $subscriber) }}" method="POST" >
                                        @method('post')
                                        @csrf
                                        <div class="card-body">
                                            <div class="mb-15">
                                                <!--  Name  -->
                                                <div class="form-group row form-name">
                                                    <label for="name" class="col-lg-3 col-form-label">Name</label>
                                                    <div class="col-lg-9">
                                                        <input id="name" type="text" name="name" value="{{$subscriber->name}}" class="form-control form-control-lg" placeholder="name" required/>
                                                        @error('name' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <!--  CONTENT START  -->
                                                <div class="form-group">
                                                    <span class="span-dvidder">Description</span>
                                                    <textarea
                                                        type="text"
                                                        name="description"
                                                        class="tinymceEditor form-control">{{$subscriber->description}}</textarea>
                                                    @error('description')<span
                                                        class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <!--  CONTENT END  -->

                                                <div class="form-group">
                                                    <span class="span-dvidder">User</span>
                                                    <select form="submit-form" class="form-control" name="user_id" required>
                                                        @foreach($users as $user)
                                                            <option {{ $subscriber->user->id == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="price" class="col-lg-3 col-form-label">Price</label>
                                                    <div class="col-lg-12">
                                                        <input id="price" type="number" name="price" value="{{ $subscriber->price }}"
                                                               class="form-control form-control-lg"
                                                               placeholder="Enter price"
                                                               step="0.01" min="0.01" required />
                                                        @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Update</button>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
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
    </style>
@endsection

@section('js')
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
@endsection
