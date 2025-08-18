@extends('admin.layouts.index')
@section('title')
    Projects
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Projects</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Projects</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Projects
                            </li>
                        @endisset
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
                        <h3 class="card-label">Projects</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="card-title">
                            <form action="{{ route('admin.project.search') }}" method="GET">
                                <div class="input-group">
                                    <input
                                        type="search"
                                        class="form-control"
                                        value="@isset($searchText){{ $searchText }}@endisset"
                                        autocomplete="off"
                                        name="search"
                                        placeholder="Search...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success" type="button">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <a href="{{ route('admin.project.add') }}">
                            <button
                                tooltip="Add Project"
                                flow="left"
                                class="btn addDataModalButton btn-icon btn-success btn-circle btn-lg">
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
                            <th width="10" data-breakpoints="xs sm md lg">ID</th>
                            <th>Name</th>
                            <th data-breakpoints="xs sm md">Category</th>
                            <th data-breakpoints="xs sm md">Expiry</th>
                            <th data-breakpoints="xs sm md">Price</th>
                            <th data-breakpoints="xs sm md lg">Hired/Taken</th>
                            <th data-breakpoints="xs sm md"></th>
                            <th data-breakpoints="xs">Status</th>
                            <th data-breakpoints="xs">Approve</th>
                            <th width="40" data-breakpoints="xs sm md" data-sortable="false">Setting</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr class="table-id-{{ $project->id }}" data-index="{{ $project->id }}" data-position="{{ $project->sort }}">
                               <!-- ID -->
                                <td>{{$project->id}}</td>

                                <!--  NAME  -->
                                <td><a target="_blank" href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a></td>

                                <!--  Category  -->
                                <td>{{ $project->user_categories_name }}</td>

                                <!--  Expiry  -->
                                <td>{{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</td>

                                <!--  Price  -->
                                <td>
                                @if($project->hired)
                                    <b>${{ $project->hired->price }}</b>
                                    <p>
                                        @if($project->status == 3 || $project->status == 4)
                                            Taken Price
                                        @else
                                            Hired Price
                                        @endif
                                    </p>
                                @else
                                    @if($project->price > 0)
                                            <b>${{ $project->price }}</b>
                                    @endif
                                    <p>
                                        @if($project->price_type == 1)
                                            Fixed Price
                                        @elseif($project->price_type == 2)
                                            Hourly Pricing
                                        @else
                                            Bidding Price
                                        @endif
                                    </p>
                                @endif
                                </td>

                                <!--  Hired/Taken  -->
                                <td>
                                @if($project->hired)
                                    <p class="hired-detail">
                                        @if($project->status == 3 || $project->status == 4)
                                            Taken on {{ \Carbon\Carbon::parse($project->hired->updated_at)->format('M d, Y') }}
                                        @elseif($project->status == 5)
                                            Canceled on {{ \Carbon\Carbon::parse($project->hired->updated_at)->format('M d, Y') }}
                                        @else
                                            Hired on {{ \Carbon\Carbon::parse($project->hired->created_at)->format('M d, Y') }}
                                        @endif
                                    </p>
                                @endif
                                </td>

                                <!--  Proposals or Hired  -->
                                <td>
                                    @if($project->hired)
                                        <a target="_blank" href="{{ route('frontend.profile.index', $project->hired->freelancer_id) }}" >
                                            {{ $project->hired->user_name }}
                                        </a>
                                        <span> |
                                             @if($project->status == 3)
                                                Ongoing
                                            @elseif($project->status == 4)
                                                Completed
                                            @elseif($project->status == 5)
                                                Canceled
                                            @else
                                                Hired
                                            @endif
                                        </span>
                                    @else
                                        @if($project->proposals_count > 0)
                                            <a target="_blank" href="{{ route('frontend.dashboard.employer.project.proposals', $project->id) }}">
                                                <span>Proposals</span>
                                                <span>({{ $project->proposals_count }})</span>
                                            </a>
                                        @else
                                        <span>Proposals</span>
                                        <span>(0)</span>
                                        @endif
                                    @endif
                                </td>

                                <!--  Status  -->
                                <td>
                                    @if($project->status == 1)
                                        <span style="background-color: #5cbb5f" class="badge badge-success">Published</span>
                                    @elseif($project->status == 2)
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($project->status == 3)
                                        <span class="badge badge-info">Ongoing</span>
                                    @elseif($project->status == 4)
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($project->status == 5)
                                        <span class="badge badge-danger">Canceled</span>
                                    @else
                                        <span class="badge badge-secondary">Unpublished</span>
                                    @endif
                                </td>

                                <!--  Approve  -->
                                <td>
                                    @if($project->approve == 1)
                                        <span style="background-color: #5cbb5f" class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif
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
                                                    <span class="font-size-lg">Setting:</span>
                                                    <i class="flaticon2-information icon-md text-muted"
                                                       data-toggle="tooltip" data-placement="right" title=""
                                                       data-original-title="Click to learn more..."></i>
                                                </li>
                                                <li class="navi-separator mb-3 opacity-70"></li>

                                                <li
                                                    class="navi-item redakteEt">
                                                    <a href="{{ route('admin.project.edit',$project->id) }}" class="navi-link text-center">
																		<span class="navi-text">
																			<span
                                                                                class="label label-xl label-inline label-light-primary">Edit</span>
																		</span>
                                                    </a>
                                                </li>

                                                <li
                                                    class="navi-item deleteButton"
                                                    data-id="{{ $project->id }}"
                                                >
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
                <div class="card-footer">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center py-3">
                            <span class="text-muted">
                                Total <b><span class="totalCount">{{ $getProjects->total() }}</span></b> items
                                @if($getProjects->hasPages())
                                    , <b>{{ $getProjects->lastPage() }}
                                </b> səhifədən  <b>{{ $getProjects->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $getProjects->appends(['search' => isset($searchText) ? $searchText : null])
                                 ->render('vendor.pagination.backend.my-pagination') }}
                        </div>
                        <!--  Paginate END -->
                    </div>

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
        jQuery(function ($) {
            $('.table').footable({
                "empty": "No found",
            });
        });
    </script>

    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        });





        /*   Delete START   */

        $(document).on('click', '.deleteButton', function () {
            let dataID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.project.deleteAjax') }}",
                type: 'POST',
                data: {id: dataID},
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "Are you sure you want to delete the project?",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            cancelButtonText: "No",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function (result) {
                            if (result.value) {

                                $.ajax({
                                    url: "{{ route('admin.project.delete') }}",
                                    type: 'POST',
                                    data: {id:dataID},
                                    dataType: 'JSON',
                                    success: function (response) {

                                        if (response.success) {
                                            $('.table-id-'+dataID).fadeOut(1000);
                                            // $('.table-id-'+languageID).remove();
                                            var totalCount = $('.totalCount').text();
                                            $('.totalCount').text(parseInt(totalCount)-1);

                                        }
                                    }
                                });

                                Swal.fire(
                                    "Deleted!",
                                    "The project has been deleted!",
                                    "success"
                                )
                            }
                        });

                    }


                }
            });


        })

        /*   Delete END   */


    </script>
@endsection
