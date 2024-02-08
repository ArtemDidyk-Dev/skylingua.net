@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>

                <!-- Verification Details -->
                <div class="col-xl-9 col-md-8">
                    <div class="card">
                        <div class="payment-list wallet card-body">
                            <h3>{{ language('Verification Details') }}</h3>
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">{{ language('Your Name') }}</label>
                                            <input class="form-control" id="first_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">{{ language('Contact Number') }}</label>
                                            <input class="form-control" id="last_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="card_number">{{ language('CNIC / Passport / NIN / SSN') }}</label>
                                            <input class="form-control" id="card_number" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ language('Upload Document') }}</label>
                                            <div class="uplod">
                                                <label class="file-upload image-upbtn">
                                                    {{ language('Select Document') }} <input type="file">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">{{ language('Address') }}</label>
                                            <textarea class="form-control" rows="5" id="comment"></textarea>
                                            <p class="mt-2">{{ language('Your account information should match with the document that you are providing.') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn-primary click-btn">{{ language('Submit verification') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Verification Details -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
@endsection

