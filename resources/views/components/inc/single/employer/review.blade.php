<div class="single-freelancer-review">
	<div class="single-freelancer-review-title">
		{{$name}}
		<div class="single-freelancer-review-title-date">
			{{$data}}
		</div>
	</div>
	<div class="single-freelancer-review-rating">
		<x-inc.previews.rating
			ratingStars="{{$rating}}"
		/>
	</div>
	<div class="single-freelancer-review-text">
		{!! $text !!}
	</div>
</div>

@push('css')
<style>
.single-freelancer-review {
	padding: 16px;
	background-color: #F5F5F5;
	border-radius: 12px;
	margin-bottom: 12px;
}

.single-freelancer-review:nth-last-child(1) {
	margin-bottom: 0;
}

.single-freelancer-review-title {
	display: flex;
	align-items: center;
	justify-content: space-between;
	font-size: 14px;
	line-height: 22px;
	margin-bottom: 4px;
	font-weight: 600;
}

.single-freelancer-review-title-date {
	font-weight: 400;
	color: #5C5C5C;
}

.single-freelancer-review-rating {
	display: flex;
	margin-bottom: 10px;
	align-items: center;
}

.single-freelancer-review-text {
	font-size: 14px;
	line-height: 22px;
}
</style>
@endPush