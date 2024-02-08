<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__left">
                <a href="{{ route('frontend.home.index') }}" class="header__logo">
                    <img width="220" height="30" src="{{ asset('build/website/images/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="header__right">
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
                                <x-inc.btns.auth href="{{ route('frontend.cabinet.register') }}"
                                    title="{{ language('frontend.common.register') }}" />
                                <x-inc.btns.auth href="{{ route('frontend.login.index') }}"
                                    title="{{ language('frontend.common.login') }}" class="login">
                                    <svg width="20" height="20" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.83344 6.25016C5.83344 5.42608 6.07781 4.62049 6.53565 3.93529C6.99349 3.25008 7.64423 2.71603 8.40559 2.40067C9.16695 2.0853 10.0047 2.00279 10.813 2.16356C11.6212 2.32433 12.3637 2.72117 12.9464 3.30389C13.5291 3.88661 13.9259 4.62903 14.0867 5.43729C14.2475 6.24554 14.165 7.08332 13.8496 7.84468C13.5342 8.60604 13.0002 9.25678 12.315 9.71462C11.6298 10.1725 10.8242 10.4168 10.0001 10.4168C8.89544 10.4155 7.8364 9.9761 7.05529 9.19498C6.27417 8.41387 5.83476 7.35483 5.83344 6.25016ZM13.4309 11.3093C12.9607 11.1927 12.4638 11.2575 12.0393 11.491C11.4153 11.837 10.7136 12.0185 10.0001 12.0185C9.28664 12.0185 8.5849 11.837 7.96094 11.491C7.53631 11.2579 7.03952 11.193 6.56927 11.3093C5.75776 11.5186 5.0395 11.9931 4.52869 12.6575C4.01787 13.3219 3.74382 14.138 3.75011 14.976V15.8185C3.75021 16.3463 3.8921 16.8643 4.16094 17.3185C4.27269 17.502 4.43005 17.6535 4.61769 17.7582C4.80534 17.8629 5.01689 17.9173 5.23177 17.916H14.7684C14.9834 17.9173 15.195 17.8628 15.3827 17.758C15.5704 17.6531 15.7277 17.5014 15.8393 17.3177C16.1083 16.8636 16.2502 16.3455 16.2501 15.8177V14.9727C16.2556 14.1352 15.9813 13.3199 15.4705 12.6562C14.9597 11.9925 14.2419 11.5184 13.4309 11.3093Z" />
                                    </svg>
                                </x-inc.btns.auth>
                            </div>
                        @endif
                    </ul>
                </nav>
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
                        <x-inc.btns.auth href="{{ route('frontend.cabinet.register') }}"
                            title="{{ language('frontend.common.register') }}" />
                        <x-inc.btns.auth href="{{ route('frontend.login.index') }}"
                            title="{{ language('frontend.common.login') }}" class="login">
                            <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.83344 6.25016C5.83344 5.42608 6.07781 4.62049 6.53565 3.93529C6.99349 3.25008 7.64423 2.71603 8.40559 2.40067C9.16695 2.0853 10.0047 2.00279 10.813 2.16356C11.6212 2.32433 12.3637 2.72117 12.9464 3.30389C13.5291 3.88661 13.9259 4.62903 14.0867 5.43729C14.2475 6.24554 14.165 7.08332 13.8496 7.84468C13.5342 8.60604 13.0002 9.25678 12.315 9.71462C11.6298 10.1725 10.8242 10.4168 10.0001 10.4168C8.89544 10.4155 7.8364 9.9761 7.05529 9.19498C6.27417 8.41387 5.83476 7.35483 5.83344 6.25016ZM13.4309 11.3093C12.9607 11.1927 12.4638 11.2575 12.0393 11.491C11.4153 11.837 10.7136 12.0185 10.0001 12.0185C9.28664 12.0185 8.5849 11.837 7.96094 11.491C7.53631 11.2579 7.03952 11.193 6.56927 11.3093C5.75776 11.5186 5.0395 11.9931 4.52869 12.6575C4.01787 13.3219 3.74382 14.138 3.75011 14.976V15.8185C3.75021 16.3463 3.8921 16.8643 4.16094 17.3185C4.27269 17.502 4.43005 17.6535 4.61769 17.7582C4.80534 17.8629 5.01689 17.9173 5.23177 17.916H14.7684C14.9834 17.9173 15.195 17.8628 15.3827 17.758C15.5704 17.6531 15.7277 17.5014 15.8393 17.3177C16.1083 16.8636 16.2502 16.3455 16.2501 15.8177V14.9727C16.2556 14.1352 15.9813 13.3199 15.4705 12.6562C14.9597 11.9925 14.2419 11.5184 13.4309 11.3093Z" />
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

<style>
    .header {
        margin: 16px 23px 0px 23px;
        border-radius: 20px;
        background: var(--white, #FFF);
        box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.1);
        padding: 15px;
        margin: 0 auto;
        width: 100%;
        max-width: 1395px;
        margin-top: 16px;
        z-index: 2;
        position: relative;
        margin-bottom: 20px;
    }

    .header__menu li {
        list-style-type: none;
    }

    @media (max-width: 1440px) {
        .header {
            max-width: 100%;
            margin-left: 23px;
            margin-right: 23px;
            width: auto;
        }
    }

    @media (max-width: 1200px) {
        .header__logo {
            font-size: 21px;
            line-height: 0px;
        }

        .header__logo img {
            height: auto;
            max-width: 247px;
        }
    }

    @media (max-width: 405px) {
        .header__logo img {
            max-width: 182px;
        }
    }

    .header__logo {
        font-size: 24px;
        line-height: 22px;
        color: #B34D75;
        font-family: "Nunito";
        font-style: normal;
        font-weight: 800;

    }

    @media (max-width: 1200px) {
        .header__logo {
            font-size: 21px;
            line-height: 0px;
        }
    }

    .header__inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 992px) {
        .header__inner {
            flex-direction: column;
        }
    }

    .header__left {
        min-width: 130px;
        margin-right: auto;
    }

    .header__right {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .header__right nav {
        margin-left: auto;
    }

    .header__right nav ul {
        display: flex;
    }

    .header__right nav ul li {
        position: relative;
        color: #111;
    }

    .header__right nav ul li a {
        color: #111;
        font-size: 15px;
        line-height: 21px;
        transition: all 0.3s;
    }

    .header__right nav ul li a:hover {
        color: #B34D75;
        transition: all 0.3s;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .header__right nav ul li.has-submenu {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .header__right nav ul li.has-submenu:hover .arrow {
        transform: rotate(180deg);
    }

    .header__right nav ul li.has-submenu:hover .submenu {
        opacity: 1;
        z-index: 1;
        transition: all 0.3s;
    }

    .header__right nav ul li.has-submenu .arrow {
        background-image: url("/images/icons/arrow-hed.svg");
        position: absolute;
        right: -17px;
        width: 11px;
        height: 11px;
        background-size: contain;
        background-repeat: no-repeat;
        top: 8px;
        transition: all 0.3s;
    }

    .header__right nav ul li.has-submenu .submenu {
        display: flex;
        z-index: -2;
        opacity: 0;
        flex-direction: column;
        position: absolute;
        list-style-type: none;
        min-width: 215px;
        top: 32px;
        background: #B34D75;
        border-radius: 12px;
        padding: 10px;
        transition: all 0.3s;
    }

    .header__right nav ul li.has-submenu .submenu li+li {
        margin-left: 0px;
        margin-top: 10px;
    }

    .header__right nav ul li.has-submenu .submenu li {
        padding-bottom: 0px;
    }

    .header__right nav ul li.has-submenu .submenu li a {
        color: #FFF;
    }

    .header__right nav ul li.has-submenu .submenu li a:hover {
        color: #111;
    }

    @media (max-width: 992px) {
        .header__right nav ul li.has-submenu:hover .arrow {
            transform: none;
        }

        .header__right nav ul li.has-submenu .submenu {
            display: none;
        }

        .header__right nav ul li.has-submenu.active .arrow {
            transform: rotate(180deg);
        }

        .header__right nav ul li.has-submenu.active .submenu {
            display: flex;
        }
    }

    .header__right nav ul li+li {
        margin-left: 30px;
    }

    @media (max-width: 992px) {
        .header__right nav ul {
            display: none;
        }

        .header__right nav ul.active {
            border-radius: 20px;
            background: var(--white, #FFF);
            box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.1);
            display: flex;
            width: 100%;
            position: absolute;
            top: 67px;
            flex-direction: column;
            padding: 10px;
            z-index: 2;
            justify-content: flex-start;
            align-items: flex-start;
            left: 0px;
            background: #FFF;
        }

        .header__right nav ul.active li {
            width: auto;
            min-width: 115px;
        }

        .header__right nav ul.active li+li {
            margin-left: 0px;
            margin-top: 15px;
        }

        .header__right nav ul.active .header-btns {
            display: flex;
            justify-content: flex-start;
        }

        .header__right nav ul.active .header-profile,
        .header__right nav ul.active .header-profile__wrapper {
            display: flex;
        }

        .header__right nav ul.active .header-profile {
            justify-content: center;
            align-items: center;
            align-self: center;
        }
    }

    .header__right nav .header-btns,
    .header__right nav .header-profile,
    .header__right nav .header-profile__wrapper {
        display: none;
    }

    .header__right .header-btns {
        display: flex;
        margin-left: auto;
        align-items: center;
    }

    .header__right .header-btns.no-auth a {
        color: #B34D75;
        padding: 8px 24px;
        line-height: 24px;
        font-size: 14px;
        border-radius: 50px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .header__right .header-btns.no-auth a:hover {
        color: #FFF;
        background: #B34D75;
    }

    .header__right .header-btns.no-auth a:hover svg {
        fill: #B34D75;
    }

    @media (max-width: 992px) {
        .header__right .header-btns.no-auth a {
            padding: 4px 24px;
        }
    }

    .header__right .header-btns.no-auth a svg {
        margin-right: 4px;
        fill: #FFF;
        transition: all 0.3s;
    }

    .header__right .header-btns.no-auth a+a {
        color: #fff;
        margin-left: 20px;
        background: #B34D75;
    }

    .header__right .header-btns.no-auth a+a:hover {
        color: #B34D75;
        background: #fff;
    }

    .header__right .header-btns .header-message {
        position: relative;
    }

    .header__right .header-btns .header-message+.header-message {
        margin-left: 15px;
    }

    .header__right .header-btns .header-message span {
        position: absolute;
        top: -10px;
        left: 21px;
        background-color: #B34D75;
        border-radius: 50%;
        width: 23px;
        height: 23px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        padding: 0px 7px;
        font-weight: 400;
        color: #ffffff;
    }

    .header__right .header-btns .header-message.bell span {
        left: 12px;
        top: -13px;
    }

    @media (max-width: 992px) {
        .header__right .header-btns {
            margin-top: 20px;
            margin-right: auto;
            display: none;
        }
    }

    .header__right .header-profile {
        margin-left: 30px;
        position: relative;
    }

    .header__right .header-profile .header-profile__wrapper {
        display: flex;
        align-items: center;
        margin-left: 30px;
        cursor: pointer;
    }

    @media (max-width: 992px) {
        .header__right .header-profile .header-profile__wrapper {
            margin-left: 0px;
            display: none;
        }
    }

    .header__right .header-profile .header-profile__wrapper:hover .header-user-name {
        color: #B34D75;
    }

    .header__right .header-profile .header-user-name {
        margin-left: 8px;
        font-size: 14px;
        position: relative;
    }

    .header__right .header-profile .header-user-name::after {
        display: inline-block;
        margin-left: 0.255em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }

    .header__right .header-profile .user-img {
        display: inline-block;
        position: relative;
        margin-right: 5px;
    }

    .header__right .header-profile .user-img>img {
        height: 46px;
        -o-object-fit: cover;
        object-fit: cover;
        width: 46px;
        border-radius: 50%;
    }

    .header__right .header-profile .btn-menu {
        margin: 0 15px;
        transition: 0.3s;
        color: #B34D75;
        font-weight: 400;
        text-decoration: none;
    }

    .header__right .header-profile .btn-menu:hover {
        color: #7D3C88;
    }

    .header__right .header-profile .dropdown-menu {
        display: none;
    }

    .header__right .header-profile .dropdown-menu.emp {
        position: absolute;
        background: #B34D75;
        min-width: 180px;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        overflow: hidden;
        right: 0px;
        top: 57px;
        padding-bottom: 10px;
        z-index: 1;
    }

    .header__right .header-profile .dropdown-item {
        padding: 5px;
        padding: 5px;
        transition: 0.3s;
        color: #FFF;
        font-weight: 500;
        text-decoration: none;
    }

    .header__right .header-profile .dropdown-item:hover {
        color: #111;
    }

    .header__right .header-profile .drop-head {
        background: #7D3C88;
        padding: 6px;
        padding: 6px;
        font-weight: 600;
        color: #FFF;
    }

    @media (max-width: 992px) {
        .header__right .header-profile {
            margin-left: 0px;
            margin-top: 5px;
        }
    }

    @media (max-width: 992px) {
        .header__right {
            width: auto;
            flex-direction: column;
        }
    }

    .header__burger {
        display: none;
        flex-direction: column;
        position: absolute;
        width: 30px;
        top: 17px;
        height: 20px;
        z-index: 3;
        right: 30px;
    }

    .header__burger-line {
        height: 3px;
        border-radius: 15px;
        background-color: #B34D75;
        transition: all 0.3s;
        width: 100%;
    }

    .header__burger-line+.header__burger-line {
        margin-top: 5px;
    }

    .header__burger.active {
        top: 15px;
    }

    .header__burger.active .header__burger-line:first-child {
        display: none;
    }

    .header__burger.active .header__burger-line:nth-child(2) {
        transform: rotate(47deg) translate(5px, 5px);
    }

    .header__burger.active .header__burger-line:nth-child(3) {
        transform: rotate(-45deg) translate(0, -1px);
    }

    @media (max-width: 992px) {
        .header__burger {
            display: flex;
        }
    }

    .footer {
        padding: 40px 0px 25px;
        background: var(--back-card, #F6F6F6);
    }

    .footer__inner {
        display: flex;
        justify-content: space-between;
    }

    @media (max-width: 1060px) {
        .footer__inner {
            flex-direction: column;
        }
    }

    .footer__left {
        max-width: 171px;
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-right: 30px;
    }

    .footer__left img {
        height: auto;
    }

    @media (max-width: 1060px) {
        .footer__left {
            margin-right: 10px;
            margin-top: 30px;
        }
    }

    .footer__left-logo {
        font-size: 24px;
        line-height: 22px;
        color: #B34D75;
        font-family: "Nunito";
        font-style: normal;
        font-weight: 800;
    }

    @media (max-width: 1200px) {
        .footer__left-logo {
            font-size: 21px;
            line-height: 0px;
        }
    }

    .footer__left-copyright {
        margin-top: 15px;
        font-size: 13px;
        font-weight: 400;
        line-height: 18px;
        color: #5C5C5C;
    }

    .footer__left-social {
        margin-top: 35px;
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 20px;
        flex-basis: 25%;
    }

    .footer__left-social a {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #B34D75;
        border-radius: 50%;
        width: 26px;
        height: 26px;
    }

    @media (max-width: 567px) {
        .footer__left-social {
            margin-top: 20px;
        }
    }

    .footer__right {
        width: 100%;
        display: flex;
        justify-content: flex-start;
        margin-left: -50px;
        flex-wrap: nowrap;
        max-width: 1009px;
    }

    @media (max-width: 1200px) {
        .footer__right {
            margin-left: -20px;
        }
    }

    @media (max-width: 1060px) {
        .footer__right {
            margin-top: 30px;
        }
    }

    @media (max-width: 700px) {
        .footer__right {
            margin-left: -10px;
            flex-wrap: wrap;
        }
    }

    .footer__right-item {
        margin-left: 50px;
        flex-basis: calc(25% - 50px);
    }

    @media (max-width: 1200px) {
        .footer__right-item {
            margin-left: 20px;
            flex-basis: calc(25% - 20px);
        }
    }

    @media (max-width: 700px) {
        .footer__right-item {
            flex-basis: calc(50% - 10px);
            margin-left: 10px;
            margin-bottom: 10px;
        }
    }

    .footer__right-item.contacts {
        flex-basis: calc(35% - 50px);
    }

    @media (max-width: 1200px) {
        .footer__right-item.contacts {
            margin-left: 20px;
            flex-basis: calc(35% - 20px);
        }
    }

    @media (max-width: 700px) {
        .footer__right-item.contacts {
            flex-basis: calc(50% - 10px);
            margin-left: 10px;
            word-break: break-all;
        }
    }

    .footer__right-item-title {
        font-size: 14px;
        font-weight: 700;
        color: #98A2B3;
        display: block;
        margin-bottom: 18px;
    }

    @media (max-width: 567px) {
        .footer__right-item-title {
            font-size: 12px;
            line-height: 16px;
            margin-bottom: 10px;
        }
    }

    .footer__right-menu {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer__right-menu li {
        min-width: 152px;
    }

    .footer__right-menu li a {
        font-size: 17px;
        color: #161C2D;
        font-weight: 600;
        line-height: 23px;
        transition: all 0.3s;
    }

    .footer__right-menu li a:hover {
        color: #B34D75;
    }

    @media (max-width: 567px) {
        .footer__right-menu li a {
            font-size: 14px;
            line-height: 18px;
        }
    }

    @media (max-width: 1060px) {
        .footer__right-menu li {
            min-width: 100%;
        }
    }

    @media (max-width: 567px) {
        .footer__right-menu {
            gap: 9px;
        }
    }

    .footer__contacts-item a {
        font-size: 17px;
        font-style: normal;
        font-weight: 600;
        color: #161C2D;
        display: flex;
        align-items: flex-start;
    }

    .footer__contacts-item a .contacts-info-line-img {
        margin-right: 10px;
    }

    @media (max-width: 700px) {
        .footer__contacts-item a .contacts-info-line-img {
            margin-right: 0px;
            width: 19px;
        }
    }

    @media (max-width: 567px) {
        .footer__contacts-item a {
            font-size: 14px;
            line-height: 18px;
        }
    }

    .footer__contacts-item+.footer__contacts-item {
        margin-top: 12px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const burger = document.querySelector('.header__burger');
        const menu = document.querySelector('.header__menu');
        const arrowHeaders = document.querySelectorAll('.has-submenu .arrow');
        const headerMenus = document.querySelectorAll('.has-submenu');
        const profile = document.querySelectorAll('.header-profile__wrapper');
        if (profile) {
            let profileMore = document.querySelectorAll('.dropdown-menu');

            profile.forEach((item, index) => {
                item.addEventListener('click', () => {
                    profileMore[index].classList.toggle('emp');
                })
            });
        }
        burger.addEventListener('click', () => {
            classToggle(burger, 'active');
            classToggle(menu, 'active');
        })

        arrowHeaders.forEach((arrow, index) => {
            arrow.addEventListener('click', () => {
                headerMenus[index].classList.toggle('active')
            })
        });

        function classToggle(element, classAdd) {
            element.classList.toggle(classAdd);
        }
    });
</script>
