<div class="project-client-info">
    <div class="project-client-info-title">
        {{ $category }}
    </div>
    <div class="project-client-info-rating">
        <x-inc.previews.rating ratingStars="{{ $rating }}" ratingCount="{{ $ratingCount }}" />
        <div class="project-client-info-jobs">
            {{ language('Total Jobs') }}
            <div class="project-client-info-jobs-number">
                {{ $projectsCount }}
            </div>
        </div>
    </div>
</div>
