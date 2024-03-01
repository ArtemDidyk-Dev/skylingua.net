@if ($user->range_price)
    <div class="single-project__range">
        <h3>{{ language('Price Range:') }}</h3>
        @foreach ($user->range_price as $item)
            <div class="single-project__range-item">
                @if ($item->title)
                    <p>{{ $item->title }}</p>
                @endif
                @if ($item->price)
                    <span>{{ $item->price }}</span>
                @endif
            </div>
        @endforeach
    </div>
@endif

<div class="single-project-description-btns">
    @if($role)
        <x-inc.btns.profile-chat model="no-model" color="black" image="{{ asset('build/website/images/icons/chat.svg') }}"
                                 title="{{ language('Chat now') }}" link="{{ route('frontend.dashboard.create-chat', $id) }}"/>
    @elseif (auth()->id() != $id && !$role)
        <x-inc.btns.profile-chat color="black" image="{{ asset('build/website/images/icons/chat.svg') }}"
                                 title="{{ language('Chat now') }}" link="javascript:void(0)"/>
    @endif
</div>


