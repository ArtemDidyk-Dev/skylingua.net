@if ($portfolios->isNotEmpty())
<div class="single-freelancer-portfolio">
    <x-inc.single.title class="single-freelancer-portfolio-title">
        {{ language('Portfolio') }}
    </x-inc.single.title>
    <div class="single-freelancer-portfolio-list">
        @if ($portfolios && $portfolios->total() > 0)
            @foreach ($portfolios as $portfolio)
                @if (!empty($portfolio->image))
                    <a href="{{ asset('storage/portfolio/' . $portfolio->image) }}"
                        class="single-freelancer-portfolio-elm" data-fancybox="portfolio">
                        <img class="single-freelancer-portfolio-elm-bg" alt="{{ $portfolio->title }}"
                            src="{{ asset('storage/portfolio/' . $portfolio->image) }}">
                        <div class="single-freelancer-portfolio-elm-blue"></div>
                        <img class="single-freelancer-portfolio-elm-ico" src="/images/icons/zoom.svg" alt="zoom">
                        <div class="single-freelancer-portfolio-elm-title">
							{{ $portfolio->title }}
                        </div>
                    </a>
                @else
                    <img class="single-freelancer-portfolio-elm alt="{{ $portfolio->title }}"
                        src="{{ asset('storage/no_image_portfolio.jpg') }}">
                @endif
            @endforeach
        @endif
    </div>
</div>    
@endif


@push('meta')
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery.fancybox.min.js"></script>
@endPush
