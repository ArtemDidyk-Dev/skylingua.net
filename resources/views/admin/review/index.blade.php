@extends('admin.layouts.index')
@section('title')
    Review
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Review</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                        </li>
                        @isset($searchText)
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.language.index') }}" class="text-muted">Review</a>
                            </li>
                            <li class="breadcrumb-item">
                                Search
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                Review
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
                        <h3 class="card-label">Review</h3>
                    </div>
                    <div class="card-toolbar">
                        {{--                        <div class="card-title"> --}}
                        {{--                            <form action="{{ route('admin.language.search') }}" method="GET"> --}}
                        {{--                                <div class="input-group"> --}}
                        {{--                                    <input --}}
                        {{--                                        type="search" --}}
                        {{--                                        class="form-control" --}}
                        {{--                                        value="@isset($searchText){{ $searchText }}@endisset" --}}
                        {{--                                        autocomplete="off" --}}
                        {{--                                        name="search" --}}
                        {{--                                        placeholder="Axtar..."> --}}
                        {{--                                    <div class="input-group-append"> --}}
                        {{--                                        <button type="submit" class="btn btn-success" type="button">Axtar</button> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </form> --}}
                        {{--                        </div> --}}

                        <!--  ADD BUTTON  -->
                        <a href="{{ route('admin.review.add') }}">
                            <button tooltip="Əlavə et" flow="left"
                                class="btn addDataModalButton btn-icon btn-success btn-circle btn-lg">
                                <i class="flaticon-plus"></i>
                            </button>
                        </a>



                        {{--                        <!--  DELETE BUTTON  --> --}}
                        {{--                        <a class="select-btn-action" href="#"> --}}
                        {{--                            <button --}}
                        {{--                                tooltip="Sil" --}}
                        {{--                                flow="left" --}}
                        {{--                                class="btn btn-icon btn-danger btn-circle btn-lg ml-2"> --}}
                        {{--                                <i class="flaticon-delete"></i> --}}
                        {{--                            </button> --}}
                        {{--                        </a> --}}


                    </div>
                </div>

                <div class="card-body">
                    <!--  MYTABLE START  -->
                    <table class="table table-hover table-striped" data-sorting="true">
                        <thead class="thead-light">
                            <tr>
                                {{--                            @if ($reviews->count() != 0) --}}
                                {{--                                <th width="10" data-sortable="false"> --}}
                                {{--                                    <label class="checkbox checkbox-success select-all-btn"> --}}
                                {{--                                        <input type="checkbox"   /> --}}
                                {{--                                        <span></span> --}}
                                {{--                                    </label> --}}
                                {{--                                </th> --}}
                                {{--                            @endif --}}
                                <th width="10" data-breakpoints="xs">ID</th>
                                <th>User From</th>
                                <th>User To</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th data-breakpoints="xs sm md" data-sortable="false">Date</th>
                                <th width="40" data-breakpoints="xs sm md" data-sortable="false">Setting</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach ($reviews as $review)
                                <tr class="table-id-{{ $review->id }}" data-index="{{ $review->id }}"
                                    data-position="{{ $review->sort }}">


                                    <!-- SELECT ALL -->
                                    {{--                                <td> --}}
                                    {{--                                    <label class="checkbox checkbox-success select-element-btn" data-id="{{ $review->id }}"> --}}
                                    {{--                                        <input type="checkbox"   /> --}}
                                    {{--                                        <span></span> --}}
                                    {{--                                    </label> --}}
                                    {{--                                </td> --}}


                                    <!-- ID -->
                                    <td>{{ $review->id }}</td>
                                    <!-- name -->
                                    <td class="sortableHandle">{{ $review->reviews_from }} ({{ $review->from }})</td>

                                    <!-- reviews_to -->
                                    <td class="sortableHandle">{{ $review->reviews_to }} ({{ $review->to }})</td>

                                    <!-- rating -->
                                    <td class="sortableHandle">{{ $review->rating }}</td>

                                    <!-- review -->
                                    <td class="sortableHandle">{{ $review->review }}</td>

                                    <!--  Tarix  -->
                                    <td>{{ updateDate($review->updated_at, $review->updated_at) }}</td>


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

                                                    <li class="navi-item redakteEt">
                                                        <a href="{{ route('admin.review.edit', $review->id) }}"
                                                            class="navi-link text-center">
                                                            <span class="navi-text">
                                                                <span
                                                                    class="label label-xl label-inline label-light-primary">Edit</span>
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li class="navi-item deleteButton" data-id="{{ $review->id }}">
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
                                Total <b><span class="totalCount">{{ $reviews->total() }}</span></b> items
                                @if ($reviews->hasPages())
                                    , <b>{{ $reviews->lastPage() }}
                                    </b> səhifədən <b>{{ $reviews->currentPage() }}</b>-ci göstərildi.
                                @endif

                            </span>
                        </div>
                        <!--  Paginate START -->
                        <div class="d-flex flex-wrap py-2 mr-3">
                            {{ $reviews->appends(['search' => isset($searchText) ? $searchText : null])->render('vendor.pagination.backend.my-pagination') }}
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
        jQuery(function($) {
            $('.table').footable({
                "empty": "No found",
            });
        });
    </script>

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /*   Sortable  START   */
            $("#sortable").sortable({
                handle: ".sortableHandle",
                update: function(event, ui) {
                    $(this).children().each(function(index) {
                        if ($(this).attr('data-position') != (index + 1)) {
                            $(this).attr('data-position', (index + 1)).addClass('updated');
                        }
                    });
                    //Position yadda saxla
                    saveNewPositions();
                }
            });
            $("#sortable").disableSelection();
        });

        /*   Yeni Sort elave et function   */
        function saveNewPositions() {
            var positions = [];
            $('.updated').each(function() {
                positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                $(this).removeClass('updated');
            });


            $.ajax({
                url: "{{ route('admin.review.sortAjax') }}",
                method: 'POST',
                dataType: 'JSON',
                data: {
                    update: 1,
                    positions: positions
                },
                success: function(response) {
                    toastr.success("Success");
                }
            });
        }

        /*   Sortable  END   */



        /*   Delete START   */

        $(document).on('click', '.deleteButton', function() {
            var reviewID = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.review.deleteAjax') }}",
                type: 'POST',
                data: {
                    id: reviewID
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {

                        Swal.fire({
                            title: "Attention?",
                            html: "Are you sure you want to delete the review?",
                            icon: "error",
                            showCancelButton: true,
                            confirmButtonText: "Delete!",
                            cancelButtonText: "No",
                            customClass: {
                                confirmButton: "btn btn-light-danger font-weight-bold",
                                cancelButton: 'btn btn-light-primary font-weight-bold',
                            }
                        }).then(function(result) {
                            if (result.value) {

                                $.ajax({
                                    url: "{{ route('admin.review.delete') }}",
                                    type: 'POST',
                                    data: {
                                        id: reviewID
                                    },
                                    dataType: 'JSON',
                                    success: function(response) {

                                        if (response.success) {
                                            $('.table-id-' + reviewID).fadeOut(
                                            1000);
                                            // $('.table-id-'+languageID).remove();
                                            var totalCount = $('.totalCount')
                                        .text();
                                            $('.totalCount').text(parseInt(
                                                totalCount) - 1);

                                        }
                                    }
                                });

                                Swal.fire(
                                    "Deleted!",
                                    "The review has been deleted!",
                                    "success"
                                )
                            }
                        });

                    }


                }
            });


        })

        /*   Delete END   */

        /*   EDITOR START   */
        tinymce.init({
            selector: "textarea.editorTiny",
            theme: "modern",
            height: 150,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

        });
        /*   EDITOR END   */
    </script>


    <!--  DELETE ALL ELEMENTS (SELECTED) START  -->
    {{--    <script> --}}
    {{--        deleteALlSelectedElements( --}}
    {{--            'Diqqət?', --}}
    {{--            'Seçilmişləri silmək istədiyinizə əminsiniz?', --}}
    {{--            'Sil!', --}}
    {{--            'Xeyir', --}}
    {{--            '{{ route('admin.review.allDeleteAjax') }}', --}}
    {{--            '{{ route('admin.review.index') }}' --}}
    {{--        ); --}}
    {{--    </script> --}}
    <!--  DELETE ALL ELEMENTS (SELECTED) END  -->
@endsection