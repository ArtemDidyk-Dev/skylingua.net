@extends('admin.layouts.index')
@section('title')
    Comment
@endsection

@section('content')
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">

                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-muted">Comment</a>
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
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Comment</h3>
                    </div>
                    <div class="card-toolbar">

                        <a href="{{ route('admin.comment.create') }}">
                            <button tooltip="Add Comment" flow="left"
                                    class="btn btn-icon btn-success btn-circle btn-lg">
                                <i class="flaticon-plus"></i>
                            </button>
                        </a>

                    </div>
                </div>

                <div class="card-body">
                    <!--  MYTABLE START  -->
                    <table class="table table-hover table-striped" data-sorting="true">
                        <thead class="thead-light">
                        <tr>
                            <th width="10" data-breakpoints="xs">ID</th>
                            <th data-breakpoints="xs sm md">Name</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Settings</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        @foreach ($comments as $comment)
                            <tr class="table-id-{{ $comment->id }}" data-index="{{ $comment->id }}">
                                <!--  ID  -->
                                <td>{{ $comment->id }}</td>
                                <!--  Service NAME  -->
                                <td>
                                    {{ $comment->name }}
                                </td>
                                <td>
                                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title=""
                                         data-placement="left" data-original-title="Quick actions">
                                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </a>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right"
                                             style="">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover">
                                                <li class="navi-header font-weight-bold py-4">
                                                    <span class="font-size-lg">Settings:</span>
                                                    <i class="flaticon2-information icon-md text-muted"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="Click to learn more..."></i>
                                                </li>
                                                <li class="navi-separator mb-3 opacity-70"></li>

                                                <li class="navi-item">

                                                    <a href="{{ route('admin.comment.edit', $comment) }}"
                                                       class="navi-link text-center">
                                                            <span class="navi-text">
                                                                <span
                                                                    class="label label-xl label-inline label-light-primary">Edit</span>
                                                            </span>
                                                    </a>
                                                </li>

                                                <li class="navi-item deleteButton" data-id="{{ $comment->id }}">
                                                    <a href="#" class="navi-link text-center">
                                                            <span class="navi-text">
                                                                <span
                                                                    class="label  label-xl label-inline label-light-danger">Delete</span>
                                                            </span>
                                                    </a>
                                                </li>

                                            </ul>
                                            <!--end::Navigation-->

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--  MYTABLE END  -->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

@section('CSS')
@endsection

@section('js')
    <script>

        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.deleteButton', function() {
                var dataID = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.comment.delete') }}",
                    type: 'DELETE',
                    data: {
                        id: dataID,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success) {
                            $('.table-id-' + dataID).fadeOut(1000);
                            // $('.table-id-'+dataID).remove();
                            var totalCount = $('.totalCount').text();
                            $('.totalCount').text(parseInt(totalCount) - 1);

                        }
                    }
                });
            })
            /*   Delete END   */
        });
    </script>
@endsection
