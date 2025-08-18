<div class="single-freelancer-review">
	<div class="single-freelancer-review-title">
		{{$name}}
		<div class="single-freelancer-review-title-date">
			{{$data}}
		</div>
	</div>
	<div class="single-freelancer-review-rating">
		<x-inc.previews.rating-full
			ratingStars="{{$rating}}"
		/>
	</div>
	<div class="single-freelancer-review-text">
		{!! $text !!}
	</div>
</div>
