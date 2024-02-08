@extends('admin.layouts.index')
@section('title')
    Edit Project
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
                            <a href="{{ route('admin.page.index') }}" class="text-muted">Projects</a>
                        </li>

                        <li class="breadcrumb-item">
                            Edit Project
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
                        <!--begin::Card header-->
                        <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a class="nav-link active" data-toggle="tab" href="#tab-page-general">
                                            <span class="nav-text font-size-lg">GENERAL</span>
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
                            <form class="form" id="submit-form" action="{{ route('admin.project.update') }}"
                                  enctype="multipart/form-data"
                                  method="POST"
                            >

                                <input type="hidden" name="id" value="{{ old('id', $project->id) }}">
                                @csrf

                                <div style="padding-top: 0" class="tab-content">
                                    <!--begin::Tab-->
                                    <div class="tab-pane show active " id="tab-page-general" role="tabpanel">

                                        {{-- Error messages--}}
                                        {{ myErrors($errors) }}

                                        <div class="row">
                                            <div class="col-md-12 ">


                                                <div style="padding: 0.25rem;" class="card-body">


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
                                                                             <img
                                                                                 src="{{ countryFlag($language->code) }}"/>
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


                                                                        <!--  USER START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">User Name ({{ $language->code }})</span>
                                                                            <input
                                                                                id="projectUserName"
                                                                                type="text"
                                                                                autocomplete="OFF"
                                                                                class=" form-control">
                                                                            <div class="projectUserNameList"></div>

                                                                            <div class="projectUserNameResult"  style="display: block"  >
                                                                                   {{ \App\Services\UserService::getUserNameEmail(old('user_name', $project->employer_id))->name }}
                                                                                    ({{ \App\Services\UserService::getUserNameEmail(old('user_name', $project->employer_id))->email }})
                                                                                </div>
                                                                            <input
                                                                                id="projectUserID"
                                                                                type="hidden"
                                                                                name="user_name"
                                                                                value="{{ old('user_name', $project->employer_id) }}"
                                                                            >
                                                                            @error('user_name' )<span
                                                                                class="text-danger">{{ $message }}</span> @enderror
                                                                        </div>
                                                                        <!--  USER END  -->

                                                                        <!--  Project Name START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Project Name ({{ $language->code }})</span>
                                                                            <input
                                                                                type="text"
                                                                                autocomplete="OFF"
                                                                                name="name"
                                                                                value="{{ old('name', $project->name) }}"
                                                                                class=" form-control">

                                                                            @error('name' )<span
                                                                                class="text-danger">{{ $message }}</span> @enderror
                                                                        </div>
                                                                        <!--  Project Name END  -->


                                                                        <!--  Country START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Country ({{ $language->code }})</span>
                                                                            <select class="form-control select" name="country_id">
                                                                                @foreach($countries as $country)
                                                                                    <option  value="{{ $country->id }}" @if(old('country_id', $project->country_id) == $country->id) selected @endif >{{ $country->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('country_id' )<span
                                                                                class="text-danger">{{ $message }}</span> @enderror
                                                                        </div>
                                                                        <!--  Country END  -->


                                                                        <!--  Freelancer category START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Freelancer category ({{ $language->code }})</span>
                                                                            <div class="form-group">
                                                                                <select class="form-control" id="kt_select2_3" name="user_category_id[]"  multiple="multiple">
                                                                                    @foreach($user_categories as $category)

                                                                                        <option  value="{{ $category->id }}" {{in_array($category->id, old("user_category_id",$projects_categories) ?: []) ? "selected" : ""}} >{{ $category->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('user_category_id' )<span
                                                                                    class="text-danger">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <!--  Freelancer category END  -->


                                                                        <!--  Pricing Type START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Pricing Type ({{ $language->code }})</span>
                                                                            <div class="form-group price-cont">
                                                                                <select name="price_type" id="price_type" class="form-control select">
                                                                                    <option value="0">Select</option>
                                                                                    <option value="1" @if(old('price_type', $project->price_type)==1) selected @endif
                                                                                    >Fixed Price</option>
                                                                                    <option value="2" @if(old('price_type', $project->price_type)==2) selected @endif
                                                                                    >Hourly Pricing</option>
                                                                                    <option value="3" @if(old('price_type', $project->price_type)==3) selected @endif
                                                                                    >Bidding Price</option>
                                                                                </select>
                                                                                @error('price_type' )<span
                                                                                    class="text-danger">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <!--  Pricing Type END  -->


                                                                        <!--  Pricing START  -->
                                                                        <div class="form-group" id="price_project" @if(old('price_type', $project->price_type)!=1 && old('price_type', $project->price_type)!=2) style="display: none;" @endif>
                                                                            <span class="span-dvidder">Pricing ({{ $language->code }})</span>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">$</span>
                                                                                </div>
                                                                                <input
                                                                                    type="number"
                                                                                    step="0.1"
                                                                                    min="0"
                                                                                    class="form-control"
                                                                                    name="price"
                                                                                    value="{{ old('price',$project->price) }}"
                                                                                    autocomplete="OFF"
                                                                                    placeholder="20.00"
                                                                                >
                                                                            </div>

                                                                            @error('price' )<span
                                                                                class="text-danger">{{ $message }}</span> @enderror
                                                                        </div>
                                                                        <!--  Pricing END  -->





                                                                        <!--  Period of Project START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Period of Project ({{ $language->code }})</span>
                                                                            <div class="form-group">
                                                                                <div class="input-group input-group-solid date" id="kt_datetimepicker_3" data-target-input="nearest">
                                                                                    <input type="text" class="form-control form-control-solid datetimepicker-input" name="deadline" value="{{ old('deadline', $project->deadline) }}" placeholder="Select period of Project" data-target="#kt_datetimepicker_3" />
                                                                                    <div class="input-group-append" data-target="#kt_datetimepicker_3" data-toggle="datetimepicker">
															<span class="input-group-text">
																<i class="ki ki-calendar"></i>
															</span>
                                                                                    </div>
                                                                                </div>
                                                                                @error('deadline' )<span
                                                                                    class="text-danger">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <!--  Period of Project END  -->




                                                                        <!--Add Documents START-->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Add Documents ({{ $language->code }})</span>
                                                                            <div class="title-content">
                                                                                <div class="title-detail">
                                                                                    <div class="custom-file">
                                                                                        <input
                                                                                            type="file"
                                                                                            name="file"
                                                                                            id="file"
                                                                                            multiple
                                                                                            class="custom-file-input"
                                                                                        >
                                                                                        <label class="custom-file-label custom-file-label-orange"></label>
                                                                                    </div>
                                                                                    <p class="mb-0">Size of the Document should be Below 2MB. Formats
                                                                                        (pdf,xlx,csv,doc,docx,jpg,jpeg,png,gif)</p>
                                                                                    @error('document')
                                                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                                                    @enderror

                                                                                    <div id="file-queue"></div>
                                                                                    <div class="upload-wrap" id="file_names">
                                                                                        @if(old('document', $project->document))
                                                                                            @php ($delete_documents = (old('delete_document') ? old('delete_document') : []) )
                                                                                            @foreach($delete_documents as $delete_document_index => $delete_document)
                                                                                                <input
                                                                                                    type="hidden1"
                                                                                                    name="delete_document[]"
                                                                                                    id="delete_document{{ $delete_document_index }}"
                                                                                                    value="{{ $delete_document }}"
                                                                                                >
                                                                                            @endforeach

                                                                                            @foreach(old('document', $project->document) as $document_index => $document)
                                                                                                @if( !in_array($document, $delete_documents ) )
                                                                                                    <input
                                                                                                        type="hidden"
                                                                                                        name="document[]"
                                                                                                        id="document{{ $document_index }}"
                                                                                                        value="{{ $document }}"
                                                                                                    >
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--Add Documents END-->




                                                                        <!-- Add Links START -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Add Links ({{ $language->code }})</span>
                                                                            <div class="title-content">
                                                                                <div class="title-detail">
                                                                                    <div class="links-info">
                                                                                        @if(old('links',$project->links))
                                                                                            @foreach(old('links',$project->links) as $link_index => $link)
                                                                                                <div class="row form-row links-cont">
                                                                                                    <div class="col-12 col-md-11">
                                                                                                        <div class="form-group">
                                                                                                            <input type="text" name="links[]" class="form-control" value="{{ $link }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-12 col-md-1">
                                                                                                        @if($link_index == 0)
                                                                                                            <a href="javascript:void(0);" class="btn project-add-links"><i class="fas fa-plus"></i></a>
                                                                                                        @else
                                                                                                            <a href="javascript:void(0);" class="btn btn-danger trash trashLink"><i class="far fa-trash-alt"></i></a>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <div class="row form-row links-cont">
                                                                                                <div class="col-12 col-md-11">
                                                                                                    <div class="form-group mb-5">
                                                                                                        <input type="text" name="links[]"  class="form-control">
                                                                                                        <p class="mb-0"></p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-12 col-md-1">
                                                                                                    <a href="javascript:void(0);" class="btn project-add-links"><i class="fas fa-plus"></i></a>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Add Links END -->



                                                                        <!--  Write Description of Projects START  -->
                                                                        <div class="form-group">
                                                                            <span class="span-dvidder">Description ({{ $language->code }})</span>
                                                                            <textarea
                                                                                name="description"
                                                                                class="tinymceEditor form-control">{!! old('description',$project->description) !!}</textarea>
                                                                            @error('description')
                                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <!--  Write Description of Projects END  -->





                                                                    </div>

                                                                @endforeach


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
                <div class="col-my-lg-4 ">

                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Note</h3>
                            </div>


                        </div>

                        <div class="card-body">
                            <!--  STATUS  -->
                            <div class="form-group row">
                                <label for="status" class="col-lg-3 col-form-label">Status</label>
                                <div class="col-lg-9">
                                    <select form="submit-form" class="form-control" name="status">
                                        <option {{ old('status',$project->status) == 0 ? 'selected' : '' }} value="0">Unpublish</option>
                                        <option {{ old('status',$project->status) == 1 ? 'selected' : '' }} value="1">Publish</option>
                                        <option {{ old('status',$project->status) == 2 ? 'selected' : '' }} value="2">Pending</option>
                                        <option {{ old('status',$project->status) == 3 ? 'selected' : '' }} value="3">Ongoing</option>
                                        <option {{ old('status',$project->status) == 4 ? 'selected' : '' }} value="4">Completed</option>
                                        <option {{ old('status',$project->status) == 5 ? 'selected' : '' }} value="5">Canceled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!--  Approve  -->
                            <div class="form-group row">
                                <label for="approve" class="col-lg-3 col-form-label">Approve</label>
                                <div class="col-lg-9">
                                    <select form="submit-form" class="form-control" name="approve">
                                        <option {{ old('approve',$project->approve) == 0 ? 'selected' : '' }} value="0">No</option>
                                        <option {{ old('approve',$project->approve) == 1 ? 'selected' : '' }} value="1">Yes</option>
                                    </select>
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

    <script src="https://cdn.rawgit.com/shabuninil/fileup/master/src/fileup.min.js"></script>

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

        var nameSearchInterval;
        $(document).on('keyup','#projectUserName',function (){

            $('body').prepend(`<div class="userSearchOverlay"></div>`);

            clearTimeout(nameSearchInterval);
            nameSearchInterval = setTimeout(function () {

                let data = $('#projectUserName').val();

                if(data == ''){
                    $('.projectUserNameList').hide();
                    $('.userSearchOverlay').remove();
                }else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.project.nameSearch') }}",
                        data: {data:data},
                        dataType: "json",
                        cache: false,
                        success: function (response) {
                            if(response.success){
                                $('.projectUserNameList').html('');
                                if(response.data.length == 0){
                                    $('.projectUserNameList').html('<span>No result</span>');
                                }else {
                                    $('.projectUserNameList').html('<ul></ul>');
                                    let responseData = response.data;
                                    responseData.forEach(function (data){
                                        $('.projectUserNameList ul').append(`<li data-userID="${data.id}">${data.name} (${data.email})</li>`);

                                    });
                                }


                            }

                        }
                    });
                    $('.projectUserNameList').show();
                }

            }, 300);

        });


        $(document).on('click','.userSearchOverlay',function (){
            $('.projectUserNameList').hide();
            $('.projectUserNameList').html('');
            $('.userSearchOverlay').remove();
        })

        // projectUserNameResult

        $(document).on('click','.projectUserNameList ul li',function (){
            let userName = $(this).text();
            let userID = $(this).attr('data-userID');
            $('.projectUserNameResult').text(userName);
            $('#projectUserID').val(userID);
            $('.projectUserNameResult').show();
            $('#projectUserName').val('');
            $('.projectUserNameList').hide();
        })



    </script>


    <!--  SELECT  -->
    <script>
        $('#kt_select2_3').select2({
            placeholder: "Select freelancer category",
        });
    </script>


    <!--  CHANGE PRICE TYPE  -->
    <script>
        $('#price_type').on('change', function() {
            if ($(".price-cont select option:selected").val() == '1') {
                $('#price_project').show();
                $('#price_id').show();
                $('#hour_id').hide();
            }
            else if ($(".price-cont select option:selected").val() == '2') {
                $('#price_project').show();
                $('#price_id').hide();
                $('#hour_id').show();
            }
            else if ($(".price-cont select option:selected").val() == '3') {
                $('#price_project').hide();
                $('#price_project input').val('');
                $('#price_id').hide();
                $('#hour_id').hide();
            }
            else if ($(".price-cont select option:selected").val() == '0') {
                $('#price_project').hide();
                $('#price_project input').val('');
                $('#price_id').hide();
                $('#hour_id').hide();
            }
        });
    </script>


    <!--  DATETIMEPICKER  -->
    <script>
        $('#kt_datetimepicker_3').datetimepicker({
            format: 'YYYY-MM-DD',
        });
    </script>


    <!--  FILE UPLOAD  -->


    <script>
        $.fileup({
            url: '{{ route('admin.project.fileUploadAjax') }}',
            inputID: 'file',
            queueID: 'file-queue',
            @if(old('document', $project->document))
            files: [
                    @foreach(old('document', $project->document) as $document_index => $document)
                {
                    @if( !in_array($document, $delete_documents ) )
                    id: {{ $document_index }},
                    name: '{{ $document }}', // required
                    size: '{{ \Illuminate\Support\Facades\Storage::size('public/project-documents/'. $document) }}',  // required
                    @if(pathinfo(public_path('public/project-documents/'.$document))['extension'] == "jpg" ||
                    pathinfo(public_path('public/project-documents/'. $document))['extension'] == "jpeg" ||
                    pathinfo(public_path('public/project-documents/'. $document))['extension'] == "png")
                    previewUrl: '{{ asset('storage/project-documents/'. $document) }}',
                    @endif
                    @endif
                },
                @endforeach
            ],
            @endif
            autostart: true,
            extraFields: {
                _token: "{{ csrf_token() }}"
            },
            onSuccess: function(response, file_number, file) {

                $('#file_names').append('<input type="hidden" name="document[]" id="document'+
                    file_number +'" value="'+ file.name +'">');

            },
            onError: function(event, file, file_number, response) {

                const response_json = JSON.parse(response);

                Snarl.addNotification({
                    title: response_json.message,
                    text: response_json.errors.filedata,
                    icon: '<i class="fa fa-times"></i>',
                });

            },
            onRemove: function(file, total) {
                $.ajax({
                    url: '{{ route('admin.project.fileDeleteAjax') }}',
                    type: 'POST',
                    data: {
                        file: file.file.name,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(json) {
                        if (json.success == true) {

                            $('#file_names').find('#document'+ file.file_number).remove();

                        } // if
                    }
                });
            },
        });
    </script>




    <!--  ADD LINKS  -->
    <script>

        $(".links-info").on('click','.trashLink', function () {
            $(this).closest('.links-cont').remove();
            return false;
        });

        $(".project-add-links").on('click', function () {

            var experiencecontent = '<div class="row form-row links-cont">' +
                '<div class="col-12 col-md-11 col-lg-11">' +
                '<div class="form-group">' +
                '<input type="text" name="links[]" class="form-control">' +
                '</div>' +
                '</div>' +
                '<div class="col-12 col-md-1 col-lg-1">' +
                '<a href="javascript:void(0);" class="btn btn-danger trash trashLink"><i class="far fa-trash-alt"></i></a>' +
                '</div>' +
                '</div>';

            $(".links-info").append(experiencecontent);
            return false;
        });

    </script>


    <!--  EDITOR  -->
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










@endsection
