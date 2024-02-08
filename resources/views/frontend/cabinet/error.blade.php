@extends('frontend.layouts.index')

@section('title',empty($data['title']) ? $data['name'] : $data['title'])
@section('keywords', $data['keywords'] )
@section('description', $data['description'] )


@section('content')




    <main>


        <!-- postbox area start -->
        <section class="postbox__area pt-120 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">

                        <div class="card">
                            <div class="icon_radius">
                                <i class="checkmark">
                                    @if($data['status'] == true)
                                    ✓
                                    @else
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                    @endif
                                </i>
                            </div>
                            @if($data['status'] == true)
                                <h1>{{ language('frontend.common.success')  }}</h1>
                            @else
                                <h1>{{ language('frontend.common.error')  }}</h1>
                            @endif

                            <p>{{ $data['message'] }}</p>


                            <div class="sign__new text-center">
                                <p>{{ language('frontend.register.pleace_get_login') }} <a href="{{ route('frontend.login.index') }}"> {{ language('frontend.register.sign_in') }}</a></p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- postbox area end -->

    </main>


@endsection


@section('CSS')
    <style>
    main {
    text-align: center;
    padding: 40px 0;
    background: #EBF0F5;
    }
    main .card h1 {
    font-weight: 900;
    font-size: 40px;
    margin-bottom: 10px;
    }
    main .card p {
    color: #404F5E;
    font-size:20px;
    margin: 0;
    }
    main .card i {
    font-size: 100px;
    line-height: 200px;
    margin-left:-15px;
    }
    main .card {
    background: white;
    padding: 60px;
    border-radius: 4px;
    box-shadow: 0 2px 3px #C8D0D8;
    display: inline-block;
    margin: 0 auto;
    }
    main .card .icon_radius {
    border-radius: 200px;
    height: 200px;
    width: 200px;
    margin: 0 auto;
    }


    @if($data['status'] == true)
        main .card i {
        color: #9ABC66;
        }
        main .card h1 {
        color: #88B04B;
        }
        main .card .icon_radius {
        background: #F8FAF5;
        }
    @else
        main .card i {
        color: #842029;
        font-style: normal;
        }
        main .card h1 {
        color: #ba3925;
        }
        main .card .icon_radius {
        background: #f8d7da;
        border: 1px solid #f5c2c7;
        }
    @endif
    </style>
@endsection

@section('JS')
@endsection

