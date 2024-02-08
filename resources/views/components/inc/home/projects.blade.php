<section class="project">
    <div class="container">
        <h2>{{ language('projects.home.title') }}</h2>
        <div class="project__wrapper">
            @for ($i = 0; $i < 6; $i++)
                <a href="/" class="project__item">
                    <div class="project__item-top">
                        <div class="project__top-item">
                            <img width="16" height="16" src="{{ asset('build/website/images/icons/owner.svg') }}" alt="Regina Crossr" >
                           <span>Project Owner: Regina Cross</span>
                        </div>
                        <div class="project__top-item">
                            <img width="16" height="16" src="build/website/images/icons/time.svg" alt="Posted 5 mins ago" >
                             <span>Posted 5 mins ago</span>
                        </div>
                    </div>
                    <h4>Assisting with drafting and filing the articles of incorporation or organization</h4>
                    <div class="project__item-descrip">
                        <span class="project__item-price">
                            <img loading="lazy" width="16" height="16"
                                src="{{ asset('build/website/images/icons/cash.svg') }}" alt="price">
                            Starts at 16.98€
                            
                        </span>
                        <span class="project__item-categor">
                            <img loading="lazy" width="16" height="16"
                            src="{{ asset('build/website/images/icons/categor-project.svg') }}" alt="Company registration services">
                            Company registration services
                        </span>
                    </div>
                    <p>I am thrilled to offer my expertise as an experienced professional in assisting you with drafting
                        and filing the articles of incorporation or organization for your busi...</p>
                </a>
            @endfor
            <div class="project__footer">
                <x-inc.btns.all color="blue" title="{{ language('See all services') }}" link="/" >
                </x-inc.btns.all>
            </div>
            
        </div>

    </div>
</section>
