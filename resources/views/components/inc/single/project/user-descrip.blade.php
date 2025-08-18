@if ($posted or $country)
    <div class="single-project-client__descrip">
        @if ($posted)
            <div class="preview-user-line">
                <img src="{{ asset('build/website/images/icons/clock.svg') }}" alt=""
                    class="preview-user-line-img">
                {{ $posted }}
            </div>
        @endif
        @if ($country)
            <div class="preview-user-line">
                <img src="{{ asset('build/website/images/icons/location.svg') }}" alt=""
                    class="preview-user-line-img">
                {{ $country }}
            </div>
        @endif
    </div>
@endif
