
<nav class="user-tabs mb-4">
    <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.profile-settings',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.freelancer.profile-settings') }}">{{ language('Profile Settings') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.change-password',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.change-password') }}">{{ language('Change Password') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.delete-account',
                                                        ]
                                                        )? " active" : "" }}" href="{{ route('frontend.dashboard.delete-account') }}">{{ language('Delete Account') }}</a>
        </li>
    </ul>
</nav>
