@extends('admin.layouts.index')
@section('title')
    Edit Profile
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
                            Edit Profile
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
                                <h3 class="card-label">Edit Profile</h3>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.user.profilUpdate') }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <div class="card-body">
                                            @error('refererID' )
                                            <div class="alert alert-my-danger">{{ $message }}</div> @enderror

                                            <div class="mb-15">

                                                <!--  Foto  -->
                                                <div class="form-group row">
                                                    <label for="profile_photo"
                                                           class="col-lg-3 col-form-label">Foto</label>
                                                    <div class="col-lg-9">

                                                        <div class="cabinet center-block">
                                                            @if(!empty(auth()->user()->profile_photo))
                                                                <div tooltip="Foto sil" id="notPhoto">
                                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <figure>
                                                                <img
                                                                    src="{{ old('profile_photo_upload',!empty(auth()->user()->profile_photo) ? asset('storage/profile/'.auth()->user()->profile_photo): asset('storage/no-image.png')) }}"
                                                                    class="gambar img-responsive img-thumbnail"
                                                                    id="crop-item-img-output"/>
                                                            </figure>
                                                            <input type="file" class="crop-item-img  file center-block"
                                                                   name="profile_photo"/>
                                                        </div>
                                                        <input type="text" name="profile_photo_upload"
                                                               value="{{ old('profile_photo_upload') }}"
                                                               class="fileUpload">
                                                        <input type="text" name="not_photo" class="notPhoto">
                                                        <div class="text-muted mt-2">Foto formatı (jpg,jpeg,png)</div>
                                                        <div class="alert alert-danger mt-3  cropImgError"></div>
                                                        @error('profile_photo' )
                                                        <div
                                                            class="alert alert-my-danger">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

                                                <!--  Login  -->
                                                <div class="form-group row">
                                                    <label for="username" class="col-lg-3 col-form-label">İstifadəçi
                                                        adı</label>
                                                    <div class="col-lg-9">
                                                        <input id="username" type="text" name="username"
                                                               value="{{ old('username',$user->username) }}"
                                                               class="form-control form-control-lg"
                                                               placeholder="İstifadəçi adı"/>
                                                        @error('username' )<span
                                                            class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  Name soyad  -->
                                                <div class="form-group row">
                                                    <label for="name" class="col-lg-3 col-form-label">Name soyad</label>
                                                    <div class="col-lg-9">
                                                        <input id="name" type="text" name="name"
                                                               value="{{ old('name',$user->name) }}"
                                                               class="form-control form-control-lg"
                                                               placeholder="Name soyad"/>
                                                        @error('name' )<span
                                                            class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--  E-mail  -->
                                                <div class="form-group row">
                                                    <label for="email" class="col-lg-3 col-form-label">E-mail</label>
                                                    <div class="col-lg-9">
                                                        <input id="email" type="text" name="email"
                                                               value="{{ old('email',$user->email) }}"
                                                               class="form-control form-control-lg"
                                                               placeholder="E-mail"/>
                                                        @error('email' )<span
                                                            class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--Şifrə-->
                                                <div class="form-group row">
                                                    <label for="password" class="col-lg-3 col-form-label">Şifrə</label>
                                                    <div class="col-lg-9">
                                                        <input id="password" type="password" name="password"
                                                               {{ old('password') }} class="form-control form-control-lg"
                                                               placeholder="Şifrə"/>
                                                        @error('password' )<span
                                                            class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <!--Təkrar şifrə-->
                                                <div class="form-group row">
                                                    <label for="password_confirmation" class="col-lg-3 col-form-label">Təkrar
                                                        şifrə</label>
                                                    <div class="col-lg-9">
                                                        <input id="password_confirmation" type="password"
                                                               name="password_confirmation"
                                                               {{ old('password_confirmation') }} class="form-control form-control-lg"
                                                               placeholder="Təkrar şifrə"/>
                                                        @error('password_confirmation' )<span
                                                            class="text-danger">{{ $message }}</span> @enderror
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="save-tools-item">
                                        <div>Create date:</div>
                                        <div>{{ \Illuminate\Support\Carbon::parse($user->created_at)->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div class="save-tools-item">
                                        <div>Update date:</div>
                                        <div>{{ \Illuminate\Support\Carbon::parse($user->updated_at)->format('Y-m-d H:i') }}</div>
                                    </div>
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
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });


    </script>

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
        })
    </script>


@endsection
