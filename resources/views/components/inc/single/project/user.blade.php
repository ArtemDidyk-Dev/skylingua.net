<div class="preview-user">
    <div class="preview-user__wrapper">
        <img width="70" height="70" loading="lazy" src="{{ $photo }}" alt="{{ $name }}"
            class="preview-user__photo">
        <div class="preview-user__right">
            <span> {{ $name }}</span>
            <x-inc.single.profile-link class="offset">
                {{ $profileLink }}
            </x-inc.single.profile-link>
            @if (!empty($socials))
                <x-inc.socials class="user" :links="$socials" />
            @endif
        </div>
    </div>
</div>
