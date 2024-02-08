
<nav class="user-tabs mb-4">
    <ul class="nav nav-tabs nav-tabs-bottom nav-justified" id="projectsNav">
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.project-proposals',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.project-proposals') }}">
                {{ language('My Proposals') }}
                <div class="badge bgg-yellow badge-pill ms-1 myProposals" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.project-hireds',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.project-hireds') }}">
                {{ language('Hireds Projects') }}
                <div class="badge bgg-yellow badge-pill ms-1 hiredsProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.project-ongoing',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.project-ongoing') }}">
                {{ language('Ongoing Projects') }}
                <div class="badge bgg-yellow badge-pill ms-1 ongoingProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.project-completed',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.project-completed') }}">
                {{ language('Completed Projects') }}
                <div class="badge bgg-yellow badge-pill ms-1 completedProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.project-cancelled',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.project-cancelled') }}">
                {{ language('Cancelled Projects') }}
                <div class="badge bgg-yellow badge-pill ms-1 cancelledProjects" style="vertical-align: top; display: none">0</div>
            </a>
        </li>
    </ul>
</nav>
