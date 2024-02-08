<div class="preview-user__body">
    <div class="preview-user__body-top">
        <div class="preview-user__body-item">
            <img src="{{ asset('build/website/images/icons/clock.svg') }}" alt="" class="preview-user-line-img">
            {{ $posted }}
        </div>
        <div class="preview-user__body-item">
            <img src="{{ asset('build/website/images/icons/location.svg') }}" alt="" class="preview-user-line-img">
            {{ $country }}
        </div>
    </div>

    <div class="preview-user__body-content">
        <div class="preview-user__body-element">
            <p>{{ language('Price') }}</p>
            <span>{{$price}}</span>
        </div>
        <div class="preview-user__body-element">
            <p>{{ language('Expiry') }}</p>
            <span>{{$expiry}}</span>
        </div>
        <div class="preview-user__body-element">
            <p>{{ language('Proposals') }}</p>
            <span>{{$proposals}}</span>
        </div>
        <div class="preview-user__body-element">
            <p>{{ language('Job Type') }}</p>
            <span>{{$job}}</span>
        </div>
        <div class="preview-user__body-description">
            {!!  str_limit(strip_tags(html_entity_decode($content)), $limit = 230, $end = '...') !!}
        </div>
    </div>
</div>
