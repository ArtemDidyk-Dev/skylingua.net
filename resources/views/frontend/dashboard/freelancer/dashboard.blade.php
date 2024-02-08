@extends('frontend.layouts.index')

@section('title', empty(language('frontend.dashboard.title')) ? language('frontend.dashboard.name') :
    language('frontend.dashboard.title'))
@section('keywords', language('frontend.dashboard.keywords'))
@section('description', language('frontend.dashboard.description'))


@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>

                <div class="col-xl-9 col-md-8">
                    <div class="dashboard-sec">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="dash-widget">
                                    <div class="dash-info">
                                        <div class="dash-widget-info">{{ language('Cancelled Projects') }}</div>
                                        <div class="dash-widget-count">{{ $projects_count['myProposals'] }}</div>
                                    </div>
                                    <div class="dash-widget-more">
                                        <a href="{{ route('frontend.dashboard.freelancer.project-proposals') }}"
                                            class="d-flex">{{ language('View Details') }} <i
                                                class="fas fa-arrow-right ms-auto"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="dash-widget">
                                    <div class="dash-info">
                                        <div class="dash-widget-info">{{ language('Ongoing Projects') }}</div>
                                        <div class="dash-widget-count">{{ $projects_count['ongoingProjects'] }}</div>
                                    </div>
                                    <div class="dash-widget-more">
                                        <a href="{{ route('frontend.dashboard.freelancer.project-ongoing') }}"
                                            class="d-flex">{{ language('View Details') }} <i
                                                class="fas fa-arrow-right ms-auto"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="dash-widget">
                                    <div class="dash-info">
                                        <div class="dash-widget-info">{{ language('Completed Projects') }}</div>
                                        <div class="dash-widget-count">{{ $projects_count['completedProjects'] }}</div>
                                    </div>
                                    <div class="dash-widget-more">
                                        <a href="{{ route('frontend.dashboard.freelancer.project-completed') }}"
                                            class="d-flex">{{ language('View Details') }} <i
                                                class="fas fa-arrow-right ms-auto"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart Content -->
                        <div class="row">
                            <div class="col-xl-8 d-flex">
                                <div class="card flex-fill">
                                    <div class="pro-head">
                                        <h5 class="card-title mb-0">{{ language('Your Profile View') }}</h5>
                                        <div class="month-detail">
                                            <select class="form-control">
                                                <option value="0">{{ language('Last 6 months') }}</option>
                                                <option value="1">{{ language('Last 2 months') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pro-body">
                                        <div id="chartProjects"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 d-flex">
                                <div class="flex-fill card">
                                    <div class="pro-head b-0">
                                        <h5 class="card-title mb-0">{{ language('Static Analytics') }}</h5>
                                    </div>
                                    <div class="pro-body">
                                        <div id="chartAnalytics"></div>
                                        <ul class="static-list">
                                            <li><span><i class="fas fa-circle text-warning me-1"></i>
                                                    {{ language('My Proposals') }}</span>
                                                <span class="sta-count">{{ $projects_count['myProposals'] }}</span>
                                            </li>
                                            <li><span><i class="fas fa-circle text-primary me-1"
                                                        style="color: #0dcaf0 !important;"></i>
                                                    {{ language('Ongoing Projects') }}</span>
                                                <span class="sta-count">{{ $projects_count['ongoingProjects'] }}</span>
                                            </li>
                                            <li><span><i class="fas fa-circle text-success me-1"></i>
                                                    {{ language('Completed Projects') }}</span>
                                                <span class="sta-count">{{ $projects_count['completedProjects'] }}</span>
                                            </li>
                                            <li><span><i
                                                        class="fas fa-circle text-danger me-1"></i>{{ language('Cancelled Projects') }}</span>
                                                <span class="sta-count">{{ $projects_count['cancelledProjects'] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Chart Content -->

                        <div class="row">


                            <!-- Hired Projects -->
                            <div class="col-xl-6 d-flex">
                                <div class="card flex-fill">
                                    <div class="pro-head">
                                        <h2>{{ language('Hired Projects') }}</h2>
                                        <a href="{{ route('frontend.dashboard.freelancer.project-hireds') }}"
                                            class="btn fund-btn">{{ language('View All') }}</a>
                                    </div>
                                    <div class="pro-body p-0">
                                        @if ($hired_projects)
                                            @foreach ($hired_projects as $hired_project)
                                                <div class="on-project">
                                                    <h5>
                                                        <a href="{{ route('frontend.project.detail', $hired_project->id) }}"
                                                            class="h5">{{ $hired_project->name }}</a>
                                                    </h5>
                                                    <div class="pro-info">
                                                        <ul class="list-details">
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Job Type') }}</p>
                                                                    <h5>
                                                                        @if ($hired_project->price_type == 1)
                                                                            {{ language('Fixed Price') }}
                                                                        @elseif($hired_project->price_type == 2)
                                                                            {{ language('Hourly Pricing') }}
                                                                        @else
                                                                            {{ language('Bidding Price') }}
                                                                        @endif
                                                                    </h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Project Price') }}</p>
                                                                    <h5>
                                                                        @if ($hired_project->price > 0)
                                                                            {{ $hired_project->price }}{{ language('frontend.currency') }}
                                                                        @else
                                                                            {{ language('Bidding Price') }}
                                                                        @endif
                                                                    </h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Location') }}</p>
                                                                    <h5>{{ $hired_project->user_country_name }}</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Expiry') }}</p>
                                                                    <h5>{{ \Carbon\Carbon::parse($hired_project->deadline)->format('M d, Y') }}
                                                                    </h5>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="m-4">{{ language('No Projects') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /Hired Projects -->

                            <!-- Ongoing Projects -->
                            <div class="col-xl-6 d-flex">
                                <div class="card flex-fill">
                                    <div class="pro-head">
                                        <h2>{{ language('Ongoing Projects') }}</h2>
                                        <a href="{{ route('frontend.dashboard.freelancer.project-ongoing') }}"
                                            class="btn fund-btn">{{ language('View All') }}</a>
                                    </div>
                                    <div class="pro-body p-0">
                                        @if ($projects)
                                            @foreach ($projects as $project)
                                                <div class="on-project">
                                                    <h5>
                                                        <a href="{{ route('frontend.project.detail', $project->id) }}"
                                                            class="h5">{{ $project->name }}</a>
                                                    </h5>
                                                    <div class="pro-info">
                                                        <ul class="list-details">
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Job Type') }}</p>
                                                                    <h5>
                                                                        @if ($project->price_type == 1)
                                                                            {{ language('Fixed Price') }}
                                                                        @elseif($project->price_type == 2)
                                                                            {{ language('Hourly Pricing') }}
                                                                        @else
                                                                            {{ language('Bidding Price') }}
                                                                        @endif
                                                                    </h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Project Price') }}</p>
                                                                    <h5>
                                                                        @if ($project->price > 0)
                                                                            {{ $project->price }}{{ language('frontend.currency') }}
                                                                        @else
                                                                            {{ language('Bidding Price') }}
                                                                        @endif
                                                                    </h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Location') }}</p>
                                                                    <h5>{{ $project->user_country_name }}</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="slot">
                                                                    <p>{{ language('Expiry') }}</p>
                                                                    <h5>{{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                                                                    </h5>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="m-4">{{ language('No Projects') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /Ongoing Projects -->
                        </div>

                        <!-- Past Earnings -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="pro-head">
                                        <h2>{{ language('Transaction History') }}</h2>
                                        <a href="{{ route('frontend.dashboard.freelancer.transaction-history') }}"
                                            class="btn fund-btn">{{ language('View All') }}</a>
                                    </div>
                                    <div class="pro-body p-0 history-wrapper">
                                        <table class="table">
                                            <thead>
                                                <tr class="thead-pink">
                                                    <th style="width: 100px;">{{ language('Detail') }}</th>
                                                    <th>{{ language('Transaction ID') }}</th>
                                                    <th>{{ language('Amount') }}</th>
                                                    <th>{{ language('Status') }}</th>
                                                    <th>{{ language('Paid On') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-hover table-center">

                                                @if ($pays)
                                                    @foreach ($pays as $pay)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('frontend.dashboard.freelancer.view-invoice', $pay->id) }}"
                                                                    class="invoice-id">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                            <td>{{ $pay->transactionId ? $pay->transactionId : '---' }}
                                                            </td>
                                                            <td>{{ price_format($pay->amount) }}</td>
                                                            <td>{!! $pay->status_text !!}</td>
                                                            <td>{{ $pay->date }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7">{{ language('No Transactions') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Past Earnings -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

@endsection


@section('CSS')

    <style>
        .history-wrapper {
            overflow-x: scroll; 
        }
        .history-wrapper .table {
            min-width: 760px;
        }
        .pro-head h2 {
            margin-bottom:  10px;
        }
    </style>

@endsection

@section('JS')
    <script>
        var optionsAnalytics = {
            series: [
                {{ $projects_percent['myProposals'] }},
                {{ $projects_percent['ongoingProjects'] }},
                {{ $projects_percent['completedProjects'] }},
                {{ $projects_percent['cancelledProjects'] }},
            ],
            chart: {
                toolbar: {
                    show: false
                },
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 5,
                        size: '50%',
                        background: 'transparent',
                        image: undefined,
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: false,
                        }
                    }
                }
            },
            colors: ['#ffc107', '#0dcaf0', '#198754', '#dc3545'],
            labels: ['Pending Projects', 'Ongoing Projects', 'Completed Projects', 'Cancelled Projects'],
            legend: {
                show: false,
                floating: true,
                fontSize: '16px',
                position: 'bottom',
                offsetX: 160,
                offsetY: 15,
                labels: {
                    useSeriesColors: true,
                },
                markers: {
                    size: 0
                },
                formatter: function(seriesName, opts) {
                    return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                },
                itemMargin: {
                    vertical: 3
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        show: false
                    }
                }
            }]
        };

        var chartAnalytics = new ApexCharts(document.querySelector("#chartAnalytics"), optionsAnalytics);
        chartAnalytics.render();

        var optionsProjects = {
            series: [{
                name: "Projects",
                data: [
                    @foreach ($mountly_counts as $mountly_count)
                        {{ $mountly_count }},
                    @endforeach
                ]
            }],
            chart: {
                height: 360,
                type: 'line',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ["#FF5B37"],
            stroke: {
                curve: 'straight',
                width: [1]
            },
            markers: {
                size: 4,
                colors: ["#FF5B37"],
                strokeColors: "#FF5B37",
                strokeWidth: 1,
                hover: {
                    size: 7,
                }
            },
            grid: {
                position: 'front',
                borderColor: '#ddd',
                strokeDashArray: 7,
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                lines: {
                    show: false,
                }
            },
            yaxis: {
                lines: {
                    show: true,
                }
            }
        };

        var chartProjects = new ApexCharts(document.querySelector("#chartProjects"), optionsProjects);
        chartProjects.render();
    </script>
@endsection
