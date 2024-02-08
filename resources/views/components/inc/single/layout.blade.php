<div class="container">
    {!! $breadcrumbs !!}
    <div class="single-layout__wrapper">
        <div class="single-layout__left">
            <div class="single-layout__left-content">
                {{ $profileLeft }}
                {{ $profiledescription }}
            </div>
        </div>
        <div class="single-layout__right">
            {{ $overview }}
            {{ $about }}
        </div>
    </div>
    {{ $modal }}
</div>
