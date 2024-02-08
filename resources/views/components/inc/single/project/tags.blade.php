@if ($tags)
   <div class="single-tag__wrapper">
    <x-inc.single.title class="single-project-overview-title">
        {{ language('Desired areas of expertise') }}
    </x-inc.single.title>
    <div class="single-project-overview-tags">
        @foreach ($tags as $tag)
            <x-inc.single.tag title="{{ $tag->user_category_name }}" class="right-offset blue" />
        @endforeach
    </div>
   </div>
@endif
