@extends('frontend.layouts.index')

@section('title',empty(language('frontend.pay.title')) ? language('frontend.pay.name') : language('frontend.pay.title'))
@section('keywords', language('frontend.pay.keywords') )
@section('description',language('frontend.pay.description') )


@section('content')


    <main>

        @if($user)
        <!-- tp-hero-area start -->
        <section class="tphero-area pt-140 pb-140">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12">
                        <div class="tpdesign-hero text-center">
                            <div class="tpdesign-hero-image mb-25">
                                <img src="{{ !empty($user->profile_photo) ? asset('storage/profile/'. $user->profile_photo) : asset('storage/no-image.png') }}" alt="{{ $user->name }}">
                            </div>
                            <span class="tpdesign-sub-title mb-10">{{ $user->name }}</span>
                            <p class="pb-10">{{ $user->user_category_name }}</p>


                            <div class="row justify-content-center">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-center">

                                    <form action="{{ route('frontend.pay.go') }}" method="POST">
                                        @csrf

                                        <input class="hidden" name="user_id" type="hidden" value="{{ $user->id }}" />

                                        <div class="form-group mb-25">
                                            <input class="form-control form-control-lg" name="amount" id="amount" type="number" min="0" step="0.10" placeholder="0" value="{{ old('amount') }}" required="required" />
                                            @if($errors->has('amount'))
                                                <div class="error text-danger">{{ $errors->first('amount') }}</div>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-primary tp-grd-btn">{{ language('frontend.pay.payment') }}</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="tphero__shape tphero__shape-1">
                <svg width="22" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 0L17.1432 9.67376H27.3148L19.0858 15.6525L22.229 25.3262L14 19.3475L5.77101 25.3262L8.9142 15.6525L0.685208 9.67376H10.8568L14 0Z" fill="#1C99FE"/>
                </svg>
            </div>
            <div class="tphero__shape tphero__shape-2">
                <svg width="22" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="#FD4766"/>
                </svg>
            </div>
            <div class="tphero__shape tphero__shape-3">
                <svg width="22" height="22" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 0L17.1432 9.67376H27.3148L19.0858 15.6525L22.229 25.3262L14 19.3475L5.77101 25.3262L8.9142 15.6525L0.685208 9.67376H10.8568L14 0Z" fill="#1C99FE"/>
                </svg>
            </div>
            <div class="tphero__shape tphero__shape-4">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.8826 21.4431L8.52566 14.734L0.798549 16.8045L5.83292 10.5875L1.47597 3.87841L8.94433 6.74524L13.9787 0.528313L13.56 8.51705L21.0284 11.3839L13.3013 13.4544L12.8826 21.4431Z" fill="#FFCC41"/>
                </svg>
            </div>

        </section>
        <!-- tp-hero-area end -->
        @else
            {{ language('No User') }}
        @endif


    </main>


@endsection


@section('CSS')
@endsection

@section('JS')
@endsection

