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
<style>
.header {
  z-index: 2;
  position: relative;
  padding: 15px 0px;
  box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.05);
}
.header__menu {
    list-style-type: none;
    margin-bottom: 0px;
}
.footer__bootom-item ul {
    list-style-type: none;
}
.header__inner {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
@media (max-width: 992px) {
  .header__inner {
    justify-content: flex-start;
  }
}
.header__left {
  display: flex;
}
.header__left nav ul {
  display: flex;
}
.header__left nav ul li {
  position: relative;
  color: #111;
}
.header__left nav ul li a {
  color: #111;
  font-size: 15px;
  line-height: 21px;
  transition: all 0.3s;
}
.header__left nav ul li a:hover {
  color: #0F0F34;
  transition: all 0.3s;
  text-decoration: underline;
  text-underline-offset: 4px;
}
.header__left nav ul li.has-submenu {
  position: relative;
  display: flex;
  align-items: center;
  cursor: pointer;
}
.header__left nav ul li.has-submenu:hover .arrow {
  transform: rotate(180deg);
}
.header__left nav ul li.has-submenu:hover .submenu {
  opacity: 1;
  z-index: 1;
  transition: all 0.3s;
}
.header__left nav ul li.has-submenu .arrow {
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
.header__left nav ul li.has-submenu .submenu {
  display: flex;
  z-index: -2;
  opacity: 0;
  flex-direction: column;
  position: absolute;
  list-style-type: none;
  min-width: 215px;
  top: 32px;
  background: #0F0F34;
  border-radius: 12px;
  padding: 10px;
  transition: all 0.3s;
}
.header__left nav ul li.has-submenu .submenu li + li {
  margin-left: 0px;
  margin-top: 10px;
}
.header__left nav ul li.has-submenu .submenu li {
  padding-bottom: 0px;
}
.header__left nav ul li.has-submenu .submenu li a {
  color: #FFF;
}
.header__left nav ul li.has-submenu .submenu li a:hover {
  color: #FFF;
}
@media (max-width: 992px) {
  .header__left nav ul li.has-submenu:hover .arrow {
    transform: none;
  }
  .header__left nav ul li.has-submenu .submenu {
    display: none;
  }
  .header__left nav ul li.has-submenu.active .arrow {
    transform: rotate(180deg);
  }
  .header__left nav ul li.has-submenu.active .submenu {
    display: flex;
  }
}
.header__left nav ul li + li {
  margin-left: 48px;
}
@media (max-width: 992px) {
  .header__left nav ul {
    display: none;
  }
  .header__left nav ul.active {
    border-radius: 0px;
    background: var(--white, #FFF);
    display: flex;
    width: 100% !important;
    position: absolute;
    top: 67px;
    flex-direction: column;
    padding: 13px;
    z-index: 2;
    justify-content: flex-start;
    align-items: flex-start;
    left: 0px;
    background: #FFF;
  }
  .header__left nav ul.active li {
    width: auto;
    min-width: 115px;
  }
  .header__left nav ul.active li + li {
    margin-left: 0px;
    margin-top: 15px;
  }
  .header__left nav ul.active .header-btns {
    display: flex;
    margin-left: auto;
    align-items: center;
  }
  .header__left nav ul.active .header-btns.no-auth a {
    color: #0F0F34;
    padding: 10px 24px 8px 24px;
    line-height: 24px;
    font-size: 14px;
    border-radius: 8px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
  }
  .header__left nav ul.active .header-btns.no-auth a:hover {
    color: #FFF;
    background: #0F0F34;
  }
  .header__left nav ul.active .header-btns.no-auth a:hover svg {
    fill: #0F0F34;
  }
}
@media (max-width: 992px) and (max-width: 992px) {
  .header__left nav ul.active .header-btns.no-auth a {
    padding: 4px 19px;
  }
}
@media (max-width: 992px) {
  .header__left nav ul.active .header-btns.no-auth a svg {
    margin-right: 10px;
    fill: #FFF;
    transition: all 0.3s;
  }
  .header__left nav ul.active .header-btns.no-auth a:first-child svg {
    fill: #0F0F34;
  }
  .header__left nav ul.active .header-btns.no-auth a:first-child:hover svg {
    fill: #FFF;
  }
  .header__left nav ul.active .header-btns.no-auth a + a {
    color: #fff;
    margin-left: 10px;
    background: #0F0F34;
  }
  .header__left nav ul.active .header-btns.no-auth a + a:hover {
    color: #0F0F34;
    background: #fff;
  }
  .header__left nav ul.active .header-btns .header-message {
    position: relative;
  }
  .header__left nav ul.active .header-btns .header-message + .header-message {
    margin-left: 15px;
  }
  .header__left nav ul.active .header-btns .header-message span {
    position: absolute;
    top: -10px;
    left: 21px;
    background-color: #0F0F34;
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
  .header__left nav ul.active .header-btns .header-message.bell span {
    left: 12px;
    top: -13px;
  }
}
@media (max-width: 992px) and (max-width: 992px) {
  .header__left nav ul.active .header-btns {
    margin-top: 20px;
    margin-right: auto;
    display: none;
  }
}
@media (max-width: 992px) {
  .header__left nav ul.active .header-profile {
    margin-left: 30px;
    position: relative;
  }
  .header__left nav ul.active .header-profile .header-profile__wrapper {
    display: flex;
    align-items: center;
    margin-left: 30px;
    cursor: pointer;
  }
  .header__left nav ul.active .header-profile .header-profile__wrapper:hover .header-user-name {
    color: #0F0F34;
  }
  .header__left nav ul.active .header-profile .header-user-name {
    margin-left: 8px;
    font-size: 14px;
    position: relative;
  }
  .header__left nav ul.active .header-profile .header-user-name::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: "";
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
  }
  .header__left nav ul.active .header-profile .user-img {
    display: inline-block;
    position: relative;
    margin-right: 5px;
  }
  .header__left nav ul.active .header-profile .user-img > img {
    height: 46px;
    -o-object-fit: cover;
       object-fit: cover;
    width: 46px;
    border-radius: 50%;
  }
  .header__left nav ul.active .header-profile .btn-menu {
    margin: 0 15px;
    transition: 0.3s;
    color: #0F0F34;
    font-weight: 400;
    text-decoration: none;
  }
  .header__left nav ul.active .header-profile .btn-menu:hover {
    color: #F5B841;
  }
  .header__left nav ul.active .header-profile .dropdown-menu {
    display: none;
  }
  .header__left nav ul.active .header-profile .dropdown-menu.emp {
    position: absolute;
    background: #0F0F34;
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
  .header__left nav ul.active .header-profile .dropdown-item {
    padding: 5px;
    padding: 5px;
    transition: 0.3s;
    color: #FFF;
    font-weight: 500;
    text-decoration: none;
  }
  .header__left nav ul.active .header-profile .dropdown-item:hover {
    color: #FFF;
    text-decoration: underline;
  }
  .header__left nav ul.active .header-profile .drop-head {
    background: #F5B841;
    padding: 6px;
    padding: 6px;
    font-weight: 600;
    color: #FFF;
  }
}
@media (max-width: 992px) and (max-width: 992px) {
  .header__left nav ul.active .header-profile {
    margin-left: 0px;
    margin-top: 5px;
  }
}
@media (max-width: 992px) and (max-width: 992px) {
  .header__left nav ul.active {
    flex-direction: column;
  }
}
@media (max-width: 992px) {
  .header__left nav ul.active .header-btns {
    display: flex;
    justify-content: flex-start;
  }
  .header__left nav ul.active .header-profile,
  .header__left nav ul.active .header-profile__wrapper {
    display: flex;
  }
  .header__left nav ul.active .header-profile {
    justify-content: center;
    align-items: center;
    align-self: center;
  }
}
.header__left nav .header-btns,
.header__left nav .header-profile,
.header__left nav .header-profile__wrapper {
  display: none;
}
.header__right {
  display: flex;
  align-items: center;
}
.header__right .header-btns {
  display: flex;
  margin-left: auto;
  align-items: center;
}
.header__right .header-btns.no-auth a {
  color: #0F0F34;
  padding: 10px 24px 8px 24px;
  border: 2px solid #0F0F34;
  line-height: 24px;
  font-size: 14px;
  border-radius: 8px;
  transition: all 0.3s;
  display: flex;
  align-items: center;
}
.header__right .header-btns.no-auth a:hover {
  color: #FFF;
  background: #0F0F34;
}
.header__right .header-btns.no-auth a:hover svg {
  fill: #0F0F34;
}
@media (max-width: 992px) {
  .header__right .header-btns.no-auth a {
    padding: 4px 24px;
  }
}
.header__right .header-btns.no-auth a svg {
  margin-right: 10px;
  fill: #FFF;
  transition: all 0.3s;
}
.header__right .header-btns.no-auth a:first-child svg {
  fill: #0F0F34;
}
.header__right .header-btns.no-auth a:first-child:hover svg {
  fill: #FFF;
}
.header__right .header-btns.no-auth a + a {
  color: #fff;
  margin-left: 20px;
  background: #0F0F34;
}
.header__right .header-btns.no-auth a + a:hover {
  color: #0F0F34;
  background: none;
}
.header__right .header-btns .header-message {
  position: relative;
}
.header__right .header-btns .header-message + .header-message {
  margin-left: 15px;
}
.header__right .header-btns .header-message span {
  position: absolute;
  top: -10px;
  left: 21px;
  background-color: #0F0F34;
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
  color: #0F0F34;
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
.header__right .header-profile .user-img > img {
  height: 46px;
  -o-object-fit: cover;
     object-fit: cover;
  width: 46px;
  border-radius: 50%;
}
.header__right .header-profile .btn-menu {
  margin: 0 15px;
  transition: 0.3s;
  color: #0F0F34;
  font-weight: 400;
  text-decoration: none;
}
.header__right .header-profile .btn-menu:hover {
  color: #F5B841;
}
.header__right .header-profile .dropdown-menu {
  display: none;
}
.header__right .header-profile .dropdown-menu.emp {
  position: absolute;
  background: #0F0F34;
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
  text-decoration: underline;
}
.header__right .header-profile .drop-head {
  background: #F5B841;
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
  top: 23px;
  height: 20px;
  z-index: 3;
  right: 30px;
}
.header__burger-line {
  height: 3px;
  border-radius: 15px;
  background-color: #0F0F34;
  transition: all 0.3s;
  width: 100%;
}
.header__burger-line + .header__burger-line {
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
  background: #040418;
}
.footer__top {
  display: flex;
  padding-top: 39px;
  justify-content: space-between;
}
@media (max-width: 1200px) {
  .footer__top {
    flex-direction: column;
  }
}
@media (max-width: 806px) {
  .footer__top {
    padding-top: 20px;
  }
}
.footer__top-left {
  max-width: 233px;
  width: 100%;
  display: flex;
  flex-direction: column;
}
@media (max-width: 806px) {
  .footer__top-left {
    max-width: 100%;
  }
}
.footer__top-copyright {
  margin-top: 20px;
  font-weight: 400;
  font-size: 14px;
  color: #FFF;
}
.footer__top-right {
  display: flex;
  width: 100%;
  justify-content: flex-end;
}
@media (max-width: 1200px) {
  .footer__top-right {
    margin-top: 15px;
    justify-content: flex-start;
  }
}
@media (max-width: 806px) {
  .footer__top-right {
    flex-direction: column;
  }
}
.footer__right-item {
  border-radius: 8px;
  max-width: 230px;
  width: 100%;
}
@media (max-width: 1200px) {
  .footer__right-item {
    max-width: 100%;
  }
}
.footer__right-item + .footer__right-item {
  margin-left: 80px;
}
@media (max-width: 1200px) {
  .footer__right-item + .footer__right-item {
    margin-left: 30px;
  }
}
@media (max-width: 806px) {
  .footer__right-item + .footer__right-item {
    margin-left: 0px;
    margin-top: 20px;
  }
}
.footer__right-item {
  display: flex;
  align-items: flex-start;
  flex-direction: column;
}
.footer__right-item span {
  font-weight: 700;
  font-size: 15px;
  text-transform: uppercase;
  color: #858585;
  margin-bottom: 20px;
}
@media (max-width: 806px) {
  .footer__right-item span {
    margin-bottom: 10px;
  }
}
.footer .contacts-info-line {
  display: flex;
  align-items: center;
}
.footer .contacts-info-line-img {
  align-self: flex-start;
  margin-right: 9px;
}
@media (max-width: 567px) {
  .footer .contacts-info-line-img {
    margin-right: 5px;
  }
}
.footer .contacts-info-line-text {
  font-weight: 400;
  font-size: 16px;
  color: #FFF;
}
.footer__left-social {
  margin-top: 0px;
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
  background: #FFF;
  border-radius: 50%;
  width: 26px;
  height: 26px;
}
.footer__line {
  width: 100%;
  height: 1px;
  background-color: #9c9c9c;
  margin: 35px 0;
}
@media (max-width: 806px) {
  .footer__line {
    margin: 20px 0;
  }
}
.footer__bootom {
  display: flex;
  justify-content: space-between;
  padding-bottom: 45px;
}
@media (max-width: 806px) {
  .footer__bootom {
    padding-bottom: 25px;
    flex-direction: column;
  }
}
.footer__bootom-item {
  max-width: 160px;
  width: 100%;
  display: flex;
  flex-direction: column;
}
.footer__bootom-item span {
  font-weight: 700;
  font-size: 15px;
  text-transform: uppercase;
  color: #858585;
  margin-bottom: 20px;
}
.footer__bootom-item ul li + li {
  margin-top: 10px;
}
.footer__bootom-item ul li a {
  color: #FFF;
  font-weight: 400;
  font-size: 16px;
}
@media (max-width: 806px) {
  .footer__bootom-item {
    max-width: 100%;
  }
  .footer__bootom-item span {
    margin-bottom: 10px;
  }
}
.footer__bootom-item + .footer__bootom-item {
  margin-left: 10px;
}
@media (max-width: 806px) {
  .footer__bootom-item + .footer__bootom-item {
    margin-left: 0px;
    margin-top: 20px;
  }
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