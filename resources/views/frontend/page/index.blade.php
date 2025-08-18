@extends('frontend.layouts.index')

@section('title',empty($page->title) ? $page->name : $page->title)
@section('keywords', $page->keyword )
@section('description', $page->description )

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">{{ $page->name }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- About -->
    <section class="section about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="
                @if($page->image)
                col-lg-6
                @else
                col-lg-12
                @endif
                d-flex align-items-center">
                    <div class="about-content">
                        {!! $page->text !!}
                    </div>
                </div>
                @if($page->image)
                <div class="offset-lg-1 col-lg-5">
                    <div class="about-img">
                        <img class="img-fluid" src="{{ $page->image }}" alt="">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- /About -->


@endsection

@section('CSS')
@endsection

@section('JS')
@endsection



