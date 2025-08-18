@extends('admin.layouts.index')
@section('title')
    Edit faq
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
                            Edit faq
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
                                <h3 class="card-label">Edit faq</h3>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form" id="submit-form" action="{{ route('admin.faq.update', $faq) }}" method="POST" >
                                        @csrf
                                        <div class="card-body">
                                            <div class="mb-15">
                                                <!--  Title  -->
                                                <div class="form-group row form-name">
                                                    <label for="name" class="col-lg-3 col-form-label">Title</label>
                                                    <div class="col-lg-9">
                                                        <input id="name" type="text" name="title" value="{{ old('title', $faq->title)   }}" class="form-control form-control-lg" placeholder="Title"/>
                                                        @error('title' )<span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <!--  CONTENT START  -->
                                                <div class="form-group">
                                                    <span class="span-dvidder">Description</span>
                                                    <textarea style="margin-top: 20px; min-height: 300px"
                                                              type="text"
                                                              name="content"
                                                              class="tinymceEditor form-control">{{ old('content', $faq->content)}}</textarea>
                                                    @error('content')<span
                                                        class="text-danger">{{ myError($message) }}</span> @enderror
                                                </div>
                                                <!--  CONTENT END  -->
                                            </div>
                                        </div>
                                        <button type="submit" form="submit-form" class="btn btn-success btn-sm ">Save</button>
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
    <!--end::Entry-->
@endsection

@section('CSS')
    <link href="https://cdn.rawgit.com/shabuninil/fileup/master/src/fileup.min.css" rel="stylesheet">
    <style>
        .modal-backdrop.show {
            opacity: 1 !important;
        }

        .modal-backdrop {
            background-color: rgba(255, 255, 255, 0.71) !important;
        }

        @media (min-width: 576px) {
            .modal-content {
                -webkit-box-shadow: 0 0 1.5rem 0 rgba(0, 0, 0, 0.10);
                box-shadow: 0 0 1.5rem 0 rgba(0, 0, 0, 0.10);
            }
        }

        .projectUserNameResult {
            margin-top: 5px;
            margin-left: 3px;
            font-weight: 600;
            display: none;
        }
    </style>
@endsection
