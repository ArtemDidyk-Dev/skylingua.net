<div class="wrapper__rewview">
    <x-inc.single.title class="single-overview-title-reviews">
        {{ language('Reviews') }}
    </x-inc.single.title>
    @if (!empty($reviews))
        @foreach($reviews as $review)
            <x-inc.single.employer.review 
                name="{{$review->user_name}}" 
                text="{!! $review->review !!}" 
                rating="{{$review->rating_view}}" 
                data="{{$review->created_at_view}}" />
        @endforeach
    @else
        <div class="single-overview-not-found">
            No {{ language('Reviews') }}
        </div>
    @endif
</div>