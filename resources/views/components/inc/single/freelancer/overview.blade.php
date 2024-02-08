
<div class="single-overview">
	<x-inc.single.title class="single-overview-title">
		{{ language('Overview') }}
	</x-inc.single.title>
	@if ($description)
	<div class="content">
		{!! $description !!}
	</div>	
	@else
		<div class="content">
			No {{ language('Overview') }}
		</div>
	@endif
</div>
