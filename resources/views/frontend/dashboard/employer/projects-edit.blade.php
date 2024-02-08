@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content content-page">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->


                <div class="col-xl-9 col-md-8">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>{{ language('Project edit') }}</h3>
                            </div>
{{--                            <div class="col-md-6 text-end">--}}
{{--                                <a href="#" class="btn btn-primary back-btn mb-4">Post a Project</a>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                            <ul>
                                <li>{{ session()->get('message') }}</li>
                            </ul>
                        </div>
                    @endif

                    <div class="select-project mb-4">
                        <form action="{{route('frontend.dashboard.employer.employerProjectUpdate')}}" enctype="multipart/form-data" method="POST">
                            @csrf

                            <input type="hidden" name="id" value="{{ old('id', $project->id) }}">

                            <div class="title-box widget-box">

                                <div class="row">
                                    <div class="col-12">
                                        <!-- Project Title -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Project Name') }}</h3>
                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" autocomplete="OFF" name="name" value="{{ old('name', $project->name) }}">
                                                    @error('name')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Project Title -->
                                    </div>

                                    <div class="col-6">
                                    <!-- Country Content -->
                                    <div class="title-content">
                                        <div class="title-detail">
                                            <h3>{{ language('Country') }}</h3>
                                            <div class="form-group mb-0">
                                                <select class="form-control select" name="country_id">
                                                    @foreach($countries as $country)
                                                    <option  value="{{ $country->id }}" @if(old('country_id', $project->country_id) == $country->id) selected @endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Country Content -->
                                    </div>

                                    <div class="col-6">
                                        <!-- Category Content -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Freelancer category') }}</h3>
                                                <div class="form-group mb-0">
                                                    <select class="selectCategory form-control" name="user_category_id[]"  multiple="multiple">
                                                        @foreach($user_categories as $category)
                                                            <option  value="{{ $category->id }}" {{in_array($category->id, old("user_category_id",$projects_categories) ?: []) ? "selected" : ""}}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Category Content -->
                                    </div>


                                    <div class="col-6">
                                        <!-- Price Type Content -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Pricing Type') }}</h3>
                                                <div class="form-group price-cont mb-0" id="price_type">
                                                    <select name="price_type" class="form-control select">
                                                        <option value="0">{{ language('Select') }}</option>
                                                        <option value="1" @if(old('price_type', $project->price_type)==1) selected @endif
                                                        >{{ language('Fixed Price') }}</option>
                                                        <option value="2" @if(old('price_type', $project->price_type)==2) selected @endif
                                                        >{{ language('Hourly Pricing') }}</option>
                                                        <option value="3" @if(old('price_type', $project->price_type)==3) selected @endif
                                                        >{{ language('Bidding Price') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Price Type Content -->
                                    </div>

                                    <div class="col-6" id="price_project" @if(old('price_type', $project->price_type)!=1 && old('price_type', $project->price_type)!=2) style="display: none;" @endif>
                                        <!-- Price Content -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Pricing') }}</h3>
                                                <div class="form-group mt-3" >
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-white" style="height:46px;">{{ language('frontend.currency') }}</button>
                                                        </div>
                                                        <input
                                                            type="number"
                                                            step="0.1"
                                                            min="0"
                                                            class="form-control"
                                                            name="price"
                                                            value="{{ old('price', $project->price) }}"
                                                            autocomplete="OFF"
                                                            placeholder="20.00"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- /Price Content -->
                                    </div>


                                    <div class="col-6">
                                        <!-- Project Period Content -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Period of Project') }}</h3>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="filter-widget mb-0" id="period_date">
                                                            <div class="cal-icon">
                                                                <input type="text" class="form-control datetimepicker" name="deadline" value="{{ old('deadline', $project->deadline) }}" placeholder="{{ language('Select Date') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Project Period Content -->
                                    </div>

                                    <div class="col-6">
                                        <!-- /Add Document -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Add Documents') }}</h3>
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
                                                <p class="mb-0">{{ language('Size of the Document should be Below 2MB. Formats (pdf,xlx,csv,doc,docx,jpg,jpeg,png,gif)') }}</p>
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
                                        <!-- /Add Document -->
                                    </div>

                                    <div class="col-6">
                                        <!-- Add Links -->
                                        <div class="title-content">
                                            <div class="title-detail">
                                                <h3>{{ language('Add Links') }}</h3>
                                                <div class="links-info">
                                                    @if(old('links', $project->links))
                                                        @foreach(old('links', $project->links) as $link_index => $link)
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
                                                            <div class="form-group mb-0">
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
                                        <!-- /Add Links -->
                                    </div>

                                    <div class="col-12">
                                        <!-- Project Description -->
                                        <div class="title-content pb-0">
                                            <div class="title-detail">
                                                <h3>{{ language('Write Description of Projects') }}</h3>
                                                <div class="form-group mb-0">
                                                    <textarea class="form-control summernote" name="description"  rows="5">{!! old('description', $project->description) !!} </textarea>
                                                    @error('description')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Project Description -->
                                    </div>

                                    <div class="row">
                                        <div class="text-end">
                                            <div class="btn-item">
                                                @if($project->status == 1)
                                                <button name="publish" value="0" class="btn btn-warning click-btn b-0" type="submit">{{ language('Unpublish') }}</button>
                                                @endif

                                                @if($project->status == 0)
                                                <button class="btn btn-primary click-btn b-0" type="submit">{{ language('Edit Project') }}</button>
                                                <button name="publish" value="1" class="btn btn-success click-btn b-0" type="submit">{{ language('Edit & Publish') }}</button>
                                                @endif
                                            </div>
                                        </div>
{{--                                        <div class="col-md-12 text-end">--}}
{{--                                            <div class="btn-item">--}}
{{--                                                <button name="publish" value="0" type="submit" class="btn next-btn">Unpublish</button>--}}
{{--                                            </div>--}}
{{--                                            <div class="btn-item">--}}
{{--                                                <button name="publish" value="1" type="submit" class="btn next-btn">Publish</button>--}}
{{--                                            </div>--}}
{{--                                            <div class="btn-item">--}}
{{--                                                <button type="submit" class="btn next-btn">Submit</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>

                                </div>

                            </div>
                            <!-- Project Title -->

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
    <script>
        $.fileup({
            url: '{{ route('frontend.dashboard.fileUpload') }}',
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
                    url: '{{ route('frontend.dashboard.fileDelete') }}',
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

    <script>
        if($('.selectCategory').length > 0) {
            $('.selectCategory').select2({
                width: '100%'
            });
        }


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
@endsection

