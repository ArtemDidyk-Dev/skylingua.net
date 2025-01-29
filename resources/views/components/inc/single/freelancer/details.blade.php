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
    @if(\App\Services\CommonService::userRoleId(auth()->id()) == 3 &&  auth()->id() != $id)
        <x-inc.btns.profile-chat model="no-model" color="black"
                                 image="{{ asset('build/website/images/icons/chat.svg') }}"
                                 title="{{ language('Chat now') }}"
                                 link="{{ route('frontend.dashboard.create-chat', $id) }}"/>
    @elseif (auth()->id() != $id && !$role)
        <x-inc.btns.profile-chat color="black" image="{{ asset('build/website/images/icons/chat.svg') }}"
                                 title="{{ language('Chat now') }}" link="javascript:void(0)"/>
    @endif
    @if (auth()->check())
        @if (\App\Services\CommonService::userRoleId(auth()->id()) == 3)
            @if ($favourites)
                <x-inc.btns.profile attribute="data-project_id={{ $id }}" link="javascript:void(0)"
                                    color="transparent" classMod="projectAddFavorite favourited"
                                    image="{{ asset('build/website/images/icons/favourite-on.svg') }}"
                                    title="{{ language('In favorites') }}"/>
            @else
                <x-inc.btns.profile attribute="data-project_id={{ $id }}" link="javascript:void(0)"
                                    color="transparent" classMod="projectAddFavorite"
                                    image="{{ asset('build/website/images/icons/favourite.svg') }}"
                                    title="{{ language('Favourite') }}"/>
            @endif
        @endif
    @else
        <x-inc.btns.profile link="{{ route('frontend.login.index') }}" color="transparent"
                            image="{{ asset('build/website/images/icons/favourite.svg') }}"
                            title="{{ language('Favourite') }}"/>

    @endif
</div>

@if(!$isSubscribed && $user->subscription && !$isAuthor)
    <div class="single-layout__subscriber">
        <div class="subscriber__top">
            <p>Paid subscription</p>
            <span>€{{$user->subscription->price}}/month</span>
        </div>
        <a href="{{route('frontend.pay.subscribers', $user->subscription)}}" class="subscriber__button">
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M18.3768 11.448L18.3511 14.9744C18.337 16.9326 16.7323 18.5141 14.7741 18.4999L12.8612 18.486C11.5578 18.4765 10.4415 17.8211 9.79873 16.6873L7.64999 12.9044C7.44029 12.5334 7.57079 12.0616 7.94092 11.8523C8.33421 11.6287 8.78466 11.5648 9.20856 11.6721C9.641 11.7817 10.0028 12.0596 10.2273 12.4549L10.7507 13.3769L10.793 7.54992C10.7975 6.92037 11.3134 6.41188 11.943 6.41638C12.5718 6.42088 13.0799 6.9368 13.0754 7.56634L13.0567 10.154C13.2482 10.0127 13.4851 9.93017 13.7407 9.93197C14.1128 9.93467 14.4425 10.1162 14.6488 10.3941C14.8592 10.1192 15.1915 9.94255 15.5636 9.94525C16.0296 9.94862 16.429 10.2317 16.6036 10.6335C16.7937 10.4675 17.0428 10.3676 17.3146 10.3696C17.9047 10.3739 18.3811 10.8578 18.3768 11.448ZM7.44524 10.9757C7.86059 10.7397 8.32994 10.6142 8.80063 10.6142C9.02158 10.6142 9.24208 10.6416 9.45605 10.6958C9.56068 10.7224 9.66283 10.7548 9.76205 10.7933L9.78568 7.54294C9.78658 7.42257 9.78838 7.30152 9.79243 7.18182C9.96388 6.1619 10.8526 5.38206 11.9207 5.38206C12.9406 5.38206 13.7972 6.0935 14.0215 7.04592C14.0224 7.04952 14.0231 7.05335 14.024 7.05695C14.0291 7.0799 14.0343 7.10285 14.0388 7.1258C14.0685 7.27182 14.0838 7.42167 14.0827 7.57399L14.0728 8.95233C14.2748 8.98518 14.4708 9.04683 14.6542 9.13435C14.6942 9.1159 14.7352 9.09903 14.7764 9.08283C15.0277 8.61843 15.1679 8.09081 15.1679 7.54024C15.1679 5.74971 13.7112 4.29284 11.9205 4.29284C11.634 4.29284 11.3559 4.33042 11.0911 4.40039C10.6555 3.909 10.1292 3.4968 9.54898 3.1962C9.37798 3.10755 9.20361 3.02925 9.02653 2.9604L9.03081 2.37923C9.03823 1.35054 8.20731 0.507474 7.17862 0.500049C6.14993 0.492624 5.30686 1.32354 5.29944 2.35223L5.29516 2.93183C3.28683 3.67365 1.84459 5.59986 1.82816 7.86424L1.79374 12.6113C1.79059 13.0486 1.43217 13.4019 0.994771 13.3987C0.723423 13.3967 0.502025 13.6152 0.5 13.8863C0.5 13.8967 0.500675 13.9066 0.50135 13.9167C0.5009 13.9255 0.5 13.934 0.5 13.943C0.5 14.2436 0.743673 14.4873 1.04427 14.4873H4.82874C4.99861 15.5698 5.93258 16.4043 7.0632 16.4124C7.50644 16.4155 7.92764 16.2879 8.28561 16.0636L6.77385 13.4019C6.28988 12.5458 6.5916 11.4584 7.44524 10.9757Z"
                    fill="white"/>
            </svg>
            Subscribe
        </a>
        <div class="subscriber__bottom">
            <p class="subscriber__bottom-name">{{$user->subscription->name}}</p>
            <p class="subscriber__bottom-show">What will you get?</p>
            <div class="subscriber__content">
                {!! $user->subscription->description !!}
            </div>
        </div>
    </div>
@endif

@push('js')
    @if (auth()->check())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let projectAddFavoriteButtons = document.querySelectorAll('.projectAddFavorite');
                projectAddFavoriteButtons.forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();

                        if (button.classList.contains('favourited')) {
                            button.classList.remove('favourited');
                            let imageUrl = "{{ asset('build/website/images/icons/favourite.svg') }}";
                            let imgElement = `<img src="${imageUrl}" alt="Favourite Icon" class="btn-profile-img">`;
                            button.innerHTML = ` ${imgElement} Favourite`;
                        } else {
                            button.classList.add('favourited');
                            let imageUrl = "{{ asset('build/website/images/icons/favourite-on.svg') }}";
                            let imgElement = `<img src="${imageUrl}" alt="Favourite Icon" class="btn-profile-img">`;
                            button.innerHTML = ` ${imgElement} In favorites`;
                        }
                        let freelancer_id = button.getAttribute('data-project_id');
                        fetch('{{ route('frontend.ajax_add_freelancer_favourites') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                employer_id: {{ auth()->id() }},
                                freelancer_id: freelancer_id,
                            }),
                        })
                            .then(response => response.json())
                    });
                });
            });
        </script>
    @endif
@endpush
