@extends('frontend.layouts.index')

@section('title',empty($blog->title) ? $blog->name : $blog->title)
@section('keywords', $blog->keyword )
@section('description', $blog->description )


@section('content')

    <div class="bread-crumb-bar">

    </div>


    <!-- Page Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog-view">
                        <div class="blog-single-post pro-post widget-box">
                            <div class="blog-image">
                                @if(empty($blog->image))
                                <img class="img-fluid" src="{{ asset('storage/no-image.png') }}"
                                         alt="{{ $blog->name }}">
                                @else
                                <img class="img-fluid" src="{{  \App\Services\ImageService::resizeImageSize($blog->image,'large',80) }}"
                                         alt="{{ $blog->name }}">
                                @endif
                            </div>
                            <h1 class="blog-title">{{ $blog->name }}</h1>
                            <div class="blog-content">
                                {!! $blog->text !!}
                            </div>
                        </div>
                    </div>
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

