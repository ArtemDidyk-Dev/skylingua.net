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
                <div class="col-xl-9 col-md-8">
                    <div class="freelance-title" id="plan">
                        <h3>{{ language('Freelancer Packages') }}</h3>
                        <p>{{ language('Choose the best pricing that suites your requirements') }}</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="package-detail">
                                <h4>{{ language('Basic Plan') }}</h4>
                                <p>{{ language('Go Pro, Best for the individuals') }}</p>
                                <h3 class="package-price">{{ language('$19.00') }}</h3>
                                <div class="package-feature">
                                    <ul>
                                        <li>{{ language('12 Project Credits') }}</li>
                                        <li>{{ language('10 Allowed Services') }}</li>
                                        <li>{{ language('20 Days visibility') }}</li>
                                        <li>{{ language('5 Featured Services') }}</li>
                                        <li>{{ language('20 Days visibility') }}</li>
                                        <li>{{ language('30 Days Package Expiry') }}</li>
                                        <li class="non-check">{{ language('Profile Featured') }}</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-primary price-btn btn-block">{{ language('Select Plan') }}</a>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="package-detail">
                                <h4>{{ language('Business') }} </h4>
                                <p>{{ language('Highest selling package features') }}</p>
                                <h3 class="package-price">{{ language('$29.00') }}</h3>
                                <div class="package-feature">
                                    <ul>
                                        <li>{{ language('15 Project Credits') }}</li>
                                        <li>{{ language('12 Allowed Services') }}</li>
                                        <li>{{ language('25 Days visibility') }}</li>
                                        <li>{{ language('10 Featured Services') }}</li>
                                        <li>{{ language('30 Days visibility') }}</li>
                                        <li>{{ language('40 Days Package Expiry') }}</li>
                                        <li>{{ language('Profile Featured') }}</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-primary price-btn btn-block">{{ language('Select Plan') }}</a>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="package-detail">
                                <h4>{{ language('The Unlimita') }}</h4>
                                <p>{{ language('Drive crazy, unlimited on the go') }}</p>
                                <h3 class="package-price">{{ language('$79.00') }}</h3>
                                <div class="package-feature">
                                    <ul>
                                        <li>{{ language('Unlimited Project Credits') }}</li>
                                        <li>{{ language('Unlimited Services') }}</li>
                                        <li>{{ language('Services Never Expire') }}</li>
                                        <li>{{ language('20 Featured Services') }}</li>
                                        <li>{{ language('Services Never Expire') }}</li>
                                        <li>{{ language('Package Never Expire') }}</li>
                                        <li>{{ language('Profile Featured') }}</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-primary price-btn btn-block">{{ language('Select Plan') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="member-plan pro-box">
                                <div class="pro-head">
                                    <h2><i class="fa fa-check-circle orange-text" aria-hidden="true"></i> {{ language('Plan Details') }}</h2>
                                </div>
                                <div class="pro-body member-detail">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="mb-0">{{ language('The Ultima') }}</h4>
                                            <div class="yr-amt">{{ language('Anually Price') }}</div>
                                            <div class="expiry-on">{{ language('Expiry On') }}</div>
                                            <div class="expiry">{{ language('24 JAN 2022') }}</div>
                                        </div>
                                        <div class="col-6 change-plan">
                                            <h3>{{ language('$1200') }}</h3>
                                            <div class="yr-duration">{{ language('Duration: One Year') }}</div>
                                            <a href="#plan" class="btn btn-primary btn-plan black-btn">{{ language('Change Plan') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pro-post">
                                <div class="project-table">
                                    <div class="card-body">
                                        <h4>{{ language('STATEMENT') }}</h4>
                                        <div class="table-responsive table-box">
                                            <table class="table table-center table-hover datatable">
                                                <thead class="thead-pink">
                                                <tr>
                                                    <th>{{ language('Purchased Date') }}</th>
                                                    <th>{{ language('Details') }}</th>
                                                    <th>{{ language('Expiry Date') }}</th>
                                                    <th>{{ language('Type') }}</th>
                                                    <th>{{ language('Status') }}</th>
                                                    <th>{{ language('Price') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{ language('15 October 2021') }}</td>
                                                    <td>
                                                        <p class="mb-0">{{ language('The Unlimita') }}</p>
                                                        <a href="#" class="read-text">{{ language('Invoice : IVIP12023598') }}</a>
                                                    </td>
                                                    <td>{{ language('15th July 2022') }}</td>
                                                    <td>{{ language('Yearly') }}</td>
                                                    <td class="text-danger">{{ language('Inactive') }}</td>
                                                    <td>{{ language('$200.00') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ language('15 October 2022') }}</td>
                                                    <td>
                                                        <p class="mb-0">{{ language('The Unlimita') }}</p>
                                                        <a href="#" class="read-text">{{ language('Invoice : IVIP12023598') }}</a>
                                                    </td>
                                                    <td>{{ language('15th July 2023') }}</td>
                                                    <td>{{ language('Yearly') }}</td>
                                                    <td class="text-success">{{ language('Active') }}</td>
                                                    <td>{{ language('$170.00') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-end mt-3">
                                            <ul class="paginations">
                                                <li><a href="#"> <i class="fas fa-angle-left"></i> {{ language('Previous') }}</a></li>
                                                <li><a href="#">{{ language('1') }}</a></li>
                                                <li><a href="#" class="active">{{ language('2') }}</a></li>
                                                <li><a href="#">{{ language('3') }}</a></li>
                                                <li><a href="#">{{ language('4') }}</a></li>
                                                <li><a href="#">{{ language('Next') }} <i class="fas fa-angle-right"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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

