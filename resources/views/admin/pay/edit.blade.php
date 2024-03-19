@extends('admin.layouts.index')
@section('title')
    Edit User
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
                            <a href="{{ route('admin.pay.index') }}" class="text-muted">Pays</a>
                        </li>

                        <li class="breadcrumb-item">
                            Pay
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
                                    <form class="form" id="submit-form" action="{{ route('admin.pay.update', $pay) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            @if($pay->status == 2)
                                                <span class="text-success">Status active: Success</span>
                                            @elseif($pay->status == 3)
                                                <span class="text-danger">Status active: Cancel</span>
                                            @else
                                                <span class="text-warning">Status active: Pending</span>
                                            @endif
                                            <!--User Category-->
                                            <div class="form-group row form-user_category" >

                                                <label for="user_category" class="col-lg-3 col-form-label">Pay Status</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="1">Pending</option>
                                                        <option value="2">Success</option>
                                                        <option value="3">Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Save</button>
                                        </div>

                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('CSS')
    <link rel='stylesheet' href='{{ asset('backend/assets/plugins/cropper/croppie.css') }}'>
@endsection

