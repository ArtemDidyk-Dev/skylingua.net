<h3>{{ language('Information:') }}</h3>
<x-inc.single.text-line title="{{ language('Job Expiry') }}">
    {{ $data }}
</x-inc.single.text-line>
<x-inc.single.text-line title="{{ language('Location') }}">
    <img class="details-country-img" src="{{ $geoImg }}" alt="{{ $geo }}">
    {{ $geo }}
</x-inc.single.text-line>
<x-inc.single.text-line title="{{ language('Proposals') }}">
    {{ $proposals }} {{ language('Proposals') }}
</x-inc.single.text-line>
<x-inc.single.text-line title="{{ language('Price type') }}">
    {{ $priceType }}
</x-inc.single.text-line>

<div class="single-project-description-btns">
    @if (auth()->check())
        @if (\App\Services\CommonService::userRoleId(auth()->id()) == 4)
            @if ($favourites)
            <x-inc.btns.profile attribute="data-project_id={{ $id }}" link="javascript:void(0)"
            color="transparent" classMod="projectAddFavorite favourited"
            image="{{ asset('build/website/images/icons/favourite-on.svg') }}" title="{{ language('In favorites') }}" />
            @else
                <x-inc.btns.profile attribute="data-project_id={{ $id }}" link="javascript:void(0)"
                color="transparent" classMod="projectAddFavorite"
            image="{{ asset('build/website/images/icons/favourite.svg') }}" title="{{ language('Favourite') }}" />
            @endif
            <x-inc.btns.profile link="javascript:void(0)" classMod="model-active" color="transparent"
                image="{{ asset('build/website/images/icons/send.svg') }}" title="{{ language('Send Invite') }}" />
        
        @endif
    @else
    <x-inc.btns.profile link="{{ route('frontend.login.index') }}" color="transparent"
    image="{{ asset('build/website/images/icons/favourite.svg') }}" title="{{ language('Favourite') }}" />
<x-inc.btns.profile link="{{ route('frontend.login.index') }}" color="transparent"
    image="{{ asset('build/website/images/icons/send.svg') }}" title="Send Proposal" />
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
                            let imageUrl =  "{{ asset('build/website/images/icons/favourite.svg') }}";
                            let imgElement = `<img src="${imageUrl}" alt="Favourite Icon" class="btn-profile-img">`;
                            button.innerHTML = ` ${imgElement} Favourite`;
                        } else {
                            button.classList.add('favourited');
                            let imageUrl =  "{{ asset('build/website/images/icons/favourite-on.svg') }}";
                            let imgElement = `<img src="${imageUrl}" alt="Favourite Icon" class="btn-profile-img">`;
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