@extends('admin.layouts.index')
@section('title')
    Add User
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
                            <a href="{{ route('admin.user.index') }}" class="text-muted">Users</a>
                        </li>

                        <li class="breadcrumb-item">
                            Edit User
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
                                <h3 class="card-label">Edit User</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="mb-15">

                                                <!--  Name  -->
                                                <div class="form-group row form-name">
                                                    <label for="name" class="col-lg-3 col-form-label">Name</label>
                                                    <div class="col-lg-9">
                                                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control form-control-lg" placeholder="Name"/>
                                                        @error('name' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  E-mail  -->
                                                <div class="form-group row">
                                                    <label for="email" class="col-lg-3 col-form-label">E-mail</label>
                                                    <div class="col-lg-9">
                                                        <input id="email" type="text" name="email" value="{{ old('email') }}" class="form-control form-control-lg" placeholder="E-mail"/>
                                                        @error('email' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Phone  -->
                                                <div class="form-group row form-phone">
                                                    <label for="phone" class="col-lg-3 col-form-label">Phone</label>
                                                    <div class="col-lg-4">
                                                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="form-control form-control-lg" placeholder="Phone"/>
                                                        @error('phone' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--Şifrə-->
                                                <div class="form-group row">
                                                    <label for="password" class="col-lg-3 col-form-label">Password</label>
                                                    <div class="col-lg-9">
                                                        <input id="password" type="password" name="password" {{ old('password') }} class="form-control form-control-lg" placeholder="Password"/>
                                                        @error('password' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--Təkrar şifrə-->
                                                <div class="form-group row">
                                                    <label for="password_confirmation" class="col-lg-3 col-form-label">Confirm Password</label>
                                                    <div class="col-lg-9">
                                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                                               {{ old('password_confirmation') }} class="form-control form-control-lg" placeholder="Confirm Password"/>
                                                        @error('password_confirmation' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <br/>
                                                <hr/>
                                                <br/>
                                                <br/>


                                                <!--Icaze-->
                                                <div class="form-group row">
                                                    <label for="roles" class="col-lg-3 col-form-label">Roles</label>
                                                    <div class="col-lg-2">
                                                        <select class="form-control" name="roles" id="roles">
                                                            @foreach($roles as $role)
                                                                <option {{ old('roles') == $role->id ? 'selected':null }} value="{{ $role->id }}">{{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('roles' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Company Owner  -->
                                                <div class="form-group row form-owner" style="display:none">
                                                    <label for="owner" class="col-lg-3 col-form-label">Company Owner</label>
                                                    <div class="col-lg-4">
                                                        <input id="owner" type="tel" name="owner" value="{{ old('owner') }}" class="form-control form-control-lg"
                                                               placeholder="Company Owner"/>
                                                        @error('owner' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--User Category-->
                                                <div class="form-group row form-user_category" style="display:none">
                                                    <label for="user_category" class="col-lg-3 col-form-label">User Category</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="user_category" id="user_category">
                                                            <option value="">-= Select =-</option>
                                                            @foreach($user_categories as $user_category)
                                                                <option
                                                                    {{ old('user_category') == $user_category->id ? 'selected':null }} value="{{ $user_category->id }}">{{ $user_category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('user_category' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Company Established  -->
                                                <div class="form-group row form-established" style="display:none">
                                                    <label for="established" class="col-lg-3 col-form-label">Company Established</label>
                                                    <div class="col-lg-4">
                                                        <input id="established" type="date" name="established" value="{{ old('established') }}" class="form-control form-control-lg"
                                                               placeholder="Company Established"/>
                                                        @error('established' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--Gender-->
                                                <div class="form-group row form-gender" style="display:none">
                                                    <label for="gender" class="col-lg-3 col-form-label">Gender</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="gender" id="gender">
                                                            <option {{ old('gender') == 0 ? 'selected':null }} value="0">-= Select =-</option>
                                                            <option {{ old('gender') == 1 ? 'selected':null }} value="1">Male</option>
                                                            <option {{ old('gender') == 2 ? 'selected':null }} value="2">Female</option>
                                                        </select>
                                                        @error('gender' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Hourly Rate  -->
                                                <div class="form-group row form-hourly_rate" style="display:none">
                                                    <label for="hourly_rate" class="col-lg-3 col-form-label">Hourly Rate</label>
                                                    <div class="col-lg-4">
                                                        <input id="hourly_rate"  type="number" min="0" step="0.01" name="hourly_rate" value="{{ old('hourly_rate') }}" class="form-control form-control-lg"
                                                               placeholder="Hourly Rate"/>
                                                        <p class="light-pink-text mb-0">Provide your hourly rate without currency symbol</p>
                                                        @error('hourly_rate' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Time Rate  -->
                                                <div class="form-group row form-time_rate" style="display:none">
                                                    <label for="time_rate" class="col-lg-3 col-form-label">Time Rate</label>
                                                    <div class="col-lg-4">
                                                        <input id="time_rate" type="text" name="time_rate" value="{{ old('time_rate') }}" class="form-control form-control-lg" placeholder="Time Rate"/>
                                                        <p class="light-pink-text mb-0">Provide your hourly rate without currency symbol</p>
                                                        @error('time_rate' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--Country-->
                                                <div class="form-group row form-country" style="display:none">
                                                    <label for="country" class="col-lg-3 col-form-label">Country</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="country" id="country">
                                                            <option value="">-= Select =-</option>
                                                            @foreach($countries as $country)
                                                                <option {{ old('country') == $country->id ? 'selected':null }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Address  -->
                                                <div class="form-group row form-address" style="display:none">
                                                    <label for="address" class="col-lg-3 col-form-label">Address</label>
                                                    <div class="col-lg-9">
                                                        <input id="address" type="text" name="address" value="{{ old('address') }}" class="form-control form-control-lg"
                                                               placeholder="Address"/>
                                                        @error('address' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Longitude  -->
                                                <div class="form-group row form-longitude" style="display:none">
                                                    <label for="longitude" class="col-lg-3 col-form-label">Longitude</label>
                                                    <div class="col-lg-2">
                                                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude') }}" class="form-control form-control-lg"
                                                               placeholder="Longitude"/>
                                                        @error('longitude' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Latitude  -->
                                                <div class="form-group row form-latitude" style="display:none">
                                                    <label for="latitude" class="col-lg-3 col-form-label">Latitude</label>
                                                    <div class="col-lg-2">
                                                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude') }}" class="form-control form-control-lg"
                                                               placeholder="Latitude"/>
                                                        @error('latitude' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Postal Code  -->
                                                <div class="form-group row form-postalcode" style="display:none">
                                                    <label for="postalcode" class="col-lg-3 col-form-label">Postal Code</label>
                                                    <div class="col-lg-2">
                                                        <input id="postalcode" type="text" name="postalcode" value="{{ old('postalcode') }}" class="form-control form-control-lg"
                                                               placeholder="Postal Code"/>
                                                        @error('postalcode' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Description  -->
                                                <div class="form-group row form-description">
                                                    <label for="description" class="col-lg-3 col-form-label">Description</label>
                                                    <div class="col-lg-9">
                                                        <textarea id="description" name="description" class="form-control form-control-lg" placeholder="Description"
                                                                  rows="5">{{ old('description') }}</textarea>
                                                        @error('description' )<span class="text-danger">{{ $message }}</span> @enderror
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
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Note</h3>
                            </div>

                        </div>

                        <div class="card-body">


                            <!--Status-->
                            <div class="form-group row">
                                <label for="status" class="col-lg-3 col-form-label">Status</label>
                                <div class="col-lg-9">
                                    <select form="submit-form" class="form-control" name="status" id="status">
                                        <option {{ old('status') == 0 ? 'selected':null }} value="0">Passive</option>
                                        <option {{ old('status') == 1 ? 'selected':null }} value="1">Active</option>
                                        <option {{ old('status') == 2 ? 'selected':null }} value="2">Deleted</option>
                                    </select>
                                    @error('status' )<span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="card-body">
                                <!--  Approve  -->
                                <div class="form-group row">
                                    <label for="approve" class="col-lg-3 col-form-label">Approve</label>
                                    <div class="col-lg-9">
                                        <select form="submit-form" class="form-control" name="approve">
                                            <option {{ old('approve') == 0 ? 'selected' : '' }} value="0">No</option>
                                            <option {{ old('approve') == 1 ? 'selected' : '' }} value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer myCardFooterPadding">
                            <div class=" d-flex justify-content-end">
                                <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Save</button>
                            </div>
                        </div>

                    </div>

                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Profile Photo</h3>
                            </div>
                        </div>

                        <div style="padding-top: 2px; padding-bottom: 2px;" class="card-body">

                            <!--  IMAGES CONTAINER START  -->
                            <div class="row">
                                <div class="col-md-12 ">

                                    <div class="crop-photo-container">

                                        <div class="cabinet center-block">
                                            @if(old('profile_photo_upload')))
                                                <div tooltip="Delete Photo" id="notPhoto">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </div>
                                            @endif
                                            <figure>
                                                <img
                                                    src="{{ old('profile_photo_upload') ? asset('storage/profile/'. old('profile_photo_upload')) : asset('storage/no-image.png') }}"
                                                    class="gambar img-responsive img-thumbnail" id="crop-item-img-output"/>
                                            </figure>
                                            <input form="submit-form" type="file" class="crop-item-img  file center-block" name="profile_photo"/>
                                        </div>
                                        <input form="submit-form" type="text" id="profile_photo_upload" name="profile_photo_upload"
                                               value="{{ old('profile_photo_upload') }}"
                                               class="fileUpload">
                                        <input form="submit-form" type="text" name="not_photo" class="notPhoto">
                                        <div class="text-muted mt-2">Image formats (jpg,jpeg,png)</div>
                                        <div class="alert alert-danger mt-3  cropImgError"></div>
                                        @error('profile_photo' )
                                        <div class="alert alert-my-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                            </div>
                            <!--  IMAGES CONTAINER END  -->
                        </div>
                    </div>

                    <div class="card card-custom gutter-b card_profile_banner">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Profile Banner</h3>
                            </div>
                        </div>

                        <div style="padding-top: 2px; padding-bottom: 2px;" class="card-body">
                            <!--  BANNER CONTAINER START  -->
                            <div class="row">
                                <div class="col-md-12 ">

                                    <div class="crop-photo-container" style="height: 100px;">

                                        <div class="cabinet center-block" style="height: 100px;">
                                            @if(old('banner_image'))
                                                <div tooltip="Delete Banner" id="notPhotoBanner">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </div>
                                            @endif
                                            <figure>
                                                <img src="{{ old('banner_image') ? asset('storage/profile/'. old('banner_image')) : asset('storage/company-bg.jpg') }}" class="gambar img-responsive img-thumbnail" id="crop-item-img-outputBanner" style="height: 100px"/>
                                            </figure>
                                            <input form="submit-form" type="file" class="crop-item-imgBanner file center-block" name="banner_image"/>
                                        </div>
                                        <input form="submit-form" type="text" id="banner_image_upload" name="banner_image_upload" value="{{ old('banner_image_upload') }}" class="fileUploadBanner">
                                        <input form="submit-form" type="text" name="not_photoBanner" class="notPhotoBanner">
                                        <div class="text-muted mt-2">Image formats (jpg,jpeg,png)</div>
                                        <div class="alert alert-danger mt-3  cropImgError"></div>
                                        @error('banner_image' )
                                        <div class="alert alert-my-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                            </div>
                            <!--  BANNER CONTAINER END  -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->


    <!--  CROP IMAGE START  -->
    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="upload-crop-img" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="cropImageBtn" class="btn btn-success">Crop</button>
                </div>
            </div>
        </div>
    </div>
    <!--  CROP IMAGE END  -->


    <!--  CROP BANNER START  -->
    <div class="modal fade" id="cropImagePopBanner" tabindex="-1" aria-labelledby="cropImagePopLabel"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropImagePopLabel">Profile Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="upload-crop-imgBanner" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="cropImageBtnBanner" class="btn btn-success">Crop</button>
                </div>

            </div>
        </div>
    </div>
    <!--  CROP BANNER END  -->

@endsection

@section('CSS')
    <link rel='stylesheet' href='{{ asset('backend/assets/plugins/cropper/croppie.css') }}'>
@endsection

@section('js')

    <script>
        function showEmployer() {
            $('.form-owner').show();
            $('.form-user_category').show();
            $('.form-established').show();
            $('.form-country').show();
            $('.form-address').show();
            // $('.form-longitude').show();
            // $('.form-latitude').show();
            $('.form-postalcode').show();
        }

        function showFreelancer() {
            $('.form-parent').show();
            $('.form-user_category').show();
            $('.form-gender').show();
            $('.form-hourly_rate').show();
            $('.form-time_rate').show();
            $('.form-country').show();
            $('.form-address').show();
            $('.form-postalcode').show();
        }

        function hideAllInputs() {
            $('.form-owner').hide();
            $('.form-user_category').hide();
            $('.form-established').hide();
            $('.form-country').hide();
            $('.form-gender').hide();
            $('.form-hourly_rate').hide();
            $('.form-time_rate').hide();
            $('.form-phone').hide();
            $('.form-address').hide();
            $('.form-longitude').hide();
            $('.form-latitude').hide();
            $('.form-postalcode').hide();
        }

        @if (old('roles') == 3)
        $('.form-name label').text('Dispaly Name');
        $('.form-name #name').attr("placeholder", "Dispaly Name");
        showEmployer();
        @elseif (old('roles') == 4)
        $('.form-name label').text('Freelancer Name');
        $('.form-name #name').attr("placeholder", "Freelancer Name");
        showFreelancer();
        @endif
    </script>


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
        $('#roles').on('change', function () {
            var role_id = encodeURIComponent(this.value);

            $.ajax({
                url: '{{ route('admin.user.getUserCategoriesAjax') }}',
                type: 'POST',
                data: {role_id: role_id},
                dataType: 'json',
                success: function (json) {
                    if (json.success == true) {

                        $('#user_category option').remove();
                        $('#user_category').append('<option value="">-= Select =-</option>');
                        $.each(json.data, function (inx, item) {
                            $('#user_category').append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                    } // if
                }
            });

            hideAllInputs();

            if (role_id == 3) {
                $('.form-name label').text('Dispaly Name');
                $('.form-name #name').attr("placeholder", "Dispaly Name");
                showEmployer();
            } else if (role_id == 4) {
                $('.form-name label').text('Freelancer Name');
                $('.form-name #name').attr("placeholder", "Freelancer Name");
                showFreelancer();
            } else {
                $('.form-name label').text('Name');
                $('.form-name #name').attr("placeholder", "Name");
            }
        });
    </script>


    <!--  BUTTON IMAGE ALONE START  -->
    <script>

        $(document).on('click', '.activeButtonAlone', function () {
            $(this).addClass('activeButtonCheck');

            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight


            /*   BUTTON FUNCTION START   */
            ckfinderAloneButton(x, y, 'Images');

        })

    </script>
    <!--  BUTTON IMAGE ALONE END  -->



    <!--  CRPPER IMAGE JS  -->
    <script src={{ asset('backend/assets/plugins/cropper/croppie.js') }}></script>
    <script>

        var $uploadCrop,
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
                $('.cropImgError').html('Foto formatı yalnız (jpg,jpeg və png) olmalıdır')
            }

        }

        $uploadCrop = $('#upload-crop-img').croppie({
            viewport: {
                width: 200,
                height: 200,
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
                $('.cabinet').prepend(`
                <div tooltip="Foto sil" id="notPhoto">
                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                 </div>
                `);
                $('.notPhoto').val('');
                $('.fileUpload').val(resp);
            });
        });
        // End upload preview image

        $(document).on('click', '#notPhoto', function () {
            $(this).remove();
            $('.notPhoto').val('1');
            $('.cabinet img').attr("src", "{{ asset('storage/no-image.png') }}")
            $('#profile_photo_upload').val('');
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
            $('#profile_banner_upload').val('');
        })

        /*   CROP IMG END   */
    </script>

@endsection
