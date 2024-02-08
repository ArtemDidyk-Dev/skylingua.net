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
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="pro-pos">
                        @include('frontend.dashboard.employer._profileNav', ['user' => $user])

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
                                  action="{{ route('frontend.dashboard.employer.profile-settings.store') }}"
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
                                                <label for="hourly_rate">{{ language('Company Owner') }}</label>
                                                <input autocomplete="OFF" id="owner" type="text" name="owner"
                                                       value="{{ old('owner', $user->owner) }}" class="form-control">
                                                @error('owner' )<span
                                                    class="text-danger">{{ $message }}</span> @enderror
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
                                            
                                            
                                        </div>
                                        <div class="form-row pro-pad pt-0">
                                            <div class="form-group col-md-6 pro-pic">
                                                <label>{{ language('Profile Picture') }}</label>
                                                <div class="d-flex align-items-center">
                                                    <div class="upload-images">
                                                        <img
                                                            src="{{ !empty($user->profile_photo) ? asset('storage/profile/'. $user->profile_photo) : asset('storage/no-image.jpg') }}"
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
                                                <label for="time_rate">{{ language('Established') }}</label>
                                                <input autocomplete="OFF" id="established" type="date"
                                                       name="established"
                                                       value="{{ old('established', $user->established) }}"
                                                       class="form-control">
                                                @error('established' )<span
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
                                                <label for="country">Country</label>
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
                                        <h3 class="pro-title without-border mb-0">{{ language('About Us') }}</h3>
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



    <!--  ICONS MODAL START  -->
    <div class="modal fade" id="iconsModalPopovers" tabindex="-1" aria-labelledby="iconsModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iconsModalLabel">{{ language('Sosial Icons') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sociconsModalContainer">

                        <!--  ICON START  -->
                        <span
                            data-dismiss="modal"
                            data-socicon="noicon"
                            class="sociconsItem"
                        >

                              <div class="sociconsItemIcon">
                                   <i class="fas fa-ban"></i>
                              </div>
                              <div class="sociconsItemCaption">{{ language('No Icon') }}</div>
                      </span>
                        <!--  ICON END  -->


                        @foreach(\App\Services\CommonService::socialIcons() as $icon)
                            <!--  ICON START  -->
                            <span
                                data-dismiss="modal"
                                data-socicon="{{ $icon }}"
                                class="sociconsItem"
                            >

                          <div class="sociconsItemIcon">
                               <i class="socicon-{{ $icon }}"></i>
                          </div>
                          <div class="sociconsItemCaption">{{ strtoupper($icon) }}</div>
                      </span>
                            <!--  ICON END  -->
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--  ICONS MODAL END  -->

@endsection


@section('CSS')
    <!-- CROPPER CSS  -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/plugins/cropper/croppie.css') }}">

    <style>
        .removeAllSocialicons {
            display: inline-block;
        }

        .socialIcons {
            background: #f1f1f1;
            width: 100%;
            border: 1px solid #eaeaea;
            border-radius: 4px;
            display: flex;
            align-items: center;
            height: 46px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .socialIcons:hover {
            background: #e8e8e8;
            transition: background-color 0.3s;
        }

        .socialIcons .social-icons-container {
            display: flex;
            width: 100%;
            height: 46px;
            align-items: center;
        }

        .socialIcons .social-icons-container .socialIconsArrow {
            display: flex;
            height: 46px;
            align-items: center;
        }

        .socialIcons .social-icons-container .socialIconName {
            display: flex;
            height: 46px;
            align-items: center;
            font-size: 12px;
            text-transform: uppercase;
        }

        .socialIcons .social-icons-container .socialIconsItem {
            display: flex;
            height: 46px;
            align-items: center;
            position: relative;
        }

        .socialIcons .social-icons-container .socialIconsItem i {
            font-size: 20px;
            position: relative;
            top: 4px;
            padding: 4px 10px;
        }

        .socialIcons .social-icons-container .socialIconsArrow {
            margin-left: auto;
            position: relative;
            right: 10px;
        }

        .socialIcons input {
            display: none;
        }

        .sociconsModalContainer {
            display: grid;
            grid-template-columns: repeat(auto-fill, 115px);
            justify-content: space-evenly;
            grid-gap: 9px;
            align-content: start;
        }

        .sociconsModalContainer .sociconsItem {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: #f7f7f7;
            margin: 5px;
            border-radius: 7px;
            padding: 8px;
            cursor: pointer;
            width: 108px;
            height: 73px;
            transition: all 0.2s;
            font-size: 12px;
        }

        .sociconsModalContainer .sociconsItem:hover {
            background: #e4e4e4;
            box-shadow: 0px 3px 5px 0px #ececec;
            transform: scale(1.03);
            transition: all 0.2s;
        }

        .sociconsModalContainer .sociconsItem .sociconsItemIcon i {
            font-size: 25px;
            color: #909090;
        }
    </style>
@endsection

@section('JS')
    <script>
        $(document).on('click', '.sociconsItem', function () {
            let socIcon = $(this).data('socicon');

            if (socIcon == 'noicon') {

                // Iconsuz tiklandiqda
                $('.activeInput').val('');
                $('.socialIconsActive').find('.socialIconsItem').html(`<i class="fas fa-ban" style="top:0px;"></i>`);
                $('.socialIconsActive').find('.socialIconName').html('Select Icon');

            } else {

                $('.activeInput').val(socIcon);
                $('.socialIconsActive').find('.socialIconsItem').html(`<i class="socicon-${socIcon} text-dark-50"></i>`);
                $('.socialIconsActive').find('.socialIconName').html(socIcon.toUpperCase());

            }

        })

        // Icon SEC TIKLANDIQDA
        $(document).on('click', '.socialIcons', function () {
            $('.socialIcons').each(function () {
                $(this).removeClass('socialIconsActive');
                $(this).find('.socialIconsInput').removeClass('activeInput');
            })
            $(this).addClass('socialIconsActive');
            $(this).find('.socialIconsInput').addClass('activeInput');

        });
        // Class definition
        var KTFormRepeater = function () {

            // Private functions
            var repeatForm = function () {
                $('.repeaterForm').repeater({
                    initEmpty: false,
                    isFirstItemUndeletable: true,

                    // defaultValues: {
                    //     'link': 'default value'
                    // },

                    show: function () {
                        $(this).slideDown();
                    },

                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
            }

            return {
                // public functions
                init: function () {
                    repeatForm();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTFormRepeater.init();
        });

        $(document).on('click', '.repeatBtn', function () {
            const socialIcon = $(".socialIcons");
            socialIcon.last().find('.activeInput').val('');
            socialIcon.last().find('.socialIconsItem').html(`<i class="fas fa-ban" style="top:0px;"></i>`);
            socialIcon.last().find('.socialIconName').html('Select Icon');

        });

        $(document).on('click', '.removeAllSocialicons', function () {
            $('.socialIconsContainer').html('');
        });
    </script>

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
            $('#crop-item-img-output').attr("src", "{{ asset('storage/no-image.jpg') }}")
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
            $('#crop-item-img-outputBanner').attr("src", "{{ asset('storage/company-bg.jpg') }}")
        })

        /*   CROP IMG END   */
    </script>
@endsection

