<section class="project">
    <div class="container">
        <h2>{{ language('projects.home.title') }}</h2>
        <div class="project__wrapper">
            @foreach($projects as $project)
                <a href="{{ route('frontend.project.detail', $project['id']) }}" class="project__item">
                    <div class="project__item-top">
                        <div class="project__top-item">
                            <img width="16" height="16" src="{{ asset('build/website/images/icons/owner.svg') }}" alt="{{ $project['user_name'] }}" >
                           <span>Project Owner: {{ $project['user_name'] }}</span>
                        </div>
                        <div class="project__top-item">
                            <img width="16" height="16" src="{{ asset('build/website/images/icons/time.svg') }}" alt="{{$project['created_at_view']}}" >
                             <span>{{$project['created_at_view']}}</span>
                        </div>
                    </div>
                    <h4>{{ $project['name'] }}</h4>
                    <div class="project__item-descrip">
                        <span class="project__item-price">
                            <img loading="lazy" width="16" height="16"
                                src="{{ asset('build/website/images/icons/cash.svg') }}" alt="price">
                            Starts at {{ $project['price'] > 0 ? price_format($project['price_view']) : language('Bidding Price') }}
                            
                        </span>
                        @if(!empty($project['project_categories_first']))
                        <span class="project__item-categor">
                            <img loading="lazy" width="16" height="16"
                            src="{{ asset('build/website/images/icons/categor-project.svg') }}" alt=" {{$project['project_categories_first']}}">
                            {{$project['project_categories_first']}}
                        </span>
                        @endif
                    </div>
                    <p> {!!  str_limit(strip_tags(html_entity_decode($project['description'])), $limit = 230, $end = '...') !!}</p>
                </a>
            @endforeach
            <div class="project__footer">
                <x-inc.btns.all color="blue" title="{{ language('See all services') }}" link="{{route('frontend.project.index')}}" >
                </x-inc.btns.all>
            </div>
            
        </div>

    </div>
</section>
