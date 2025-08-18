<div class="rating-stars-bg">
	<div class="rating-stars" style="width: {{round($ratingStars / 5 * 100, 4)}}%"></div>
</div>
<div class="rating-number">
	{{$ratingStars}} {{empty($ratingCount) ? "" : "($ratingCount)"}}
</div>