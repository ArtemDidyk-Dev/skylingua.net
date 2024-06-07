<footer class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="footer__top-left">
                <a href="{{ route('frontend.home.index') }}" class="footer__top-logo">
                    <img width="78" height="36" src="{{ asset('build/website/images/logo-light.png') }}"
                        alt="logo">
                </a>
                <div class="footer__top-copyright">
                    {!! setting('copyright', true) !!}
                </div>
            </div>
            <div class="footer__top-right">
                <div class="footer__right-item">
                    <span>Address</span>
                    @if (!empty(setting('address', true)))
                        <a href="{{ setting('map') }}" class="contacts-info-line">
                            <img loading="lazy" src="/images/icons/contacts-location-white.svg" alt=""
                                class="contacts-info-line-img">
                            <div class="contacts-info-line-text">
                                {{ setting('address', true) }}
                            </div>
                        </a>
                    @endif
                </div>
                <div class="footer__right-item">
                    <span>Email</span>
                    @if (!empty(setting('email')))
                        <a href="mailto:{{ setting('email') }}" class="contacts-info-line">
                            <img loading="lazy" src="/images/icons/contacts-email-white.svg" alt=""
                                class="contacts-info-line-img">
                            <div class="contacts-info-line-text">
                                {{ setting('email') }}
                            </div>
                        </a>
                    @endif
                </div>
                <div class="footer__right-item">
                    <span>Social network</span>
                    <div class="footer__left-social">
                        @if (!empty(json_decode(setting('social'))))
                            @foreach (json_decode(setting('social')) as $key => $value)
                                <a href="{{ $value->link }}" target="_blank" rel="nofollow" class="footer-social-link">
                                    <img loading="lazy" src="/images/icons/{{ $value->name }}.svg"
                                        alt="{{ $value->name }}" class="footer-social-link-img">
                                </a>
                            @endforeach
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="footer__line"></div>

    <div class="container">
        <div class="footer__bootom">
            <div class="footer__bootom-item">
                <span>For clients</span>
                <ul>
                    @foreach ($footerMenuHeaderItem as $item)
                        <li><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer__bootom-item">
                <span>Catalog</span>
                <ul>
                    @foreach ($categoryes as $category)
                        @if ($loop->index < 3)
                        <li><a href="{{ route('frontend.developer.index', ['user_category' => $category->user_category_id]) }}">{{ $category->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="footer__bootom-item">
                <span>Catalog</span>
                <ul>
                    @foreach ($categoryes as $category)
                        @if ($loop->index > 3)
                        <li><a href="{{ route('frontend.developer.index', ['user_category' => $category->user_category_id]) }}">{{ $category->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="footer__bootom-item">
                <span>Information</span>
                <ul>
                    @foreach ($footerMenu as $item)
                        <li><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="footer__payment">
            <img width="31" height="25" src="{{ asset('build/website/images/icons/master.png') }}" alt="master card">
            <img width="36" height="23" src="{{ asset('build/website/images/icons/visa.png') }}" alt="visa">
        </div>
    </div>

</footer>
