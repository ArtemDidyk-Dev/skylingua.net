@extends('admin.layouts.index')
@section('title')
    File Manager
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">File Manager</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            File Manager
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
            <div id="ckfinder-widget"></div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->


@endsection

@section('CSS')
@endsection



@section('js')


    <script>

        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
        let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight
        var windowHeight = y * 0.8;

        CKFinder.widget( 'ckfinder-widget', {
            width: '100%',
            language:'{{ cache('language-default') }}',
            // height: windowHeight+'px',
            height: windowHeight+'px',
            plugins: [
                // Path must be relative to the location of ckfinder.js file
                'samples/plugins/StatusBarInfo/StatusBarInfo'
            ]
        } );
    </script>

@endsection
