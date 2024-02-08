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

                <!-- sidebar -->
                <div class="col-xl-3 col-md-4 theiaStickySidebar">
                    @include('frontend.dashboard.freelancer._sidebar', ['user' => $user])
                </div>
                <!-- /sidebar -->

                <div class="col-xl-9 col-md-8">
                    <div class="page-title">
                        <h3>{{ language('Access') }}</h3>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('message'))
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                            <ul>
                                <li>{{ session()->get('message') }}</li>
                            </ul>
                        </div>
                    @endif

                    <!-- Proposals list -->
                    <div class="proposals-section">
                        <h3 class="page-subtitle">{{ language('Give Access') }}</h3>

                        @if ($users)
                            @foreach ($users as $user)
                                <!-- Proposals -->
                                <div class="freelancer-proposals">
                                    <div class="project-proposals align-items-center freelancer">
                                        <div class="proposals-info">
                                            <div class="proposals-detail">
                                                <h3 class="proposals-title">
                                                    <a
                                                        href="{{ route('frontend.profile.index', $user->id) }}">{{ $user->name }}</a>
                                                </h3>
                                                <div class="proposals-content">
                                                    <div class="proposal-img">
                                                        <div class="text-md-center">
                                                            <a href="{{ route('frontend.profile.index', $user->id) }}"
                                                                target="_blank">
                                                                <img src="{{ $user->profile_photo ? asset('storage/profile/' . $user->profile_photo) : asset('storage/no-photo.jpg') }}"
                                                                    alt="{{ $user->name }}" class="img-fluid">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="description-proposal">
                                            @foreach ($user->projects as $project)
                                                <h4 class="project">
                                                    <a
                                                        href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a>
                                                </h4>
                                                <div class="accordion">
                                                    @foreach ($project->services as $service)
                                                        <div class="accordion-item">
                                                            <div class="accordion-title">{{ $service->name }}</div>
                                                            <div class="accordion-content">
                                                                <div class="form-container-accets">
                                                                    <form method="POST"
                                                                        action="{{ route('frontend.dashboard.access.send', [$user, $service, $project]) }}">
                                                                        @csrf
                                                                        <p>Service Name: {{ $service->name }}</p>
                                                                        <label for="login">Login:</label>
                                                                        <input type="text" name="login">
                                                                        <label for="password">Password:</label>
                                                                        <input type="password" name="password">
                                                                        <input type="hidden" name="service"
                                                                            value="{{ $service->name }}">
                                                                        <button type="submit">Send Access</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <!-- Proposals -->
                            @endforeach
                        @else
                            <p>{{ language('No Result') }}</p>
                        @endif


                    </div>
                    <!-- /Proposals list -->


                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->



    <!-- /The deleteModal -->


    <!-- The Modal -->

    <!-- /The Modal -->

@endsection


@section('CSS')
    <style>
        .project {
            margin-top: 10px;
        }

        .acces__item+.acces__item {
            margin-top: 10px;
        }

        /* Style for the accordion container */
        .accordion {
            max-width: 600px;
        }

        /* Style for each accordion item */
        .accordion-item {
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }

        /* Hide the checkbox input */
        .accordion-trigger {
            display: none;
        }

        /* Style for the accordion title */
        .accordion-title {
            display: block;
            padding: 10px;
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Style for the accordion content */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        /* Show the content when the checkbox is checked */
        .accordion-trigger:checked+.accordion-title+.accordion-content {
            max-height: 500px;
            /* Adjust as needed */
        }

        /* Style for form elements */
        .form-container-accets form {
            padding: 10px;
        }

        .form-container-accets form label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container-accets {
            max-width: 400px;
        }

        /* Style for form elements */
        .form-container-accets form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .form-container-accets form label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .form-container-accets form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container-accets form button {
            background: var(--color-blue);
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container-accets form button:hover {
            background: var(--color-blue);
        }

        .accordion-content.active  {
            max-height: 100%;
            overflow: visible;
        }
    </style>
@endsection

@section('JS')
    <script>
        const accordionItmes = document.querySelectorAll('.accordion-title');
        const accordionContent = document.querySelectorAll('.accordion-content');
        accordionItmes.forEach((element, index) => {
            element.addEventListener('click', () => {
                accordionContent[index].classList.toggle('active');
            })
        });
    </script>


@endsection
