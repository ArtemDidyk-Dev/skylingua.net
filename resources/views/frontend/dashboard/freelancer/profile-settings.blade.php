@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="pro-pos">
                        @include('frontend.dashboard.freelancer._profileNav', ['user' => $user])

                        <div class="setting-content">

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

                            <form id="submit-form"
                                  action="{{ route('frontend.dashboard.freelancer.profile-settings.store') }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <div class="card">
                                    <div class="pro-head">
                                        <h3 class="pro-title without-border mb-0">{{ language('Profile Basics') }}</h3>
                                    </div>
                                    <div class="pro-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name">{{ language('Dispaly Name') }}</label>
                                                <input autocomplete="OFF" id="name" type="text" name="name"
                                                       class="form-control" value="{{ old('name',$user->name) }}">
                                                @error('name' )<span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">{{ language('Email Address') }}</label>
                                                <input autocomplete="OFF" id="email" type="text" name="email"
                                                       value="{{ old('email',$user->email) }}" class="form-control"
                                                       readonly>
                                                @error('email' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tel">{{ language('Contact Number') }}</label>
                                                <input autocomplete="OFF" id="phone" type="tel" name="phone"
                                                       value="{{ old('phone',$user->phone) }}" class="form-control">
                                                @error('phone' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="user_category">{{ language('Designation') }}</label>
                                                <select class="form-control select" name="user_category"
                                                        id="user_category">
                                                    <option value="">{{ language('frontend.common.select') }}</option>
                                                    @foreach($user_categories as $user_category)
                                                        <option
                                                            {{ old('user_category',$user->user_category) == $user_category->id ? 'selected':null }} value="{{ $user_category->id }}">{{ $user_category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_category' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="hourly_rate">{{ language('Hourly Rate') }}</label>
                                                $<input autocomplete="OFF" id="hourly_rate" type="number" min="0"
                                                        step="0.01" name="hourly_rate"
                                                        value="{{ old('hourly_rate',$user->hourly_rate) }}"
                                                        class="form-control">
                                                @error('hourly_rate' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                                <p class="light-pink-text mb-0">{{ language('Provide your hourly rate without currency symbol') }}</p>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="time_rate">{{ language('Time Rate') }}</label>
                                                <input autocomplete="OFF" id="time_rate" type="text" name="time_rate"
                                                       value="{{ old('time_rate',$user->time_rate) }}"
                                                       class="form-control">
                                                @error('time_rate' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                                <p class="light-pink-text mb-0">{{ language('Provide your time rate') }} <u>{{ language('Example: Full Time') }}</u></p>
                                            </div>
                                            
                                        </div>
                                        <div class="form-row pro-pad pt-0">
                                            <div class="form-group col-md-6 pro-pic">
                                                <label>{{ language('Profile Picture') }}</label>
                                                <div class="d-flex align-items-center">
                                                    <div class="upload-images">
                                                        <img
                                                            src="{{ !empty($user->profile_photo) ? asset('storage/profile/'. $user->profile_photo) : asset('storage/no-photo.jpg') }}"
                                                            alt="" id="crop-item-img-output">
                                                        @if(!empty($user->profile_photo))
                                                            <a href="javascript:void(0);" id="notPhoto"
                                                               class="btn btn-icon btn-danger btn-sm"
                                                               title="{{ language('frontend.edit_profile.delete_photo') }}"><i
                                                                    class="far fa-trash-alt"></i></a>
                                                        @endif
                                                    </div>
                                                    <label class="file-upload image-upbtn ms-3">
                                                        {{ language('Change Image') }} <input type="file" class="crop-item-img"
                                                                            name="profile_photo">
                                                    </label>
                                                </div>
                                                <input type="text" name="profile_photo_upload"
                                                       value="{{ old('profile_photo_upload') }}" class="fileUpload">
                                                <input type="text" name="not_photo" class="notPhoto">
                                                <div class="alert alert-danger mt-3  cropImgError"></div>
                                                @error('profile_photo' )
                                                <div class="alert alert-my-danger">{{ $message }}</div>
                                                @enderror
                                                <p>{{ language('Image size 300*300, formats (jpg,jpeg,png)') }}</p>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="gender">{{ language('Gender') }}</label>
                                                <select class="form-control select" name="gender" id="gender">
                                                    <option
                                                        {{ old('gender',$user->gender) == 0 ? 'selected':null }} value="0">{{ language('frontend.common.select') }}</option>
                                                    <option
                                                        {{ old('gender',$user->gender) == 1 ? 'selected':null }} value="1">{{ language('frontend.edit_profile.male') }}</option>
                                                    <option
                                                        {{ old('gender',$user->gender) == 2 ? 'selected':null }} value="2">{{ language('frontend.edit_profile.famale') }}</option>
                                                </select>
                                                @error('gender' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="pro-head">
                                        <h3 class="pro-title without-border mb-0">{{ language('Location') }}</h3>
                                    </div>
                                    <div class="pro-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="country">{{ language('Country') }}</label>
                                                <select class="form-control select" name="country" id="country">
                                                    <option value="">{{ language('frontend.common.select') }}</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            {{ old('country',$user->country) == $country->id ? 'selected':null }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="postalcode">{{ language('Zipcode') }}</label>
                                                <input autocomplete="OFF" id="postalcode" type="text" name="postalcode"
                                                       value="{{ old('postalcode',$user->postalcode) }}"
                                                       class="form-control"/>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="address">{{ language('Address') }}</label>
                                                <input autocomplete="OFF" id="address" type="text" name="address"
                                                       value="{{ old('address',$user->address) }}"
                                                       class="form-control"/>
                                                @error('address' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="pro-head">
                                        <h3 class="pro-title without-border mb-0">{{ language('Overview') }}</h3>
                                    </div>
                                    <div class="pro-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <textarea id="description" name="description" class="form-control"
                                                          rows="5">{!! old('description', $user->description) !!}</textarea>
                                                @error('description' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card text-end">
                                    <div class="pro-body">
                                        {{--                                        <button class="btn btn-secondary click-btn btn-plan">Cancel</button>--}}
                                        <button class="btn btn-primary click-btn btn-plan" type="submit">{{ language('Update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->


    <!--  CROP IMAGE START  -->
    <div class="modal fade" id="cropImagePop" tabindex="-1" aria-labelledby="cropImagePopLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="cropImagePopLabel">{{ language('frontend.edit_profile.profile_photo') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ language('frontend.common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <div id="upload-crop-img" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ language('frontend.common.close') }}</button>
                    <button type="button" id="cropImageBtn"
                            class="btn btn-primary ">{{ language('frontend.common.crop') }}</button>
                </div>

            </div>
        </div>
    </div>
    <!--  CROP IMAGE END  -->


    <!--  CROP IMAGE START  -->
    <div class="modal fade" id="cropImagePopBanner" tabindex="-1" aria-labelledby="cropImagePopLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="cropImagePopLabel">{{ language('frontend.edit_profile.profile_photo') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="{{ language('frontend.common.close') }}"></button>
                </div>
                <div class="modal-body">
                    <div id="upload-crop-imgBanner" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ language('frontend.common.close') }}</button>
                    <button type="button" id="cropImageBtnBanner"
                            class="btn btn-primary ">{{ language('frontend.common.crop') }}</button>
                </div>

            </div>
        </div>
    </div>
    <!--  CROP IMAGE END  -->

@endsection


@section('CSS')
    <!-- CROPPER CSS  -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/cropper/croppie.css') }}">
@endsection

@section('JS')
    <!--  CROPPER JS START -->
    <script src="{{ asset('frontend/assets/plugins/cropper/croppie.js') }}"></script>

    <script>
        /*   CROP IMG START   */
        let $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

        function readFile(input) {
            if (input.files[0].type == "image/jpeg" || input.files[0].type == "image/png") {
                if (input.files && input.files[0]) {
                    $('.cropImgError').hide();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.upload-crop-img').addClass('ready');
                        $('#cropImagePop').modal('show');
                        rawImg = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    // console.log("Sorry - you're browser doesn't support the FileReader API");
                }
            } else {
                $('.cropImgError').fadeIn();
                $('.cropImgError').html('{{ language('frontend.edit_profile.photo_format_error') }}')
            }

        }

        $uploadCrop = $('#upload-crop-img').croppie({
            viewport: {
                width: 272,
                height: 272,
            },
            enforceBoundary: true,
            enableExif: true
        });
        $('#cropImagePop').on('shown.bs.modal', function () {
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function () {
                // console.log('jQuery bind complete');
            });
        });

        $('.crop-item-img').on('change', function () {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });
        $('#cropImageBtn').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {width: 720, height: 720}
            }).then(function (resp) {
                $('#crop-item-img-output').attr('src', resp);
                $('#cropImagePop').modal('hide');
                $('#notPhoto').remove();
                $('.pro-pic .upload-images').prepend(`
                <a href="javascript:void(0);" id="notPhoto" class="btn btn-icon btn-danger btn-sm" title="{{ language('frontend.edit_profile.delete_photo') }}"><i class="far fa-trash-alt"></i></a>
                `);
                $('.notPhoto').val('');
                $('.fileUpload').val(resp);
            });
        });
        // End upload preview image

        $(document).on('click', '#notPhoto', function () {
            $(this).remove();
            $('.notPhoto').val('1');
            $('#crop-item-img-output').attr("src", "{{ asset('storage/no-photo.jpg') }}")
        })


        /*   CROP IMG START   */
        let $uploadCropBanner,
            tempFilenameBanner,
            rawImgBanner,
            imageIdBanner;

        function readFileBanner(input) {
            if (input.files[0].type == "image/jpeg" || input.files[0].type == "image/png") {
                if (input.files && input.files[0]) {
                    $('.cropImgErrorBanner').hide();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.upload-crop-imgBanner').addClass('ready');
                        $('#cropImagePopBanner').modal('show');
                        rawImgBanner = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    // console.log("Sorry - you're browser doesn't support the FileReader API");
                }
            } else {
                $('.cropImgErrorBanner').fadeIn();
                $('.cropImgErrorBanner').html('{{ language('frontend.edit_profile.photo_format_error') }}')
            }

        }

        $uploadCropBanner = $('#upload-crop-imgBanner').croppie({
            viewport: {
                width: 272,
                height: 33,
            },
            enforceBoundary: true,
            enableExif: true
        });
        $('#cropImagePopBanner').on('shown.bs.modal', function () {
            // alert('Shown pop');
            $uploadCropBanner.croppie('bind', {
                url: rawImgBanner
            }).then(function () {
                // console.log('jQuery bind complete');
            });
        });

        $('.crop-item-imgBanner').on('change', function () {
            imageIdBanner = $(this).data('id');
            tempFilenameBanner = $(this).val();
            $('#cancelCropBtnBanner').data('id', imageIdBanner);
            readFileBanner(this);
        });
        $('#cropImageBtnBanner').on('click', function (ev) {
            $uploadCropBanner.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {width: 936, height: 113}
            }).then(function (resp) {
                $('#crop-item-img-outputBanner').attr('src', resp);
                $('#cropImagePopBanner').modal('hide');
                $('#notPhotoBanner').remove();
                $('.pro-pic .upload-imagesBanner').prepend(`
                <a href="javascript:void(0);" id="notPhotoBanner" class="btn btn-icon btn-danger btn-sm" title="{{ language('frontend.edit_profile.delete_photo') }}"><i class="far fa-trash-alt"></i></a>
                `);
                $('.notPhotoBanner').val('');
                $('.fileUploadBanner').val(resp);
            });
        });
        // End upload preview image

        $(document).on('click', '#notPhotoBanner', function () {
            $(this).remove();
            $('.notPhotoBanner').val('1');
            $('#crop-item-img-outputBanner').attr("src", "{{ asset('storage/no-photo.jpg') }}")
        })

        /*   CROP IMG END   */
    </script>
@endsection

