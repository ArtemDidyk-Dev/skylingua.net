<div class="settings-widget">
    <div class="settings-header d-flex justify-content-between">
        <div class="d-flex align-self-center">
            <a href="{{ route('frontend.profile.index', $user->id) }}"><img alt="profile image" src="{{ !empty($user->profile_photo) ? asset('storage/profile/'. $user->profile_photo) : asset('storage/no-photo.jpg') }}" class="avatar-lg rounded-circle"></a>
            <div class="ms-2 mt-2 mt-md-1">
                <p class="mb-1">{{ language('frontend.dashboard.welcome') }},</p>
                <h3 class="mb-0"><a href="{{ route('frontend.profile.index', $user->id) }}">{{ auth()->user()->name }}</a></h3>
    {{--            <p class="mb-0">@georgewell</p>--}}

    {{--            <div class="notification-header-2" style="display: none !important;">--}}
    {{--                <a href="{{ route('frontend.cabinet.notification') }}" >--}}
    {{--                    <i class="far fa-bell"></i>--}}
    {{--                    <!--  bg-grey class olmasa tema rengi olacaq-->--}}
    {{--                    <!--                                        <span class="bg-grey">0</span>-->--}}
    {{--                    <span>{{ $notification_count }}</span>--}}
    {{--                </a>--}}
    {{--            </div>--}}
            </div>
        </div>
        <div class="menu-bar-icon align-self-center" data-show="0"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </div>
    <div class="settings-menu settings-menu-container">
        <ul>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">verified_user</i> {{ language('frontend.dashboard.dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer.project-proposals') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.project-proposals',
                                                        'frontend.dashboard.freelancer.project-ongoing',
                                                        'frontend.dashboard.freelancer.project-completed',
                                                        'frontend.dashboard.freelancer.project-cancelled',
                                                        'frontend.dashboard.freelancer.project-detail',
                                                        'frontend.dashboard.freelancer.project-hireds',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">business_center</i> {{ language('Courses') }}
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('frontend.cabinet.notification') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.cabinet.notification',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">notifications</i> {{ language('frontend.dashboard.notifications') }}
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer.reviews') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.reviews',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">record_voice_over</i> {{ language('frontend.dashboard.reviews') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer.portfolio') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.portfolio',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">pie_chart</i> {{ language('frontend.dashboard.portfolio') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.chats') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.chats',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">chat</i> {{ language('frontend.dashboard.messages') }}
                    <span class="message-sidebar badge bgg-yellow badge-pill ms-1" @if($message_count == 0) style="display: none" @endif >{{ $message_count }}</span>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('frontend.dashboard.freelancer.membership') }}" class="nav-link{{ Route::is(--}}
{{--                                                        [--}}
{{--                                                        'frontend.dashboard.freelancer.membership',--}}
{{--                                                        ]--}}
{{--                                                        )? " active" : "" }}">--}}
{{--                    <i class="material-icons">person_add</i> {{ language('frontend.dashboard.membership') }}--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('frontend.dashboard.freelancer.verify-identity') }}" class="nav-link{{ Route::is(--}}
{{--                                                        [--}}
{{--                                                        'frontend.dashboard.freelancer.verify-identity',--}}
{{--                                                        ]--}}
{{--                                                        )? " active" : "" }}">--}}
{{--                    <i class="material-icons">person_pin</i> {{ language('frontend.dashboard.verify_identity') }}--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer.withdraw-money') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.withdraw-money',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">wifi_tethering</i> {{ language('frontend.dashboard.payments') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer.profile-settings') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.profile-settings',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">settings</i>  {{ language('frontend.dashboard.settings') }}
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.subscribers') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.subscribers',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">record_voice_over</i>  {{ language('My subscription') }}
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.freelancer.courses') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.freelancer.courses',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">pie_chart</i> My courses
                </a>
            </li>


            <li class="nav-item">
                <a href="javascript:void(0)" onclick="document.getElementById('formLogout').submit()" class="nav-link">
                    <i class="material-icons">power_settings_new</i> {{ language('frontend.dashboard.logout') }}
                </a>
            </li>
        </ul>
    </div>
</div>
