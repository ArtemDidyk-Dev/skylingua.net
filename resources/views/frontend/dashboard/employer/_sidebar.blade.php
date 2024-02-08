
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
    <div  class="settings-menu settings-menu-container">
        <ul>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.employer') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">verified_user</i> {{ language('frontend.dashboard.dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.employer.projects-all') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.projects-all',
                                                        'frontend.dashboard.employer.projects-pending',
                                                        'frontend.dashboard.employer.projects-ongoing',
                                                        'frontend.dashboard.employer.projects-completed',
                                                        'frontend.dashboard.employer.projects-cancelled',
                                                        'frontend.dashboard.employer.project.proposals',
                                                        'frontend.dashboard.employer.projects-add',
                                                        'frontend.dashboard.employer.projects-edit',
                                                        'frontend.dashboard.employer.employerProjectAdd',
                                                        'frontend.dashboard.employer.employerProjectEdit',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">business_center</i> {{ language('frontend.dashboard.projects') }}
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
                <a href="{{ route('frontend.dashboard.employer.favourites') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.favourites',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">local_play</i> {{ language('frontend.dashboard.favourites') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.employer.review') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.review',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">record_voice_over</i> {{ language('frontend.dashboard.reviews') }}
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
{{--                <a href="{{ route('frontend.dashboard.employer.membership-plans') }}" class="nav-link{{ Route::is(--}}
{{--                                                        [--}}
{{--                                                        'frontend.dashboard.employer.membership-plans',--}}
{{--                                                        ]--}}
{{--                                                        )? " active" : "" }}">--}}
{{--                    <i class="material-icons">person_add</i> {{ language('frontend.dashboard.membership') }}--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('frontend.dashboard.employer.milestones') }}" class="nav-link{{ Route::is(--}}
{{--                                                        [--}}
{{--                                                        'frontend.dashboard.employer.milestones',--}}
{{--                                                        ]--}}
{{--                                                        )? " active" : "" }}">--}}
{{--                    <i class="material-icons">pie_chart</i> {{ language('frontend.dashboard.milestones') }}--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a href="{{ route('frontend.dashboard.employer.verify-identity') }}" class="nav-link{{ Route::is(--}}
{{--                                                        [--}}
{{--                                                        'frontend.dashboard.employer.verify-identity',--}}
{{--                                                        ]--}}
{{--                                                        )? " active" : "" }}">--}}
{{--                    <i class="material-icons">person_pin</i> {{ language('frontend.dashboard.verify_identity') }}--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.employer.deposit-funds') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.deposit-funds',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">wifi_tethering</i> {{ language('frontend.dashboard.payments') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.dashboard.employer.profile-settings') }}" class="nav-link{{ Route::is(
                                                        [
                                                        'frontend.dashboard.employer.profile-settings',
                                                        ]
                                                        )? " active" : "" }}">
                    <i class="material-icons">settings</i> {{ language('frontend.dashboard.settings') }}
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
