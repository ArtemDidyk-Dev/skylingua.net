@if (!empty($reviews))

    @foreach ($reviews as $review)
        <x-inc.single.project.review name="{{ $review->from }}" text="{!! $review->review !!}"
                                     rating="{{ $review->rating_view }}" data="{{ $review->created_at_view }}"/>
    @endforeach

@else

    <div class="single-overview-not-found">
        <x-inc.single.title class="single-overview-title-reviews">
            {{ language('Reviews') }}
        </x-inc.single.title>
        No {{ language('Reviews') }}

    </div>

@endif
