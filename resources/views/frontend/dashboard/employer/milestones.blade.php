@extends('frontend.layouts.index')

@section('title',empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') : language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords') )
@section('description',language('frontend.dashboard.description') )


@section('content')
    <div class="bread-crumb-bar">

    </div>

    <!-- Page Content -->
    <div class="content content-page">
        <div class="container-fluid">
            <div class="row">

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.employer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <nav class="user-tabs mb-4">
                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                            <li class="nav-item">
                                <a class="nav-link" href="view-project-detail.html">{{ language('Overview & Discussions') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="milestones.html">{{ language('Milestones') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tasks.html">{{ language('Tasks') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="files.html">{{ language('Files') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="project-payment.html">{{ language('Payments') }}</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="my-projects-view">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="">
                                    <div class="card ">
                                        <div class="card-header">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col">
                                                    <h5 class="card-title">{{ language('Milestone') }}</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <a data-bs-toggle="modal" href="#file" class="btn btn-primary btn-rounded"><i class="fas fa-plus"></i>{{ language('Add Milestone') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive table-box">
                                                <table class="table table-center table-hover datatable">
                                                    <thead class="thead-pink">
                                                    <tr>
                                                        <th>{{ language('Name') }}</th>
                                                        <th>{{ language('Budget') }}</th>
                                                        <th>{{ language('Progress') }}</th>
                                                        <th>{{ language('Start Date') }}</th>
                                                        <th>{{ language('End Date') }}</th>
                                                        <th>{{ language('Paid') }}</th>
                                                        <th>{{ language('Action') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{ language('Research') }}</td>
                                                        <td>{{ language('$60') }}</td>
                                                        <td>
                                                            <p class="mb-0 orange-text text-center">{{ language('25%') }}</p>
                                                            <div class="progress progress-md mb-0">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>{{ language('20th October 2021') }}</td>
                                                        <td>{{ language('31th October 2021') }}</td>
                                                        <td><span class="badge badge-pill bg-success-dark">{{ language('Paid') }}</span></td>
                                                        <td><a href="javascript:void(0);"><span class="badge badge-pill bg-grey-light">{{ language('Pay now') }}</span></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Design</td>
                                                        <td>$60</td>
                                                        <td>
                                                            <p class="mb-0 orange-text text-center">{{ language('50%') }}</p>
                                                            <div class="progress progress-md mb-0">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>{{ language('02th October 2021') }}</td>
                                                        <td>{{ language('31th October 2021') }}</td>
                                                        <td><span class="badge badge-pill bg-success-dark">{{ language('Paid') }}</span></td>
                                                        <td><a href="javascript:void(0);"><span class="badge badge-pill bg-pink-dark">{{ language('Pay now') }}</span></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ language('Research') }}</td>
                                                        <td>{{ language('$60') }}</td>
                                                        <td>
                                                            <p class="mb-0 orange-text text-center">{{ language('75%') }}</p>
                                                            <div class="progress progress-md mb-0">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>{{ language('05th October 2021') }}</td>
                                                        <td>{{ language('12th October 2021') }}</td>
                                                        <td><span class="badge badge-pill bg-grey-dark">{{ language('UnPaid') }}</span></td>
                                                        <td><a href="javascript:void(0);"><span class="badge badge-pill bg-pink-dark">{{ language('Pay now') }}</span></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ language('Development') }}</td>
                                                        <td>{{ language('$50') }}</td>
                                                        <td>
                                                            <p class="mb-0 orange-text text-center">{{ language('60%') }}</p>
                                                            <div class="progress progress-md mb-0">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>{{ language('15th October 2021') }}</td>
                                                        <td>{{ language('18th October 2021') }}</td>
                                                        <td><span class="badge badge-pill bg-grey-dark">{{ language('UnPaid') }}</span></td>
                                                        <td><a href="javascript:void(0);"><span class="badge badge-pill bg-pink-dark">{{ language('Pay now') }}</span></a></td>
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
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')
@endsection

@section('JS')
@endsection

