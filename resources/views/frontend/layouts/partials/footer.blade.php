<footer class="footer">
  <div class="container">
      <div class="footer__inner">
          <div class="footer__left">
            <a href="{{ route('frontend.home.index') }}" class="footer__left-logo">
                <img width="172" height="30"  src="{{ asset('build/website/images/logo.png') }}" alt="logo">
            </a>
              <div class="footer__left-copyright">
                  {!! setting('copyright', true) !!}
              </div>
              <div class="footer__left-social">
                  @if (!empty(json_decode(setting('social'))))
                      @foreach (json_decode(setting('social')) as $key => $value)
                          <a href="{{ $value->link }}" target="_blank" rel="nofollow" class="footer-social-link">
                              <img  loading="lazy" src="/images/icons/{{ $value->name }}.svg" alt="{{ $value->name }}"
                                  class="footer-social-link-img">
                          </a>
                      @endforeach
                  @endif
              </div>
          </div>
          <div class="footer__right">
              <div class="footer__right-item">
                  <span class="footer__right-item-title">Categories</span>
                  <ul class="footer__right-menu">
                      @foreach ($categoryes as $category)
                      <li><a href="{{ route('frontend.developer.index', ['user_category' => $category->user_category_id]) }}">{{ $category->name }}</a></li>
                      @endforeach
                  </ul>
              </div>
              <div class="footer__right-item">
                  <span class="footer__right-item-title">Company</span>
                  <ul class="footer__right-menu">
                      @foreach ($footerMenuHeaderItem as $item)
                          <li><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                      @endforeach
                  </ul>
              </div>
              <div class="footer__right-item">
                  <span class="footer__right-item-title">Help</span>
                  <ul class="footer__right-menu">
                      @foreach ($footerMenu as $item)
                          <li><a href="{{ $item->link }}">{{ $item->label }}</a></li>
                      @endforeach
                  </ul>
              </div>
              <div class="footer__right-item contacts">
                  <span class="footer__right-item-title">Contact us</span>
                  <div class="footer__right-contacts">
                      <div class="footer__contacts-item">
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
                      <div class="footer__contacts-item">
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
                  </div>
              </div>
          </div>
      </div>
  </div>
</footer>
