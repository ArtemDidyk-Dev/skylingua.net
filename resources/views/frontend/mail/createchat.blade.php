{{ language('User from:') }}

<a href="{{ route('frontend.profile.index', $data['user_from']->id) }}">
    <img class="rounded-circle mx-auto"
         src="{{ asset($data['user_from']->profile_photo ? 'storage/profile/'. $data['user_from']->profile_photo : 'storage/no-photo.jpg') }}"
         alt="{{ $data['user_from']->name }}"
         width="100"
         height="100"
         style="width: 100px; height: 100px;"
    >
    <span class="online">{{ $data['user_from']->name }}</span>
</a>

{{ language('entered the chat') }}

{{ language('User to:') }}

<a href="{{ route('frontend.profile.index', $data['user_to']->id) }}">
    <img class="rounded-circle mx-auto"
         src="{{ asset($data['user_to']->profile_photo ? 'storage/profile/'. $data['user_to']->profile_photo : 'storage/no-photo.jpg') }}"
         alt="{{ $data['user_to']->name }}"
         width="100"
         height="100"
         style="width: 100px; height: 100px;"
    >
    <span class="online">{{ $data['user_to']->name }}</span>
</a>