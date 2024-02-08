@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="portfolio-item">
                        <div class="pro-head p-0 pb-4">
                            <h3 class="mb-0">{{ language('Portfolio') }}</h3>
                            <a class="btn btn-primary back-btn br-0 addPortfolio" data-bs-toggle="modal" href="#portfolio-add">{{ language('+ Add Portfolio') }}</a>
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

                        <div class="pro-content pt-4 pb-4">
                            <div class="row">
                                @if($portfolios)
                                    @foreach($portfolios as $portfolio)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="project-widget">
                                            <div class="portfolio-img">
                                                <div class="portfolio-approve">
                                                    {{ language('Approve:') }}
                                                    @if($portfolio->approve == 1)
                                                        <span class="badge bg-success">{{ language('Yes') }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ language('No') }}</span>
                                                    @endif
                                                </div>
                                                <img class="img-fluid" alt="{{ $portfolio->title }}" src="{{ !empty($portfolio->image) ? asset('storage/portfolio/'. $portfolio->image) : asset('storage/no_image_portfolio.jpg') }}">
                                                <div class="portfolio-live">
                                                    <div class="portfolio-content">
                                                        <a
                                                            data-bs-toggle="modal"
                                                            href="#portfolio-edit"
                                                            class="port-icon editPortfolio"
                                                            data-id="{{ $portfolio->id }}"
                                                            data-title="{{ $portfolio->title }}"
                                                            data-link="{{ $portfolio->link }}"
                                                            data-image="{{ !empty($portfolio->image) ? asset('storage/portfolio/'. $portfolio->image) : asset('storage/no_image_portfolio.jpg') }}"
                                                            data-image_yes="{{ !empty($portfolio->image) ? true : false }}"
                                                        ><i class="fas fa-pen"></i></a>
                                                        <a
                                                            data-bs-toggle="modal"
                                                            href="#portfolio-delete"
                                                            class="port-icon deletePortfolio"
                                                            data-id="{{ $portfolio->id }}"
                                                        ><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portfolio-detail">
                                                <h3 class="pro-name">{{ $portfolio->title }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                <div class="col-sm-12 col-lg-12">{{ language('No items') }}</div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                {{ $portfolios->appends(['search' => isset($searchText) ? $searchText : null])
->render('vendor.pagination.frontend.dashboard-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


    <!-- The addModal -->
    <div class="modal fade" id="portfolio-add">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Add Portfolio') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('Simple & Best Way To Showcase Your Work') }}</h3>
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0 0 0 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form id="add-form" action="{{ route('frontend.dashboard.freelancer.portfolio.add.tore') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="modal-info">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">{{ language('Title') }}</label>
                                        <input autocomplete="OFF" id="title" type="text" name="title" class="form-control" value="{{ old('title') }}">
                                        @error('title' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="link">{{ language('Link') }}</label>
                                        <input autocomplete="OFF" id="link" type="text" name="link" class="form-control" value="{{ old('link') }}">
                                        @error('link' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>


                                    <div class="form-group col-md-6 pro-pic mb-3">
                                        <label>{{ language('Portfolio image') }}</label>
                                        <div class="d-flex align-items-center">
                                            <div class="upload-images" style="width:110px;">
                                                <img src="{{ old('image_upload') ? old('image_upload') : asset('storage/no_image_portfolio.jpg') }}" alt="" class="add-crop-item-img-output">
                                                @if(old('image_upload'))
                                                <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm deletePhoto" title="{{ language('frontend.portfolio.delete_photo') }}"><i class="far fa-trash-alt"></i></a>
                                                @endif
                                            </div>
                                            <label class="file-upload image-upbtn ms-3">
                                                {{ language('Upload Image') }} <input type="file" class="crop-item-img" name="image">
                                            </label>
                                        </div>
                                        <input type="text" name="image_upload" value="{{ old('image_upload') }}" class="fileUpload">
                                        <input type="text" name="not_photo" class="notPhoto">
                                        <div class="alert alert-danger mt-3  cropImgError"></div>
                                        @error('image' )<span class="text-danger">{{ $message }}</span> @enderror
                                        <p class="text-muted">{{ language('Image size 300*300, formats (jpg,jpeg,png)') }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn">{{ language('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The editModal -->
    <div class="modal fade" id="portfolio-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Edit Portfolio') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('Simple & Best Way To Showcase Your Work') }}</h3>
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0 0 0 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form id="edit-form" action="{{ route('frontend.dashboard.freelancer.portfolio.edit.tore') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input id="editId" type="hidden" name="id" value="{{ old('id') }}">

                        <div class="modal-info">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editTitle">{{ language('Title') }}</label>
                                        <input autocomplete="OFF" id="editTitle" type="text" name="title" class="form-control" value="{{ old('title') }}">
                                        @error('title' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="editLink">{{ language('Link') }}</label>
                                        <input autocomplete="OFF" id="editLink" type="text" name="link" class="form-control" value="{{ old('link') }}">
                                        @error('link' )<span class="text-danger">{{ $message }}</span> @enderror
                                    </div>


                                    <div class="form-group col-md-6 pro-pic mb-3">
                                        <label>{{ language('Portfolio image') }}</label>
                                        <div class="d-flex align-items-center">
                                            <div class="upload-images" style="width:110px;">
                                                <img src="{{ (old('image_upload') ? old('image_upload') : (old('image_upload_url') ? old('image_upload_url') : asset('storage/no_image_portfolio.jpg'))) }}" alt="" class="edit-crop-item-img-output">

                                                <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm @if(!old('image_upload') && !old('image_upload_url')) d-none @endif deletePhoto" title="{{ language('frontend.portfolio.delete_photo') }}"><i class="far fa-trash-alt"></i></a>
                                            </div>
                                            <label class="file-upload image-upbtn ms-3">
                                                {{ language('Upload Image') }} <input type="file" class="crop-item-img" name="image">
                                            </label>
                                        </div>
                                        <input type="hidden" name="image_upload_url" value="{{ old('image_upload_url') }}" class="image_upload_url">
                                        <input type="text" name="image_upload" value="{{ old('image_upload') }}" class="fileUpload">
                                        <input type="text" name="not_photo" class="notPhoto">
                                        <div class="alert alert-danger mt-3  cropImgError"></div>
                                        @error('image' )<span class="text-danger">{{ $message }}</span> @enderror
                                        <p class="text-muted">{{ language('Image size 300*300, formats (jpg,jpeg,png)') }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn">{{ language('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- The deleteModal -->
    <div class="modal fade" id="portfolio-delete">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>{{ language('Delete Portfolio') }}</h4>
                    <span class="modal-close"><a href="#" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle orange-text"></i></a></span>
                </div>
                <div class="modal-body">
                    <div class="port-title">
                        <h3>{{ language('This portfolio will be permanently deleted. Are you sure?') }}</h3>
                    </div>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0 0 0 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form id="edit-form" action="{{ route('frontend.dashboard.freelancer.portfolio.delete.tore') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input id="deleteId" type="hidden" name="id" value="{{ old('id') }}">

                        <div class="submit-section text-right">
                            <a data-bs-dismiss="modal" class="btn btn-primary black-btn submit-btn">{{ language('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary submit-btn">{{ language('Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /The deleteModal -->



    <!--  add CROP IMAGE START  -->
    <div class="modal fade" id="addCropImagePop" tabindex="-1" aria-labelledby="addCropImagePopLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCropImagePopLabel">{{ language('frontend.edit_profile.profile_photo') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ language('frontend.common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <div id="add-upload-crop-img" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addCancelCropBtn" class="btn btn-secondary" data-bs-dismiss="modal">{{ language('frontend.common.close') }}</button>
                    <button type="button" id="addCropImageBtn" class="btn btn-primary ">{{ language('frontend.common.crop') }}</button>
                </div>

            </div>
        </div>
    </div>
    <!--  add CROP IMAGE END  -->

    <!-- edit CROP IMAGE START  -->
    <div class="modal fade" id="editCropImagePop" tabindex="-1" aria-labelledby="editCropImagePopLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCropImagePopLabel">{{ language('frontend.edit_profile.profile_photo') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ language('frontend.common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <div id="edit-upload-crop-img" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="editCancelCropBtn" class="btn btn-secondary" data-bs-dismiss="modal">{{ language('frontend.common.close') }}</button>
                    <button type="button" id="editCropImageBtn" class="btn btn-primary ">{{ language('frontend.common.crop') }}</button>
                </div>

            </div>
        </div>
    </div>
    <!-- edit CROP IMAGE END  -->

@endsection



@section('CSS')
    <!-- CROPPER CSS  -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/cropper/croppie.css') }}">
@endsection

@section('JS')
    <!-- Jquery Cookie STAST -->
    <script src="{{ asset('frontend/assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>

    <!--  CROPPER JS START -->
    <script src="{{ asset('frontend/assets/plugins/cropper/croppie.js') }}"></script>

    <script>
        /*   CROP IMG START   */
        let $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

        function addReadFile(input) {
            if (input.files[0].type == "image/jpeg" || input.files[0].type == "image/png") {
                if (input.files && input.files[0]) {
                    $('#portfolio-add .cropImgError').hide();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        // $('#addCropImagePop .upload-crop-img').addClass('ready');
                        $('#addCropImagePop #add-upload-crop-img').addClass('ready');
                        $('#addCropImagePop').modal('show');
                        rawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    // console.log("Sorry - you're browser doesn't support the FileReader API");
                }
            } else {
                $('#portfolio-add .cropImgError').fadeIn();
                $('#portfolio-add .cropImgError').html('{{ language('frontend.portfolio.image_format_error') }}')
            }

        }

        $uploadCrop = $('#add-upload-crop-img').croppie({
            viewport: {
                width: 272,
                height: 197,
            },
            enforceBoundary: true,
            enableExif: true
        });
        $('#addCropImagePop').on('shown.bs.modal', function () {
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function () {
                // console.log('jQuery bind complete');
            });
        });

        $('#portfolio-add .crop-item-img').on('change', function () {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#addCancelCropBtn').data('id', imageId);
            addReadFile(this);
        });
        $('#addCropImageBtn').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {width: 1024, height: 742}
            }).then(function (resp) {
                $('#portfolio-add .add-crop-item-img-output').attr('src', resp);
                $('#addCropImagePop').modal('hide');
                $('#portfolio-add .deletePhoto').remove();
                $('#portfolio-add .pro-pic .upload-images').prepend(`
                <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm deletePhoto" title="{{ language('frontend.portfolio.delete_image') }}"><i class="far fa-trash-alt"></i></a>
                `);
                $('#portfolio-add .notPhoto').val('');
                $('#portfolio-add .fileUpload').val(resp);
            });
        });
        // End upload preview image

        $(document).on('click', '#portfolio-add .deletePhoto', function () {
            $(this).remove();
            $('#portfolio-add .notPhoto').val('1');
            $('#portfolio-add .crop-item-img').val('');
            $('#portfolio-add .image_upload').val('');
            $('#portfolio-add .add-crop-item-img-output').attr("src", "{{ asset('storage/no_image_portfolio.jpg') }}");
            $('#portfolio-add .fileUpload').val('');
        })
    </script>

    <script>
        /*   CROP IMG START   */
        let $editUploadCrop,
            editTempFilename,
            editRawImg,
            editImageId;

        function editReadFile(input) {
            if (input.files[0].type == "image/jpeg" || input.files[0].type == "image/png") {
                if (input.files && input.files[0]) {
                    $('#portfolio-edit .cropImgError').hide();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        // $('#editCropImagePop .upload-crop-img').addClass('ready');
                        $('#editCropImagePop #edit-upload-crop-img').addClass('ready');
                        $('#editCropImagePop').modal('show');
                        editRawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    // console.log("Sorry - you're browser doesn't support the FileReader API");
                }
            } else {
                $('#portfolio-edit .cropImgError').fadeIn();
                $('#portfolio-edit .cropImgError').html('{{ language('frontend.portfolio.image_format_error') }}')
            }

        }

        $editUploadCrop = $('#edit-upload-crop-img').croppie({
            viewport: {
                width: 272,
                height: 197,
            },
            enforceBoundary: true,
            enableExif: true
        });
        $('#editCropImagePop').on('shown.bs.modal', function () {
            // alert('Shown pop');
            $editUploadCrop.croppie('bind', {
                url: editRawImg
            }).then(function () {
                // console.log('jQuery bind complete');
            });
        });

        $('#portfolio-edit .crop-item-img').on('change', function () {
            editImageId = $(this).data('id');
            editTempFilename = $(this).val();
            $('#editCancelCropBtn').data('id', editImageId);
            editReadFile(this);
        });
        $('#editCropImageBtn').on('click', function (ev) {
            $editUploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {width: 1024, height: 742}
            }).then(function (resp) {
                $('#portfolio-edit .edit-crop-item-img-output').attr('src', resp);
                $('#editCropImagePop').modal('hide');
                $('#portfolio-edit .deletePhoto').remove();
                $('#portfolio-edit .pro-pic .upload-images').prepend(`
                <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm deletePhoto" title="{{ language('frontend.portfolio.delete_image') }}"><i class="far fa-trash-alt"></i></a>
                `);
                $('#portfolio-edit .notPhoto').val('');
                $('#portfolio-edit .fileUpload').val(resp);
            });
        });
        // End upload preview image

        $(document).on('click', '#portfolio-edit .deletePhoto', function () {
            $(this).remove();
            $('#portfolio-edit .notPhoto').val('1');
            $('#portfolio-edit .crop-item-img').val('');
            $('#portfolio-edit .image_upload').val('');
            $('#portfolio-edit .edit-crop-item-img-output').attr("src", "{{ asset('storage/no_image_portfolio.jpg') }}");
            $('#portfolio-edit .fileUpload').val('');
        })
    </script>

    <script>
        $('.addPortfolio').on('click', function (event) {
            $.cookie("addModal", 1);
        });

        $('.editPortfolio').on('click', function (event) {
            $.cookie("editModal", 1);

            let portfolio_id = $(this).data('id');
            let portfolio_title = $(this).data('title');
            let portfolio_link = $(this).data('link');
            let portfolio_image = $(this).data('image');
            let portfolio_image_yes = $(this).data('image_yes');

            $('#portfolio-edit #editId').val(portfolio_id);
            $('#portfolio-edit #editTitle').val(portfolio_title);
            $('#portfolio-edit #editLink').val(portfolio_link);
            $('#portfolio-edit .image_upload_url').val(portfolio_image);
            $('#portfolio-edit .edit-crop-item-img-output').attr('src', portfolio_image);
            $('#portfolio-edit .deletePhoto').removeClass('d-none');
            if (portfolio_image_yes == false) {
                $('#portfolio-edit .deletePhoto').addClass('d-none');
            }

        });

        $('.deletePortfolio').on('click', function (event) {
            let portfolio_id = $(this).data('id');

            $('#portfolio-delete #deleteId').val(portfolio_id);
        });

        @if(session()->has('message'))
        $.removeCookie("addModal");
        $.removeCookie("editModal");
        @endif

        $('#portfolio-add').on('hidden.bs.modal', function () {
            $.removeCookie("addModal");
        });
        $('#portfolio-edit').on('hidden.bs.modal', function () {
            $.removeCookie("editModal");
        });

        $(window).on('load', function() {
            let addModal = $.cookie("addModal");
            let editModal = $.cookie("editModal");

            if (addModal == 1) {
                $('#portfolio-add').modal('show');
            }
            @if(old('id'))
            if (editModal == 1) {
                $('#portfolio-edit').modal('show');
            }
            @endif
        });
    </script>
@endsection

