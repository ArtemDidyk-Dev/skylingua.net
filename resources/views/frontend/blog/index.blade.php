@extends('frontend.layouts.index')

@section('title',empty(language('frontend.blog.title')) ? language('frontend.blog.name') : language('frontend.blog.title'))
@section('keywords', language('frontend.blog.keywords') )
@section('description',language('frontend.blog.description') )


@section('content')

    <div class="bread-crumb-bar">

    </div>


    <!-- Page Content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12">

                    @if($blogs)
                    <div class="row blog-grid-row">
                        @foreach($blogs as $blog)
                        <div class="col-md-4">
                                <!-- Blog Post -->
                                <div class="blog grid-blog aos" data-aos="fade-up">
                                    <div class="blog-image">
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                            @if(empty($blog->image))
                                                <img class="img-fluid" src="{{ asset('storage/no-image.png') }}"
                                                     alt="{{ $blog->name }}">
                                            @else
                                                <img class="img-fluid" src="{{  \App\Services\ImageService::resizeImageSize($blog->image,'medium',80) }}"
                                                     alt="{{ $blog->name }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="blog-content">
                                        <h3 class="blog-title"><a href="{{ route('frontend.blog.detail', $blog->slug) }}">{{ $blog->name }}</a></h3>
                                    </div>
                                </div>
                                <!-- /Blog Post -->

                            </div>
                        @endforeach
                    </div>

                    <!-- Blog Pagination -->
                    <div class="row pb-4">
                        <div class="col-md-12">
                            <div class="blog-pagination text-center">
                                {{ $blogs->appends(['search' => isset($searchText) ? $searchText : null])
            ->render('vendor.pagination.frontend.dashboard-pagination') }}
                            </div>
                        </div>
                    </div>
                    <!-- /Blog Pagination -->

                    @else
                    <p>{{ language('No Blogs') }}</p>
                    @endif

                </div>

            </div>
        </div>
    </div>
    <!-- /Page Content -->


@endsection


@section('CSS')
@endsection

@section('JS')
@endsection

