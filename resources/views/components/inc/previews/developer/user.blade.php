<div class="preview-user">
    <div class="preview-user__wrapper">
        <img width="70" height="70" loading="lazy" src="{{ $photo }}" alt="{{ $name }}" class="preview-user__photo">
        @if ($countryIco)
        <img src="{{ $countryIco }}" loading="lazy" alt="" width="18" height="14"
            class="preview-developer-user-country-ico">
        @endif
        <div class="preview-user__right">
            <span> {{ $name }}</span>
            <p>{{ $position }}</p>
        </div>
    </div>
</div>
