@extends('admin.layouts.index')
@section('title')
    Settings
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
                        <li class="breadcrumb-item">Settings</li>
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
                                        <a class="nav-link active" data-toggle="tab" href="#tab-site-settings">
														<span class="nav-icon">
                                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Settings-2.svg--><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path
            d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
            fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                                                        </span>
                                            <span class="nav-text font-size-lg">Settings</span>
                                        </a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#tab-site-logo">
														<span class="nav-icon">
                                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Image.svg--><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path
            d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z"
            fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                                                        </span>
                                            <span class="nav-text font-size-lg">Logo</span>
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
                            @if ($errors->any())
                                <div class="alert my-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="form" id="submit-form" action="{{ route('admin.setting.update') }}"
                                  method="POST"
                                  enctype="multipart/form-data"
                            >
                                @csrf

                                <div class="tab-content">
                                    <!--begin::Tab-->
                                    <div class="tab-pane show active px-7" id="tab-site-settings" role="tabpanel">


                                        <!--  COPYRIGHT START  -->
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="card-toolbar">
                                                    <ul class="nav nav-tabs nav-bold nav-tabs-line">

                                                        @foreach(cache('key-all-languages') as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ $key == 0 ? 'active': null }}"
                                                                   data-toggle="tab"
                                                                   href="#language-copyright-{{ $language->id }}-tab">
                                                <span class="nav-icon">
                                                     <img src="{{ countryFlag($language->code) }}"/>
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
                                                            class="tab-pane fade show {{ $key == 0 ? 'active': null }}"
                                                            id="language-copyright-{{ $language->id }}-tab"
                                                            role="tabpanel"
                                                            aria-labelledby="language-copyright-{{ $language->id }}-tab">


                                                            <!--  COPYRIGHT BY START  -->
                                                            <div class="form-group">
                                                                <span class="span-dvidder">Copyright</span>
                                                                <textarea
                                                                    name="copyright[{{ $language->id }}]"
                                                                    class="tinymceEditor">{!! \App\Services\SettingService::getSetting('copyright',$language->id) !!}</textarea>
                                                            </div>
                                                            <!--  COPYRIGHT BY END  -->


                                                            <div class="hr-dvidder"></div>

                                                            <!--  CREATED BY START  -->
                                                            <div class="form-group">
                                                                <span class="span-dvidder">Created By</span>
                                                                <textarea
                                                                    name="created_by[{{ $language->id }}]"
                                                                    class="tinymceEditor">{!! \App\Services\SettingService::getSetting('created_by',$language->id) !!}</textarea>
                                                            </div>
                                                            <!--  CREATED BY END  -->


                                                            <!--  WORK TIME START  -->
                                                            <div class="form-group">
                                                                <span class="span-dvidder">Working hours</span>
                                                                <textarea
                                                                    name="work_time[{{ $language->id }}]"
                                                                    class="tinymceEditor">{!! \App\Services\SettingService::getSetting('work_time',$language->id) !!}</textarea>
                                                            </div>
                                                            <!--  WORK TIME END  -->


                                                            <!--  ADDRESS START  -->
                                                            <div class="form-group">
                                                                <span class="span-dvidder">Address</span>
                                                                <input type="text" class="form-control"
                                                                       value="{{ \App\Services\SettingService::getSetting('address',$language->id) }}"
                                                                       name="address[{{ $language->id }}]"
                                                                       placeholder="Ünvan ({{ $language->code }})">
                                                            </div>
                                                            <!--  ADDRESS END  -->

                                                        </div>

                                                    @endforeach


                                                </div>


                                            </div>

                                        </div>
                                        <!--  COPYRIGHT END  -->


                                        <div class="hr-dvidder"></div>

                                        <!--  TEL START  -->
                                        <span class="span-dvidder">Phones</span>
                                        <div class="removeAllTel  mb-5 mt-5">
                                            <div class="btn btn-sm font-weight-bolder btn-light-danger">Delete All Phones
                                            </div>
                                        </div>
                                        <div class="repeaterForm">
                                            <div class=" row">
                                                <div id="sortable" data-repeater-list="tel" class="col-lg-12 telContainer">
                                                    @if(empty(setting('tel')))
                                                        <div data-repeater-item=""
                                                             class="form-group row">
                                                            <div class="col-md-10">
                                                                <input
                                                                    class="form-control "
                                                                    type="text"
                                                                    name="tel"
                                                                    placeholder="Phone"/>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <a href="javascript:;" data-repeater-delete=""
                                                                   class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                    <i class="la la-trash-o"></i>Delete</a>
                                                            </div>
                                                        </div>
                                                    @else

                                                        @foreach(json_decode(\App\Services\SettingService::getSetting('tel'),true) as $value)
                                                            <div data-repeater-item=""
                                                                 class="form-group row">
                                                                <div class="col-md-10 tel-box-item">
                                                                    <div class="telSortablehandle">
                                                                        <i class="fas fa-arrows-alt"></i>
                                                                    </div>
                                                                    <input
                                                                        class="form-control "
                                                                        type="text"
                                                                        name="tel"
                                                                        value="{{ isset($value['tel']) ? $value['tel']:null }}"
                                                                        placeholder="Phone"/>
                                                                </div>

                                                                <div class="col-md-2 checkDeleteButtonTel">
                                                                    <a href="javascript:;" data-repeater-delete=""
                                                                       class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                        <i class="la la-trash-o"></i>Delete</a>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    @endif

                                                </div>
                                            </div>
                                            <div class=" row">
                                                <div class="col-lg-12 ">
                                                    <a href="javascript:;" data-repeater-create=""
                                                       class="btn btn-sm font-weight-bolder btn-light-success">
                                                        <i class="la la-plus"></i>Add Phone</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  TEL END  -->

                                        <div class="hr-dvidder"></div>

                                        <!--  SOCIAL START  -->
                                        <span class="span-dvidder">Social</span>
                                        <div class="removeAllSocialicons  mb-5 mt-5">
                                            <div class="btn btn-sm font-weight-bolder btn-light-danger">Delete All Icons
                                            </div>
                                        </div>
                                        <div class="repeaterForm">
                                            <div class=" row">
                                                <div   data-repeater-list="social" class="col-lg-12 sortableElements socialIconsContainer">

                                                    @if(empty(setting('social')))

                                                        <div data-repeater-item=""
                                                             class="form-group row">
                                                            <div class="col-md-3">
                                                                <label class="socialIcons">
                                                                    <input class="socialIconsInput" data-check="0"
                                                                           type="text"
                                                                           name="name">
                                                                    <div data-toggle="modal"
                                                                         data-target="#exampleModalPopovers"
                                                                         class="social-icons-container">
                                                                        <span class="socialIconsItem">
                                                                            <i></i>
                                                                        </span>
                                                                        <span
                                                                            class="socialIconName">Select Icon</span>
                                                                        <div class="socialIconsArrow">
                                                                            <i class="fas fa-chevron-down"></i>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" name="link"
                                                                       value="{{ isset($value['link']) ? $value['link']:null }}"
                                                                       placeholder="Link"/>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="checkbox-inline">
                                                                    <label class="checkbox checkbox-success">
                                                                        <input type="checkbox" name="status"
                                                                            {{ isset($value['status']) ? 'checked="checked"':null }}/>
                                                                        <span></span>Target Blank</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-3 text-right">
                                                                <a href="javascript:;" data-repeater-delete=""
                                                                   class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                    <i class="la la-trash-o"></i>Delete</a>
                                                            </div>
                                                        </div>

                                                    @else

                                                        @foreach(json_decode(setting('social'),true) as $key => $value)

                                                            <div data-repeater-item=""
                                                                 class="form-group row">
                                                                <div class="col-md-3">
                                                                    <label class="socialIcons">
                                                                        <input class="socialIconsInput" data-check="0"
                                                                               type="text"
                                                                               value="{{ isset($value['name']) ? $value['name']:null }}"
                                                                               name="name">
                                                                        <div data-toggle="modal"
                                                                             data-target="#exampleModalPopovers"
                                                                             class="social-icons-container">
                                                                            <span
                                                                                class="socialIconsItem">
                                                                                <i class="socicon-{{ isset($value['name']) ? $value['name']:null }} text-dark-50"></i>
                                                                            </span>
                                                                            <span
                                                                                class="socialIconName">{{ isset($value['name']) ? $value['name']:'Select Icon' }}</span>
                                                                            <div class="socialIconsArrow">
                                                                                <i class="fas fa-chevron-down"></i>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="d-md-none mb-2"></div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text" class="form-control" name="link"
                                                                           value="{{ isset($value['link']) ? $value['link']:null }}"
                                                                           placeholder="Link"/>
                                                                    <div class="d-md-none mb-2"></div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="checkbox-inline">
                                                                        <label class="checkbox checkbox-success">
                                                                            <input type="checkbox" name="status"
                                                                                {{ isset($value['status']) ? 'checked="checked"':null }}/>
                                                                            <span></span>Target blank</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 checkDeleteButton">
                                                                    <a href="javascript:;" data-repeater-delete=""
                                                                       class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                        <i class="la la-trash-o"></i>Delete</a>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    @endif

                                                </div>
                                            </div>
                                            <div class=" row">
                                                <div class="repeatBtn">
                                                    <a href="javascript:;" data-repeater-create=""
                                                       class="btn btn-sm font-weight-bolder btn-light-success">
                                                        <i class="la la-plus"></i>Add Sosial</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  SOCIAL END  -->


                                        <div class="hr-dvidder"></div>

                                        <!--  E-mail START  -->
                                        <span class="span-dvidder">E-mail</span>
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="email"
                                                value="{{ \App\Services\SettingService::getSetting('email') }}"
                                                placeholder="E-mail">
                                        </div>
                                        <!--  TEL END  -->


                                        <!--  MAP START  -->
                                        <div class="form-group">
                                            <span class="span-dvidder">Map</span>
                                            <textarea
                                                name="map" class="form-control"
                                                rows="6">{{ \App\Services\SettingService::getSetting('map') }}</textarea>
                                        </div>
                                        <!--  MAP END  -->

                                    </div>
                                    <!--end::Tab-->
                                    <!--begin::Tab-->
                                    <div class="tab-pane px-7" id="tab-site-logo" role="tabpanel">

                                        <!-- Logo  -->
                                        <div class="mb-2 row">
                                            <label for="logo"
                                                   class="col-md-3 text-end control-label col-form-label"></label>
                                            <div class="col-md-3">
                                                <div class="logoSite">
                                                    @if(empty(setting('logo')))
                                                        <img src="{{ asset('storage/no-image.png') }}">
                                                    @else
                                                        <img src="{{ asset('storage') }}/{{ setting('logo') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="logo" class="col-md-3 text-end control-label col-form-label">Logo</label>
                                            <div class="col-md-9">
                                                <input class="form-control" name="logo" type="file" id="logo">
                                                @error('logo')<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>


                                        <!-- Logo Dark -->
                                        <div class="mb-2 row">
                                            <label for="logo_dark"
                                                   class="col-md-3 text-end control-label col-form-label"></label>
                                            <div class="col-md-3">
                                                <div class="logoSite">
                                                    @if(empty(setting('logo_dark')))
                                                        <img src="{{ asset('storage/no-image.png') }}">
                                                    @else
                                                        <img src="{{ asset('storage') }}/{{ setting('logo_dark') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="logo_dark"
                                                   class="col-md-3 text-end control-label col-form-label">Logo Dark</label>
                                            <div class="col-md-9">
                                                <input class="form-control" name="logo_dark" type="file" id="logo_dark">
                                                @error('logo_dark')<span
                                                    class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>


                                        <!-- Favicon  -->
                                        <div style="margin-top: 40px" class="mb-2 row">
                                            <label for="logo"
                                                   class="col-md-3 text-end control-label col-form-label"></label>
                                            <div class="col-md-3">
                                                <div class="faviconSite">
                                                    @if(empty(setting('favicon')))
                                                        <img src="{{ asset('storage/no-image.png') }}">
                                                    @else
                                                        <img src="{{ asset('storage') }}/{{ setting('favicon') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="favicon" class="col-md-3 text-end control-label col-form-label">Favicon</label>
                                            <div class="col-md-9">
                                                <input class="form-control" name="favicon" type="file" id="favicon">
                                                @error('favicon')<span
                                                    class="text-danger">{{ $message }}</span> @enderror
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

                        {{--                        <div class="card-body">--}}
                        {{--                            <!--  CODE  -->--}}
                        {{--                        </div>--}}

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

    <!--  ICONS MODAL START  -->
    <div class="modal fade" id="exampleModalPopovers" tabindex="-1" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sosial Icons</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="sociconsModalBar ">
                        <input type="text" class="form-control mb-4" autocomplete="OFF" id="searchSocialIcons"
                               placeholder="Search...">
                    </div>
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
                              <div class="sociconsItemCaption">No Icon</div>
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

    <style>
        .language-label-message, .alert-my-danger {
            display: none;
        }

        .tel-box-item {
            position: relative;
        }

        .telSortablehandle {
            position: absolute;
            width: 33px;
            height: 38px;
            background: #eaeaea;
            border-radius: 4px 0px 0px 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: move;
        }

        .tel-box-item input {
            padding: 0 0 0 40px;
        }


        .telSortablehandle .fas {
            color: #7e849c;
        }

        .span-dvidder {
            display: block;
        }
        .removeAllSocialicons,
        .removeAllTel
        {
            display: inline-block;
        }

        .repeatBtn {
            padding-right: 12.5px;
            padding-left: 12.5px;
        }
    </style>

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


    <!--  REPEAT JS START  -->
    <script>
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
    </script>
    <!--  REPEAT JS END  -->

    <!--  REPEAT BTN START  -->
    <script>
        $(document).on('click', '.repeatBtn', function () {
            const socialIcon = $(".socialIcons");
            socialIcon.last().find('.activeInput').val('');
            socialIcon.last().find('.socialIconsItem').html(`<i ></i>`);
            socialIcon.last().find('.socialIconName').html('Icon Seç');

        })
    </script>
    <!--  REPEAT BTN END  -->

    <!--  REMOVE ALL TEll START  -->
    <script>
        $(document).on('click', '.removeAllTel', function () {
            $('.telContainer').html(`
            <div data-repeater-item=""
                     class="form-group row">
                    <div class="col-md-10 tel-box-item">
                       <div class="telSortablehandle">
                    <i class="fas fa-arrows-alt"></i>
                    </div>
                        <input
                            class="form-control "
                            type="text"
                            name="tel[0][tel]"
                            placeholder="Tel"/>
                    </div>
                       <div class="col-md-2 checkDeleteButtonTel"></div>
                </div>
            `);
        })
    </script>
    <!--  REMOVE ALL TEll END  -->

    <!--  SOCIAL ICONS START  -->
    <script>
        $(document).on('click', '.sociconsItem', function () {
            let socIcon = $(this).data('socicon');

            if (socIcon == 'noicon') {

                // Iconsuz tiklandiqda
                $('.activeInput').val('');
                $('.socialIconsActive').find('.socialIconsItem').html(`<i ></i>`);
                $('.socialIconsActive').find('.socialIconName').html('Icon Seç');

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

        })

        $(document).on('click', '.removeAllSocialicons', function () {
            $('.socialIconsContainer').html('');
            $('.socialIconsContainer').html(`
            <div data-repeater-item="" class="form-group row ui-sortable-handle" style="">
        <div class="col-md-3">
            <label class="socialIcons">
                <input class="socialIconsInput" data-check="0" type="text" name="social[0][name]">
                <div data-toggle="modal" data-target="#exampleModalPopovers" class="social-icons-container">
        <span class="socialIconsItem">
            <i></i>
        </span>
                    <span class="socialIconName">Icon Seç</span>
                    <div class="socialIconsArrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </label>
            <div class="d-md-none mb-2"></div>
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="social[0][link]" value="" placeholder="Link">
            <div class="d-md-none mb-2"></div>
        </div>
        <div class="col-md-2">
            <div class="checkbox-inline">
                <label class="checkbox checkbox-success">
                    <input type="checkbox" name="social[0][status][]">
                    <span></span>Yeni səhifə</label>
            </div>
        </div>
        <div class="col-md-2 checkDeleteButton"></div>
    </div>

            `);
        })

        /*   SOCIAL ICONS SEARCH START   */
        $(document).on('keyup','#searchSocialIcons',function (){
           let socialIconSearchText = $(this).val();
            clearTimeout(searchIconVar);
            socialIconsSearch(socialIconSearchText);
        })


        var searchIconVar;

        function socialIconsSearch(inputVal) {
            searchIconVar = setTimeout(function () {

                $.ajax({
                    url: "{{ route('admin.setting.searchIcons') }}",
                    type: 'POST',
                    data: {text: inputVal},
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.success == true) {
                            var socialIconArr = response.data;
                            $('.sociconsModalContainer').html('');

                            if(response.isExists == 0){

                                $('.sociconsModalContainer').append(`
                                    <span
                                                data-dismiss="modal"
                                                data-socicon="noicon"
                                                class="sociconsItem"
                                            >

                                          <div class="sociconsItemIcon">
                                               <i class="fas fa-ban"></i>
                                          </div>
                                          <div class="sociconsItemCaption">İkonsuz</div>
                                  </span>
                                `);

                                socialIconArr.forEach(function (value){

                                    $('.sociconsModalContainer').append(`
                                                                      <span
                                                data-dismiss="modal"
                                                data-socicon="${value}"
                                                class="sociconsItem"
                                            >

                                          <div class="sociconsItemIcon">
                                               <i class="socicon-${value}"></i>
                                          </div>
                                          <div class="sociconsItemCaption">${value.toUpperCase()}</div>
                                      </span>
                                    `);
                                })


                            }else {
                                socialIconArr.forEach(function (value){

                                    $('.sociconsModalContainer').append(`
                                                                      <span
                                                data-dismiss="modal"
                                                data-socicon="${value}"
                                                class="sociconsItem"
                                            >

                                          <div class="sociconsItemIcon">
                                               <i class="socicon-${value}"></i>
                                          </div>
                                          <div class="sociconsItemCaption">${value.toUpperCase()}</div>
                                      </span>
                                    `);
                                })
                            }

                        } else {
                            toastr.error("An error occurred");
                        }
                    }
                });

            }, 500);

        }

        /*   SOCIAL ICONS SEARCH END   */

    </script>
    <!--  SOCIAL ICONS END  -->

    <script>
        /*   Sortable SOCIAL START   */
        $(".sortableElements").sortable({
            stop:function (){
                let uiSortablehandle = $('.socialIconsContainer').find('.ui-sortable-handle');
                uiSortablehandle.each(function (index){
                   if(index == 0){
                       $(this).find('.checkDeleteButton').html('');
                   }else {
                       $(this).find('.checkDeleteButton').html(`
                     <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                    <i class="la la-trash-o"></i>Delete</a>
                       `);
                   }
                });

            }
        });
        $(".sortableElements").disableSelection();
        /*   Sortable SOCIAL END   */

        /*   SORTABLE TEL START   */
        $("#sortable").sortable({
            handle: ".telSortablehandle",
            stop:function (){
                let uiSortablehandle = $('.telContainer').find('.checkDeleteButtonTel');
                uiSortablehandle.each(function (index){
                    if(index == 0){
                        $(this).html('');
                    }else {
                        $(this).html(`
                      <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                      <i class="la la-trash-o"></i>Delete</a>
                       `);
                    }
                });

            }
        });
        $("#sortable").disableSelection();
        /*   SORTABLE TEL END   */
    </script>


    <!--  TINYMCE  -->
    <script src="{{ asset('assets/plugins/tinymce2/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.tinymceEditor',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 300,
            forced_root_block: "", // Bunu yandirdiqda adi vaxti <p> tagi ichine alirdisa artiq almiyacaq
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
            file_picker_callback(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight

                tinymce.activeEditor.windowManager.openUrl({
                    url: '/file-manager/tinymce5',
                    title: 'File Manager',
                    width: x * 0.8,
                    height: y * 0.8,
                    onMessage: (api, message) => {
                        callback(message.content, {text: message.text})
                    }
                })
            }
        });

    </script>


@endsection
