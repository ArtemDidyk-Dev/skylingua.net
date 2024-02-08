@if (!empty($reviews))
    <div class="single-freelancer-review__wrapper">
        <x-inc.single.title class="single-overview-title-reviews">
            {{ language('Reviews') }}
        </x-inc.single.title>
        @foreach ($reviews as $review)
            <x-inc.single.freelancer.review name="{{ $review->user_name }}" text="{!! $review->review !!}"
                rating="{{ $review->rating_view }}" data="{{ $review->created_at_view }}" />
        @endforeach
    </div>
@else
    <div class="single-freelancer-review__wrapper">
        <div class="single-overview-not-found">
            <x-inc.single.title class="single-overview-title-reviews">
                {{ language('Reviews') }}
            </x-inc.single.title>
            No {{ language('Reviews') }}
        </div>
    </div>
@endif
