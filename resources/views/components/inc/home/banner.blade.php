<section class="banner">
    <div class="container">
        <div class="banner__wrapper">
            <div class="banner__content">
                <h3>{{ language('banner.main.title') }}</h3>
                <p>{{ language('banner.main.content') }}</p>
                <ul>
                    {!! language('banner.main.list') !!}
                </ul>
                <a href="/page/about-us">{{ language('read.more') }}</a>
            </div>
            <div class="banner__img-wrapper">
                <img width="598" loading="lazy" height="485" src="{{ asset('build/website/images/other/banner.png') }}" alt="" class="banner__img"> 
            </div>
        </div>
    </div>
</section>
