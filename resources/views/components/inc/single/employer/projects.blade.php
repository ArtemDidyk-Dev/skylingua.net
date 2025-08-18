<div class="single-freelancer-portfolio">
    <x-inc.single.title class="single-freelancer-portfolio-title">
        {{ language('Projects') }}
    </x-inc.single.title>
    <div class="single-employer-projects-list">
        @if ($projects)
            @foreach ($projects as $project)
                <div class="card-body">
                    <div class="projects-details align-items-center">
                        <div class="project-info">
                            <span>{{ $project->user_categories_name }}</span>
                            <h2>
                                <a href="{{ route('frontend.project.detail', $project->id) }}">{{ $project->name }}</a>
                            </h2>
                            <div class="customer-info">
                                <ul class="list-details">
                                    <li>
                                        <div class="slot">
                                            <p>{{ language('Price type') }}</p>
                                            <h5>
                                                @if ($project->price_type == 1)
                                                    {{ language('Fixed Price') }}
                                                @elseif($project->price_type == 2)
                                                    {{ language('Hourly Pricing') }}
                                                @else
                                                    {{ language('Bidding Price') }}
                                                @endif
                                            </h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="slot">
                                            <p>{{ language('Location') }}</p>
                                            <h5>
                                                <img src="{{ $project->user_country_image }}" height="13"
                                                    alt="">
                                                {{ $project->user_country_name }}
                                            </h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="slot">
                                            <p>{{ language('Expiry') }}</p>
                                            <h5>
                                                {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                                            </h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="project-hire-info">
                            <div class="content-divider"></div>
                            <div class="projects-amount">
                                @if ($project->price > 0)
                                    <h3>${{ $project->price }}</h3>
                                @endif
                                <h5>
                                    @if ($project->price_type == 1)
                                        {{ language('Fixed Price') }}
                                    @elseif($project->price_type == 2)
                                        {{ language('Hourly Pricing') }}
                                    @else
                                        {{ language('Bidding Price') }}
                                    @endif
                                </h5>
                            </div>
                            <div class="content-divider"></div>
                            <div class="projects-action text-center">
                                <a href="{{ route('frontend.project.detail', $project->id) }}"
                                    class="btn btn-black btn-with-image">{{ language('View Details') }} </a>
                                <p class="hired-detail"><span>{{ $project->proposals_count }}</span>
                                    {{ language('Proposals') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="single-overview-not-found">
                No {{ language('Reviews') }}
            </div>
        @endif

    </div>
</div>

@push('css')
    <style>
        .single-freelancer-portfolio-title {
            margin-bottom: 20px;
        }

        .single-freelancer-portfolio-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }

        .single-freelancer-portfolio-elm {
            border-radius: 20px;
            height: 190px;
            padding: 60px 0 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            position: relative;
            cursor: pointer;
            user-select: none;
            text-decoration: none;
        }

        .single-freelancer-portfolio-elm-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 20px;
        }

        .single-freelancer-portfolio-elm-blue {
            background-color: rgba(73, 106, 241, 0.8);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 20px;
            pointer-events: none;
            opacity: 0;
            transition: 0.3s;
        }

        .single-freelancer-portfolio-elm-ico {
            position: relative;
            z-index: 2;
            pointer-events: none;
            opacity: 0;
            transition: 0.3s;
        }

        .single-freelancer-portfolio-elm-title {
            font-weight: 600;
            font-size: 12px;
            line-height: 18px;
            padding: 8px 16px;
            color: #161C2D;
            pointer-events: none;
            background-color: white;
            z-index: 2;
            pointer-events: none;
            border-radius: 8px;
            opacity: 0;
            transition: 0.3s;
        }

        .single-freelancer-portfolio-elm:hover>.single-freelancer-portfolio-elm-blue,
        .single-freelancer-portfolio-elm:hover>.single-freelancer-portfolio-elm-ico,
        .single-freelancer-portfolio-elm:hover>.single-freelancer-portfolio-elm-title {
            opacity: 1;
        }

        .card-body+.card-body {
            margin-top: 20px;
        }

        .card-body {
            padding: 16px;
            background-color: #F5F5F5;
            border-radius: 12px;
            margin-bottom: 12px;
            width: 100%;
        }

        .project-info span {
            color: var(--color-black);
            font-size: 16px;
            font-weight: 700;
            line-height: 28px;
        }

        .project-info h2 a {
            color: var(--color-blue);
            font-size: 16px;
            font-weight: 700;
            line-height: 20px;
            margin-right: 12px;
        }

        .project-info .customer-info ul {
            padding: 0
        }

        .list-details {
            display: flex;
            display: -ms-flexbox;
            justify-content: space-between;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
        }

        .list-details {
            display: flex;
            margin-top: 15px;
        }

        .project-info .customer-info ul li h5 {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .project-info .customer-info ul li h5 img {
            margin-right: 5px;
        }
        .project-hire-info {
            margin-top: 15px;
        }
        .projects-amount h5 {
            color: var(--color-blue);
        }
        .projects-action.text-center {
            margin-top: 10px;
        }
        .hired-detail {
            margin-top: 10px;
        }
        .hired-detail span {
            color: var(--color-black);
            font-weight: 500
        }
        .hired-detail {
            color: var(--color-blue);
        }
        
     
    </style>
@endPush

@push('meta')
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery.fancybox.min.js"></script>
@endPush
