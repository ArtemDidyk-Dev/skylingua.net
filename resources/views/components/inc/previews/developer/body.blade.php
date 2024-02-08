<div class="preview-user__body">
    <div class="preview-user__body-content-list">
        <span class="preview-user__body-content-title">
            About the designer:
        </span>
        <div class="preview-user__body-list-item">
            <p>Rating:</p>
            <div class="preview-user__body-list-item-dots"></div>
            <x-inc.previews.rating :ratingStars="$ratingStars" :ratingCount="$ratingCount" />
        </div>
        @if ($price)
            <div class="preview-user__body-list-item">
                <p>Price:</p>
                <div class="preview-user__body-list-item-dots"></div>
                <span>{{ $price }}</span>
            </div>
        @endif

        <div class="preview-user__body-list-item">
            <p>Member Since:</p>
            <div class="preview-user__body-list-item-dots"></div>
            <span>{{ $data }}</span>
        </div>
        @if ($country)
            <div class="preview-user__body-list-item">
                <p>Country:</p>
                <div class="preview-user__body-list-item-dots"></div>
                <span>{{ $country }}</span>
            </div>
        @endif
    </div>
</div>
