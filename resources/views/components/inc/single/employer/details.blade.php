<h3>{{ language('Information:') }}</h3>
<x-inc.single.text-line title="{{ language('Rating') }}">
    <x-inc.previews.rating ratingStars="{{ $rating }}" ratingCount="{{ $ratingCount }}" />
</x-inc.single.text-line>
<x-inc.single.text-line title="{{ language('Company Name') }}">
    {{ $name }}
</x-inc.single.text-line>
@if ($established)
    <x-inc.single.text-line title="{{ language('Company Established') }}">
        {{ $established }}
    </x-inc.single.text-line>
@endif
<x-inc.single.text-line title="{{ language('Designation') }}">
    {{ $categoryName }}
</x-inc.single.text-line>
@if ($owner)
    <x-inc.single.text-line title="{{ language('Owner Name') }}">
        {{$owner}}
    </x-inc.single.text-line>
@endif

<x-inc.single.text-line title="{{ language('Member Since') }}">
    {{ $data }}
</x-inc.single.text-line>
