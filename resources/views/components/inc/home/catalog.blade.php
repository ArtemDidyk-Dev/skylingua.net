<section class="project">
    <div class="container">
        <h2>{{ language('projects.home.title') }}</h2>
        <div class="project__wrapper">
            @foreach($freelancers as $freelancer)
                <a href="{{ route('frontend.profile.index', $freelancer->id) }}" class="project__item">
                    <div class="project__item-top">
                        <div class="project__top-item">
                            <img width="16" height="16" src="{{ asset('build/website/images/icons/owner.svg') }}" alt="{{ $freelancer['user_name'] }}" >
                           <span>Owner: {{ $freelancer['name'] }}</span>
                        </div>
                        @if(!empty($freelancer['user_category_name']))
                            <div class="project__top-item">
                                 <span>{{$freelancer['user_category_name']}}</span>
                            </div>
                        @endif
                    </div>
                    @if($freelancer['sub_title'] )
                        <h4>{{ $freelancer['sub_title'] }}</h4>
                    @endif
                    <div class="project__item-descrip">
                        <img class="project__item-author" width="60" height="60" src="{{ !empty($freelancer->profile_photo) ? asset('storage/profile/' . $freelancer->profile_photo): asset('storage/no-photo.jpg') }}" alt="{{ $freelancer['user_name'] }}" >
                        <span class="project__item-price">
                            <img loading="lazy" width="16" height="16"
                                src="{{ asset('build/website/images/icons/cash.svg') }}" alt="price">
                            Starts at {{ $freelancer->hourly_rate > 0 ? $freelancer->hourly_rate . ' ' . language('Hourly') : language('Bidding Price') }}

                        </span>
                        @if(!empty($freelancer['user_category_name']))
                        <span class="project__item-categor">
                            <img loading="lazy" width="16" height="16"
                            src="{{ asset('build/website/images/icons/categor-project.svg') }}" alt=" {{$freelancer['project_categories_first']}}">
                            {{$freelancer['user_category_name']}}
                        </span>
                        @endif
                    </div>
                    <p> {!!  str_limit(strip_tags(html_entity_decode($freelancer['description'])), $limit = 230, $end = '...') !!}</p>
                </a>
            @endforeach
            <div class="project__footer">
                <x-inc.btns.all color="blue" title="{{ language('See all services') }}" link="{{route('frontend.developer.index')}}" >
                </x-inc.btns.all>
            </div>

        </div>

    </div>
</section>
