@if ($project->range_price)
    <div class="single-project__range">
        <h3>{{ language('Price Range:') }}</h3>
        @foreach ($project->range_price as $item)
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
    @if (auth()->check())
        @if (\App\Services\CommonService::userRoleId(auth()->id()) == 4)

            <x-inc.btns.profile link="javascript:void(0)" classMod="model-active" color="transparent"
                image="{{ asset('build/website/images/icons/send.svg') }}" title="{{ language('Order now') }}" />

            @if (auth()->id() != $id)
                <x-inc.btns.profile-chat color="black" image="{{ asset('build/website/images/icons/chat.svg') }}"
                    title="{{ language('Chat now') }}" link="{{ route('frontend.dashboard.create-chat', $id) }}" />
            @endif

        @endif
    @else
        <x-inc.btns.profile link="{{ route('frontend.login.index') }}" color="transparent"
            image="{{ asset('build/website/images/icons/send.svg') }}" title="Order now" />
        <x-inc.btns.profile-chat color="black" image="{{ asset('build/website/images/icons/chat.svg') }}"
            title="{{ language('Chat now') }}" link="{{ route('frontend.login.index') }}" />
    @endif
</div>

@push('js')
    @if (auth()->check())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let projectAddFavoriteButtons = document.querySelectorAll('.projectAddFavorite');
                projectAddFavoriteButtons.forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();

                        if (button.classList.contains('favourited')) {
                            button.classList.remove('favourited');
                            let imageUrl = "{{ asset('build/website/images/icons/favourite.svg') }}";
                            let imgElement =
                                `<img src="${imageUrl}" alt="Favourite Icon" class="btn-profile-img">`;
                            button.innerHTML = ` ${imgElement} Favourite`;
                        } else {
                            button.classList.add('favourited');
                            let imageUrl =
                                "{{ asset('build/website/images/icons/favourite-on.svg') }}";
                            let imgElement =
                                `<img src="${imageUrl}" alt="Favourite Icon" class="btn-profile-img">`;
                            button.innerHTML = ` ${imgElement} In favorites`;
                        }

                        let project_id = button.getAttribute('data-project_id');

                        fetch('{{ route('frontend.ajax_add_project_favourites') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    freelancer_id: '{{ auth()->id() }}',
                                    project_id: project_id,
                                }),
                            })
                            .then(response => response.json())
                    });
                });

            });
        </script>
    @endif

@endPush
