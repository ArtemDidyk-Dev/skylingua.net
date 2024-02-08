<div class="single-project-description-btns">
    @if (auth()->check())
        @if (\App\Services\CommonService::userRoleId(auth()->id()) == 3)
        @if ($favourites)
            <x-inc.btns.profile attribute="data-project_id={{ $id }}" link="javascript:void(0)"
            color="transparent" classMod="projectAddFavorite favourited"
            image="{{ asset('build/website/images/icons/favourite-on.svg') }}" title="{{ language('In favorites') }}" />
            @else
                <x-inc.btns.profile attribute="data-project_id={{ $id }}" link="javascript:void(0)"
                color="transparent" classMod="projectAddFavorite"
            image="{{ asset('build/website/images/icons/favourite.svg') }}" title="{{ language('Favourite') }}" />
            @endif
        @endif
    @else   
        <x-inc.btns.profile link="{{ route('frontend.login.index') }}" color="transparent"
            image="{{ asset('build/website/images/icons/favourite.svg') }}" title="{{ language('Favourite') }}" />
       
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