<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__logo">
                <a href="{{ route('frontend.home.index') }}" class="header__logo-img">
                    <img width="78" height="36" src="{{ asset('build/website/images/logo.png') }}"
                    alt="logo">
                </a>
            </div>
            <div class="header__left">
                <nav>
                    <ul class="header__menu">
                        {!! $headerMenu !!}
                        @if (auth()->check())
                            <div class="header-btns">
                                <a href="{{ route('frontend.dashboard.chats') }}" class="header-message">
                                    <img src="{{ asset('build/website/images/icons/contacts-email.svg') }}"
                                        alt="{{ language('general.title') }}">
                                    <span
                                        @if ($message_count == 0) class="bg-grey" @endif>{{ $message_count }}</span>
                                </a>
                                <a href="{{ route('frontend.cabinet.notification') }}" class="header-message bell">
                                    <img width="24" height="24"
                                        src="{{ asset('build/website/images/icons/icons8-bell-96.svg') }}"
                                        alt="{{ language('general.title') }}">
                                    <span
                                        @if ($notification_count == 0) class="bg-grey" @endif>{{ $notification_count }}</span>
                                </a>

                            </div>
                            <div class="header-profile">
                                <div class="header-profile__wrapper">
                                    <span class="user-img">
                                        <img src="{{ !empty(auth()->user()->profile_photo) ? asset('storage/profile/' . auth()->user()->profile_photo) : asset('storage/no-photo.jpg') }}"
                                            alt="{{ auth()->user()->name }}">
                                    </span>
                                    <span class="header-user-name">{{ auth()->user()->name }}</span>
                                </div>
                                <div class="dropdown-menu">
                                    <div class="drop-head">{{ language('frontend.common.account_details') }}</div>
                                    <a class="dropdown-item" href="{{ route('frontend.dashboard.index') }}">
                                        {{ language('frontend.common.dashboard') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('frontend.profile.index', auth()->id()) }}">
                                        {{ language('frontend.common.view_profile') }}</a>
                                    @if (\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                        <a class="dropdown-item"
                                            href="{{ route('frontend.dashboard.employer.profile-settings') }}">
                                            {{ language('frontend.common.profile_settings') }}</a>
                                    @elseif(\App\Services\CommonService::userRoleId(auth()->id()) == 4)
                                        <a class="dropdown-item"
                                            href="{{ route('frontend.dashboard.freelancer.profile-settings') }}">
                                            {{ language('frontend.common.profile_settings') }}</a>
                                    @endif
                                    <a class="dropdown-item" href="javascript:void(0)"
                                        onclick="document.getElementById('formLogout').submit()">
                                        {{ language('frontend.common.logout') }}</a>
                                    <form id="formLogout" action="{{ route('frontend.login.logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                        <div class="header-btns no-auth">
                            <x-inc.btns.auth href="{{ route('frontend.login.index') }}"
                                title="{{ language('frontend.common.login') }}" class="login">
                                <svg width="18" height="18" viewBox="0 0 18 18" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.5 6.56757V11.4324C0.5 13.7258 0.5 14.8724 1.22162 15.5849C1.87718 16.2321 2.89572 16.2913 4.81827 16.2968C4.81303 16.262 4.80803 16.2271 4.80324 16.192C4.68837 15.3484 4.68839 14.2759 4.68841 12.9453V12.8919C4.68841 12.4889 5.01933 12.1622 5.42754 12.1622C5.83575 12.1622 6.16667 12.4889 6.16667 12.8919C6.16667 14.2885 6.16824 15.2626 6.26832 15.9975C6.36554 16.7114 6.54337 17.0895 6.81613 17.3588C7.0889 17.6281 7.4718 17.8037 8.195 17.8996C8.9394 17.9985 9.926 18 11.3406 18H12.3261C13.7407 18 14.7273 17.9985 15.4717 17.8996C16.1948 17.8037 16.5778 17.6281 16.8505 17.3588C17.1233 17.0895 17.3011 16.7114 17.3983 15.9975C17.4984 15.2626 17.5 14.2885 17.5 12.8919V5.10811C17.5 3.71149 17.4984 2.73743 17.3983 2.0025C17.3011 1.28855 17.1233 0.91048 16.8505 0.6412C16.5778 0.37192 16.1948 0.19635 15.4717 0.10036C14.7273 0.00154991 13.7407 0 12.3261 0H11.3406C9.926 0 8.9394 0.00154991 8.195 0.10036C7.4718 0.19635 7.0889 0.37192 6.81613 0.6412C6.54337 0.91048 6.36554 1.28855 6.26832 2.0025C6.16824 2.73743 6.16667 3.71149 6.16667 5.10811C6.16667 5.51113 5.83575 5.83784 5.42754 5.83784C5.01933 5.83784 4.68841 5.51113 4.68841 5.10811V5.05472C4.68839 3.72409 4.68837 2.65156 4.80324 1.80803C4.80803 1.77288 4.81303 1.73795 4.81827 1.70325C2.89572 1.70867 1.87718 1.76792 1.22162 2.41515C0.5 3.12759 0.5 4.27425 0.5 6.56757ZM10.385 11.9484L12.8487 9.516C13.1374 9.231 13.1374 8.769 12.8487 8.484L10.385 6.05157C10.0963 5.76659 9.6283 5.76659 9.3397 6.05157C9.051 6.33655 9.051 6.79859 9.3397 7.0836L10.5417 8.2703H3.45652C3.04831 8.2703 2.71739 8.597 2.71739 9C2.71739 9.403 3.04831 9.7297 3.45652 9.7297H10.5417L9.3397 10.9164C9.051 11.2014 9.051 11.6635 9.3397 11.9484C9.6283 12.2334 10.0963 12.2334 10.385 11.9484Z"
                                         />
                                </svg>
                            </x-inc.btns.auth>
                            <x-inc.btns.auth href="{{ route('frontend.login.index') }}"
                                title="{{ language('frontend.common.list') }}" class="list">
                                <svg width="22" height="22" viewBox="0 0 22 22"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.9999 20.1663C6.67871 20.1663 4.5181 20.1663 3.17568 18.8239C1.83325 17.4815 1.83325 15.3208 1.83325 10.9997C1.83325 6.67846 1.83325 4.51786 3.17568 3.17544C4.5181 1.83301 6.67871 1.83301 10.9999 1.83301C15.3211 1.83301 17.4818 1.83301 18.8241 3.17544C20.1666 4.51786 20.1666 6.67846 20.1666 10.9997C20.1666 15.3208 20.1666 17.4815 18.8241 18.8239C17.4818 20.1663 15.3211 20.1663 10.9999 20.1663ZM10.9999 7.56217C11.3796 7.56217 11.6874 7.86998 11.6874 8.24967V10.3122H13.7499C14.1296 10.3122 14.4374 10.62 14.4374 10.9997C14.4374 11.3794 14.1296 11.6872 13.7499 11.6872H11.6874V13.7497C11.6874 14.1294 11.3796 14.4372 10.9999 14.4372C10.6202 14.4372 10.3124 14.1294 10.3124 13.7497V11.6872H8.24992C7.87023 11.6872 7.56242 11.3794 7.56242 10.9997C7.56242 10.62 7.87023 10.3122 8.24992 10.3122H10.3124V8.24967C10.3124 7.86998 10.6202 7.56217 10.9999 7.56217Z" />
                                </svg>
                            </x-inc.btns.auth>
                        </div>
                        @endif
                    </ul>
                </nav>
            </div>
            <div class="header__right">
                @if (auth()->check())
                    <div class="header-btns">
                        <a href="{{ route('frontend.dashboard.chats') }}" class="header-message">
                            <img src="{{ asset('build/website/images/icons/contacts-email.svg') }}"
                                alt="{{ language('general.title') }}">
                            <span @if ($message_count == 0) class="bg-grey" @endif>{{ $message_count }}</span>
                        </a>
                        <a href="{{ route('frontend.cabinet.notification') }}" class="header-message bell">
                            <img width="24" height="24"
                                src="{{ asset('build/website/images/icons/icons8-bell-96.svg') }}"
                                alt="{{ language('general.title') }}">
                            <span
                                @if ($notification_count == 0) class="bg-grey" @endif>{{ $notification_count }}</span>
                        </a>

                    </div>
                    <div class="header-profile">
                        <div class="header-profile__wrapper">
                            <span class="user-img">
                                <img src="{{ !empty(auth()->user()->profile_photo) ? asset('storage/profile/' . auth()->user()->profile_photo) : asset('storage/no-photo.jpg') }}"
                                    alt="{{ auth()->user()->name }}">
                            </span>
                            <span class="header-user-name">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="drop-head">{{ language('frontend.common.account_details') }}</div>
                            <a class="dropdown-item" href="{{ route('frontend.dashboard.index') }}">
                                {{ language('frontend.common.dashboard') }}</a>
                            <a class="dropdown-item" href="{{ route('frontend.profile.index', auth()->id()) }}">
                                {{ language('frontend.common.view_profile') }}</a>
                            @if (\App\Services\CommonService::userRoleId(auth()->id()) == 3)
                                <a class="dropdown-item"
                                    href="{{ route('frontend.dashboard.employer.profile-settings') }}">
                                    {{ language('frontend.common.profile_settings') }}</a>
                            @elseif(\App\Services\CommonService::userRoleId(auth()->id()) == 4)
                                <a class="dropdown-item"
                                    href="{{ route('frontend.dashboard.freelancer.profile-settings') }}">
                                    {{ language('frontend.common.profile_settings') }}</a>
                            @endif
                            <a class="dropdown-item" href="javascript:void(0)"
                                onclick="document.getElementById('formLogout').submit()">
                                {{ language('frontend.common.logout') }}</a>
                            <form id="formLogout" action="{{ route('frontend.login.logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <div class="header-btns no-auth">
                        <x-inc.btns.auth href="{{ route('frontend.login.index') }}"
                            title="{{ language('frontend.common.login') }}" class="login">
                            <svg width="18" height="18" viewBox="0 0 18 18" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.5 6.56757V11.4324C0.5 13.7258 0.5 14.8724 1.22162 15.5849C1.87718 16.2321 2.89572 16.2913 4.81827 16.2968C4.81303 16.262 4.80803 16.2271 4.80324 16.192C4.68837 15.3484 4.68839 14.2759 4.68841 12.9453V12.8919C4.68841 12.4889 5.01933 12.1622 5.42754 12.1622C5.83575 12.1622 6.16667 12.4889 6.16667 12.8919C6.16667 14.2885 6.16824 15.2626 6.26832 15.9975C6.36554 16.7114 6.54337 17.0895 6.81613 17.3588C7.0889 17.6281 7.4718 17.8037 8.195 17.8996C8.9394 17.9985 9.926 18 11.3406 18H12.3261C13.7407 18 14.7273 17.9985 15.4717 17.8996C16.1948 17.8037 16.5778 17.6281 16.8505 17.3588C17.1233 17.0895 17.3011 16.7114 17.3983 15.9975C17.4984 15.2626 17.5 14.2885 17.5 12.8919V5.10811C17.5 3.71149 17.4984 2.73743 17.3983 2.0025C17.3011 1.28855 17.1233 0.91048 16.8505 0.6412C16.5778 0.37192 16.1948 0.19635 15.4717 0.10036C14.7273 0.00154991 13.7407 0 12.3261 0H11.3406C9.926 0 8.9394 0.00154991 8.195 0.10036C7.4718 0.19635 7.0889 0.37192 6.81613 0.6412C6.54337 0.91048 6.36554 1.28855 6.26832 2.0025C6.16824 2.73743 6.16667 3.71149 6.16667 5.10811C6.16667 5.51113 5.83575 5.83784 5.42754 5.83784C5.01933 5.83784 4.68841 5.51113 4.68841 5.10811V5.05472C4.68839 3.72409 4.68837 2.65156 4.80324 1.80803C4.80803 1.77288 4.81303 1.73795 4.81827 1.70325C2.89572 1.70867 1.87718 1.76792 1.22162 2.41515C0.5 3.12759 0.5 4.27425 0.5 6.56757ZM10.385 11.9484L12.8487 9.516C13.1374 9.231 13.1374 8.769 12.8487 8.484L10.385 6.05157C10.0963 5.76659 9.6283 5.76659 9.3397 6.05157C9.051 6.33655 9.051 6.79859 9.3397 7.0836L10.5417 8.2703H3.45652C3.04831 8.2703 2.71739 8.597 2.71739 9C2.71739 9.403 3.04831 9.7297 3.45652 9.7297H10.5417L9.3397 10.9164C9.051 11.2014 9.051 11.6635 9.3397 11.9484C9.6283 12.2334 10.0963 12.2334 10.385 11.9484Z"
                                     />
                            </svg>
                        </x-inc.btns.auth>
                        <x-inc.btns.auth href="{{ route('frontend.login.index') }}"
                            title="{{ language('frontend.common.list') }}" class="list">
                            <svg width="22" height="22" viewBox="0 0 22 22"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.9999 20.1663C6.67871 20.1663 4.5181 20.1663 3.17568 18.8239C1.83325 17.4815 1.83325 15.3208 1.83325 10.9997C1.83325 6.67846 1.83325 4.51786 3.17568 3.17544C4.5181 1.83301 6.67871 1.83301 10.9999 1.83301C15.3211 1.83301 17.4818 1.83301 18.8241 3.17544C20.1666 4.51786 20.1666 6.67846 20.1666 10.9997C20.1666 15.3208 20.1666 17.4815 18.8241 18.8239C17.4818 20.1663 15.3211 20.1663 10.9999 20.1663ZM10.9999 7.56217C11.3796 7.56217 11.6874 7.86998 11.6874 8.24967V10.3122H13.7499C14.1296 10.3122 14.4374 10.62 14.4374 10.9997C14.4374 11.3794 14.1296 11.6872 13.7499 11.6872H11.6874V13.7497C11.6874 14.1294 11.3796 14.4372 10.9999 14.4372C10.6202 14.4372 10.3124 14.1294 10.3124 13.7497V11.6872H8.24992C7.87023 11.6872 7.56242 11.3794 7.56242 10.9997C7.56242 10.62 7.87023 10.3122 8.24992 10.3122H10.3124V8.24967C10.3124 7.86998 10.6202 7.56217 10.9999 7.56217Z" />
                            </svg>
                        </x-inc.btns.auth>
                    </div>
                @endif
            </div>
            <div class="header__burger">
                <div class="header__burger-line"></div>
                <div class="header__burger-line"></div>
                <div class="header__burger-line"></div>
            </div>
        </div>
    </div>
</header>
