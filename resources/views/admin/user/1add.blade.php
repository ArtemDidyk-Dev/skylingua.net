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
                            Add User
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
                                <h3 class="card-label">Add User</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.user.store') }}" enctype="multipart/form-data" method="POST">
                                        @csrf

                                        <div class="card-body">

                                            <div class="mb-15">

                                                <!--  Name  -->
                                                <div class="form-group row form-name">
                                                    <label for="name" class="col-lg-3 col-form-label">Name</label>
                                                    <div class="col-lg-9">
                                                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control form-control-lg"   placeholder="Name"/>
                                                        @error('name' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  E-mail  -->
                                                <div class="form-group row">
                                                    <label for="email" class="col-lg-3 col-form-label">E-mail</label>
                                                    <div class="col-lg-9">
                                                        <input id="email" type="text" name="email" value="{{ old('email') }}" class="form-control form-control-lg"   placeholder="E-mail"/>
                                                        @error('email' )<span class="text-danger">{{ $message }}</span> @enderror
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
                                                        <input id="password_confirmation" type="password" name="password_confirmation" {{ old('password_confirmation') }} class="form-control form-control-lg" placeholder="Confirm Password"/>
                                                        @error('password_confirmation' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <br />
                                                <hr />
                                                <br />
                                                <br />


                                                <!--Roles-->
                                                <div class="form-group row">
                                                    <label for="roles" class="col-lg-3 col-form-label">Roles</label>
                                                    <div class="col-lg-2">
                                                        <select class="form-control" name="roles" id="roles">
                                                            <option value="">-= Select =-</option>
                                                            @foreach($roles as $role)
                                                                <option {{ old('roles') == $role->id ? 'selected':null }} value="{{ $role->id }}">{{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('roles' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>





{{--                                                <!--Parent-->--}}
{{--                                                <div class="form-group row form-parent" style="display:none">--}}
{{--                                                    <label for="parent" class="col-lg-3 col-form-label">Parent</label>--}}
{{--                                                    <div class="col-lg-4">--}}
{{--                                                        <select class="form-control" name="parent" id="parent">--}}
{{--                                                            <option value="">-= Select =-</option>--}}
{{--                                                            @foreach($user_institutions as $user_institution)--}}
{{--                                                                <option {{ old('parent') == $user_institution->id ? 'selected':null }} value="{{ $user_institution->id }}">{{ $user_institution->name }}</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        </select>--}}
{{--                                                        @error('parent' )<span class="text-danger">{{ $message }}</span> @enderror--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                                <!--User Category-->
                                                <div class="form-group row form-user_category" style="display:none">
                                                    <label for="user_category" class="col-lg-3 col-form-label">User Category</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="user_category" id="user_category">
                                                            <option value="">-= Select =-</option>
                                                            @foreach($user_categories as $user_category)
                                                                <option {{ old('user_category') == $user_category->id ? 'selected':null }} value="{{ $user_category->id }}">{{ $user_category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('user_category' )<span class="text-danger">{{ $message }}</span> @enderror
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


                                                <!--  Phone  -->
                                                <div class="form-group row form-phone" style="display:none">
                                                    <label for="phone" class="col-lg-3 col-form-label">Phone</label>
                                                    <div class="col-lg-4">
                                                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="form-control form-control-lg"   placeholder="Phone"/>
                                                        @error('phone' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>


                                                <!--  Address  -->
                                                <div class="form-group row form-address" style="display:none">
                                                    <label for="address" class="col-lg-3 col-form-label">Address</label>
                                                    <div class="col-lg-9">
                                                        <input id="address" type="text" name="address" value="{{ old('address') }}" class="form-control form-control-lg"   placeholder="Address"/>
                                                        @error('address' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Longitude  -->
                                                <div class="form-group row form-longitude" style="display:none">
                                                    <label for="longitude" class="col-lg-3 col-form-label">Longitude</label>
                                                    <div class="col-lg-2">
                                                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude') }}" class="form-control form-control-lg"   placeholder="Longitude"/>
                                                        @error('longitude' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Latitude  -->
                                                <div class="form-group row form-latitude" style="display:none">
                                                    <label for="latitude" class="col-lg-3 col-form-label">Latitude</label>
                                                    <div class="col-lg-2">
                                                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude') }}" class="form-control form-control-lg"   placeholder="Latitude"/>
                                                        @error('latitude' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Postal Code  -->
                                                <div class="form-group row form-postalcode" style="display:none">
                                                    <label for="postalcode" class="col-lg-3 col-form-label">Postal Code</label>
                                                    <div class="col-lg-2">
                                                        <input id="postalcode" type="text" name="postalcode" value="{{ old('postalcode') }}" class="form-control form-control-lg"   placeholder="Postal Code"/>
                                                        @error('postalcode' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

{{--                                                <!--  Date of Birth  -->--}}
{{--                                                <div class="form-group row form-date_of_birth" style="display:none">--}}
{{--                                                    <label for="date_of_birth" class="col-lg-3 col-form-label">Date of Birth</label>--}}
{{--                                                    <div class="col-lg-2">--}}
{{--                                                        <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control form-control-lg"   placeholder="Date of Birth"/>--}}
{{--                                                        @error('date_of_birth' )<span class="text-danger">{{ $message }}</span> @enderror--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                                <!--  Description  -->
                                                <div class="form-group row form-description">
                                                    <label for="description" class="col-lg-3 col-form-label">Description</label>
                                                    <div class="col-lg-9">
                                                        <textarea id="description" name="description" class="form-control form-control-lg" placeholder="Description" rows="5">{{ old('description') }}</textarea>
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
                                    <select class="form-control" name="status" id="status">
                                        <option {{ old('status') == 0 ? 'selected':null }} value="0">Passive</option>
                                        <option {{ old('status') == 1 ? 'selected':null }} value="1">Active</option>
                                    </select>
                                    @error('status' )<span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>


                        <div  class="card-footer myCardFooterPadding">
                            <div class=" d-flex justify-content-end">
                                <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Save
                                </button>
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
                                            @if(old('profile_photo_upload' ) != null)
                                                <div tooltip="Foto sil" id="notPhoto">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </div>
                                            @endif
                                            <figure>
                                                <img
                                                    src="{{ old('profile_photo_upload',asset('storage/no-image.png') ) == null ? asset('storage/no-image.png') : old('profile_photo_upload',asset('storage/no-image.png') ) }}"
                                                    class="gambar img-responsive img-thumbnail"
                                                    id="crop-item-img-output"/>
                                            </figure>
                                            <input form="submit-form" type="file" class="crop-item-img  file center-block"
                                                   name="profile_photo"/>
                                        </div>
                                        <input form="submit-form" type="text" id="profile_photo_upload" name="profile_photo_upload"
                                               value="{{ old('profile_photo_upload') }}"
                                               class="fileUpload">
                                        <input form="submit-form" type="text" name="not_photo" class="notPhoto">
                                        <div class="text-muted mt-2">Foto formatı (jpg,jpeg,png)</div>
                                        <div class="alert alert-danger mt-3  cropImgError"></div>
                                        @error('profile_photo' )
                                        <div
                                            class="alert alert-my-danger">{{ $message }}</div> @enderror

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


    <!--  CROP IMAGE START  -->
    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="upload-crop-img" class="center-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Bağla</button>
                    <button type="button" id="cropImageBtn" class="btn btn-success">Kəs</button>
                </div>
            </div>
        </div>
    </div>
    <!--  CROP IMAGE END  -->

@endsection

@section('CSS')
    <link rel='stylesheet' href='{{ asset('backend/assets/plugins/cropper/croppie.css') }}'>
@endsection

@section('js')

    <script>

        function showInstitution() {
            $('.form-parent').show();
            $('.form-user_category').show();
            $('.form-phone').show();
            $('.form-address').show();
            // $('.form-longitude').show();
            // $('.form-latitude').show();
            $('.form-postalcode').show();
        }
        function showEmployee() {
            $('.form-parent').show();
            $('.form-user_category').show();
            $('.form-gender').show();
            $('.form-phone').show();
            // $('.form-date_of_birth').show();
        }
        function hideAllInputs() {
            $('.form-parent').hide();
            $('.form-user_category').hide();
            $('.form-gender').hide();
            $('.form-phone').hide();
            $('.form-address').hide();
            $('.form-longitude').hide();
            $('.form-latitude').hide();
            $('.form-postalcode').hide();
            // $('.form-date_of_birth').hide();
        }

        @if (old('roles') == 3)
        $('.form-name label').text('Institution Name');
        $('.form-name #name').attr("placeholder", "Institution Name");
        showInstitution();
        @elseif (old('roles') == 4)
        $('.form-name label').text('Employee Name');
        $('.form-name #name').attr("placeholder", "Employee Name");
        showEmployee();
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
                success: function(json) {
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
                $('.form-name label').text('Institution Name');
                $('.form-name #name').attr("placeholder", "Institution Name");
                showInstitution();
            } else if (role_id == 4) {
                $('.form-name label').text('Employee Name');
                $('.form-name #name').attr("placeholder", "Employee Name");
                showEmployee();
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
    </script>


@endsection
