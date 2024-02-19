<section class="search">
    <div class="container">
        <div class="search__inner">
            <div class="search__left">
                <div class="search__text">
                    <h1>{{ language('frontend.home.h1') }}</h1>
                    <p>{{ language('home-banner-subtitle') }}</p>
                </div>
                <form class="search__element-form" name="store" id="search" method="GET"
                    action="{{ route('frontend.project.index') }}">
                    <img width="22" height="22" src="{{ asset('build/website/images/icons/search.svg') }}"
                        alt="" class="search__element-form-ico">
                    <input type="text" name="keyword" class="search__element-form-input"
                        placeholder="{{ language('Search here...') }}">
                        <div class="search__element-form-separator"></div>
                        <div class="search__element-form-select">
                            <div class="search__element-form-title">Legal services</div>
                            <img src="/images/icons/arrow-bottom.svg" alt="" class="search__element-form-arrow">
                            <div class="search__element-form-options">
                                <div data-search="services" class="search__element-form-option">{{ language('Legal services') }}
                                </div>
                            </div>
                        </div>
                    <x-inc.btns.search title="{{ language('Search') }}">
                    </x-inc.btns.search>
                </form>
            </div>
            <div class="search__right">
                <img  loading="lazy" width="630" height="516"
                src="{{ asset('build/website/images/other/search-img.png') }}" alt="search-banner">
            </div>
        </div>
    </div>

</section>
