<div class="single-project-client-body">
    <div class="single-progect-client__wrapper">
        <x-inc.single.project.user photo="{{ $photo }}" name="{{ $name }}" :socials="$socials"  profileLink="{{$profileLink}}"
            country="{{ $country }}" />

        <x-inc.single.project.client-info category="{{ $category }}" rating="{{ $rating }}"
            ratingCount="{{ $ratingCount }}" projectsCount="{{ $projectsCount }}" />
    </div>
    <x-inc.single.project.user-descrip posted="{{ $posted }}" country="{{ $country }}" />

</div>
