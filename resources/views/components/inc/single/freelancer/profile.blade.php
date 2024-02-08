<div class="freelancer-profile-details">
    <div class="freelancer-profile-details-top">
        <img src="{{ $proflieImg }}" alt="{{ $name }}" class="freelancer-profile-img">
        <div class="freelancer-profile-details-left">
            <h1 class="freelancer-profile-title">
                {{ $name }}
            </h1>
            <div class="freelancer-profile-subtitle">
                {{ $category }}
            </div>
            <x-inc.single.profile-link class="offset">
                {{ $profileLink }}
            </x-inc.single.profile-link>
        </div>

    </div>
    <span class="freelancer-profile-tags-title">{{ language('About the designer:') }}</span>

    <div class="freelancer-profile-tags">
        <x-inc.single.tag-img img="{{ asset('build/website/images/icons/rating.svg') }}" title="{{ $rating }} ({{ $ratingCount }})" />
        <x-inc.single.tag-img img="{{ asset('build/website/images/icons/time.svg') }}" title="{{$data}}" />
        @if ($geo)
            <x-inc.single.tag-img img="{{ asset('build/website/images/icons/geo.svg') }}" title="{{$geo}}" />    
        @endif
        <x-inc.single.tag-img img="{{ asset('build/website/images/icons/gender.svg') }}" title="{{$gender}}" />
        <x-inc.single.tag-img img="{{ asset('build/website/images/icons/pay.svg') }}" title="{{ $rate }} {{ language('frontend.currency') }}" />
      
    </div>
    @if (auth()->id() != $id)
        <x-inc.btns.with-image color="black" image="{{ asset('build/website/images/icons/arrow-btn.svg') }}" title="{{ language('Send message') }}"
            link="{{ route('frontend.dashboard.create-chat', $id) }}" />
    @endif
</div>
