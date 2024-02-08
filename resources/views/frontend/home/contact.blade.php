@extends('frontend.layouts.index')

@section('title',empty(language('frontend.contact.title')) ? language('frontend.contact.name') : language('frontend.contact.title'))
@section('keywords', language('frontend.contact.keywords') )
@section('description',language('frontend.contact.description') )

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">{{ language('general.contact') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- About -->
    <section class="section about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 d-flex align-items-center">
                    <div class="about-content">
                        <main>

                            <!-- contact area start -->
                            <section class="contact__area pt-115 pb-120">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xxl-4 offset-xxl-1 col-xl-4 offset-xl-1 col-lg-5 offset-lg-1 contact-bottom-offset">
                                            <div class="contact__info white-bg p-relative z-index-1">
                                                <div class="contact__shape">
                                                    <img class="contact-shape-1" src="{{ asset('frontend/assets/images/shape/contact-shape-1.png') }}" alt="">
                                                    <img class="contact-shape-2" src="{{ asset('frontend/assets/images/shape/contact-shape-2.png') }}" alt="">
                                                </div>
                                                <div class="contact__info-inner white-bg">

                                                    @if(!empty(setting('address',true)))
                                                        <div class="contact__info-item d-flex align-items-start mb-35">
                                                            <div class="contact__info-icon mr-15">
                                                                <svg class="map" viewBox="0 0 24 24">
                                                                    <path class="st0" d="M21,10c0,7-9,13-9,13s-9-6-9-13c0-5,4-9,9-9S21,5,21,10z"/>
                                                                    <circle class="st0" cx="12" cy="10" r="3"/>
                                                                </svg>
                                                            </div>
                                                            <div class="contact__info-text">
                                                                <h4>{{ language('frontend.contact.address') }}</h4>
                                                                <p><a href="{{ setting('map') }}" target="blank">{{ setting('address',true) }}</a></p>

                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(!empty(setting('email')))
                                                        <div class="contact__info-item d-flex align-items-start mb-35">
                                                            <div class="contact__info-icon mr-15">
                                                                <svg class="mail" viewBox="0 0 24 24">
                                                                    <path class="st0" d="M4,4h16c1.1,0,2,0.9,2,2v12c0,1.1-0.9,2-2,2H4c-1.1,0-2-0.9-2-2V6C2,4.9,2.9,4,4,4z"/>
                                                                    <polyline class="st0" points="22,6 12,13 2,6 "/>
                                                                </svg>
                                                            </div>

                                                            <div class="contact__info-text">
                                                                <h4>{{ language('frontend.contact.email') }}</h4>
                                                                <p><a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a></p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(setting('tel') != '[{"tel":null}]' && !empty(json_decode(setting('tel'))))
                                                        <div class="contact__info-item d-flex align-items-start mb-35">
                                                            <div class="contact__info-icon mr-15">
                                                                <svg class="call" viewBox="0 0 24 24">
                                                                    <path class="st0" d="M22,16.9v3c0,1.1-0.9,2-2,2c-0.1,0-0.1,0-0.2,0c-3.1-0.3-6-1.4-8.6-3.1c-2.4-1.5-4.5-3.6-6-6  c-1.7-2.6-2.7-5.6-3.1-8.7C2,3.1,2.8,2.1,3.9,2C4,2,4.1,2,4.1,2h3c1,0,1.9,0.7,2,1.7c0.1,1,0.4,1.9,0.7,2.8c0.3,0.7,0.1,1.6-0.4,2.1  L8.1,9.9c1.4,2.5,3.5,4.6,6,6l1.3-1.3c0.6-0.5,1.4-0.7,2.1-0.4c0.9,0.3,1.8,0.6,2.8,0.7C21.3,15,22,15.9,22,16.9z"/>
                                                                </svg>
                                                            </div>
                                                            <div class="contact__info-text">
                                                                <h4>{{ language('frontend.contact.phone') }}</h4>
                                                                @foreach(json_decode(setting('tel')) as $key => $value)
                                                                    <p><a href="tel:{{ \App\Services\CommonService::telText( $value->tel )[0] }}">{{ \App\Services\CommonService::telText( $value->tel )[1] }}</a></p>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(!empty(json_decode(setting('social'))))
                                                        <div class="contact__social pl-30">
                                                            <h4>{{ language('frontend.contact.follow') }}</h4>
                                                            <ul>
                                                                @foreach(json_decode(setting('social')) as $key => $value)
                                                                    <li>
                                                                        <a class="{{ $value->name }}" {{ isset($value->status) ? 'target="_blank"': null }} href="{{ $value->link }}" target="_blank" rel="nofollow">
                                                                            <i class="socicon-{{ $value->name }}"></i>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-7 col-xl-7 col-lg-6">
                                            <div class="contact__wrapper">
                                                <div class="contact__form">
                                                    <form id="contact-form" action="{{ route('frontend.home.contactSendAjax') }}" method="POST" onsubmit="return false">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-xxl-6 col-xl-6 col-md-6">
                                                                <div class="contact__form-input mb-15">
                                                                    <input type="text" name="name" id="inputName" placeholder="{{ language('frontend.contact.your_name') }}" class="mb-5 formInput">
                                                                    <div class="error errorName text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-xl-6 col-md-6">
                                                                <div class="contact__form-input mb-15">
                                                                    <input type="email" name="email" id="inputEmail" placeholder="{{ language('frontend.contact.your_email') }}" class="mb-5 formInput">
                                                                    <div class="error errorEmail text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <div class="contact__form-input mb-15">
                                                                    <input type="text" name="subject" id="inputSubject" placeholder="{{ language('frontend.contact.your_subject') }}" class="mb-5 formInput">
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <div class="contact__form-input mb-15">
                                                                    <textarea name="message" id="textareaMessage" placeholder="{{ language('frontend.contact.your_message') }}" class="mb-5 formInput"></textarea>
                                                                    <div class="error errorMessage text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <div class="contact__btn">
                                                                    <button class="btn btn-primary back-btn mb-4">{{ language('frontend.contact.send_message') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="ajax-response"></p>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- contact area end -->

                        </main>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /About -->


@endsection

@section('CSS')
    <style>
        .mb-5 {
            margin-bottom: 20px !important;
        }
    </style>
@endsection

@section('JS')

    <script>
        function setAction(form) {
         alert('asdsa');
            return false;
        }
    </script>
@endsection



