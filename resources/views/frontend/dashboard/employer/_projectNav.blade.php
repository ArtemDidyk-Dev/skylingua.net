<nav class="user-tabs project-tabs">
    <ul class="nav nav-tabs nav-tabs-bottom nav-justified" id="projectsNav">
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.projects-all',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.employer.projects-all') }}">
                {{ language('All Services') }}
                <div class="badge bgg-yellow badge-pill ms-1 allProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.projects-pending',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.employer.projects-pending') }}">
                {{ language('Pending Services') }}
                <div class="badge bgg-yellow badge-pill ms-1 pendingProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.projects-ongoing',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.employer.projects-ongoing') }}">
                {{ language('Ongoing Services') }}
                <div class="badge bgg-yellow badge-pill ms-1 ongoingProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.projects-completed',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.employer.projects-completed') }}">
                {{ language('Completed Services') }}
                <div class="badge bgg-yellow badge-pill ms-1 completedProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.projects-cancelled',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.employer.projects-cancelled') }}">
                {{ language('Cancelled Services') }}
                <div class="badge bgg-yellow badge-pill ms-1 cancelledProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
    </ul>
</nav>
