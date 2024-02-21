<x-layout>
	<x-inc.single.layout>

		<x-slot name="breadcrumbs">
			<x-inc.breadcrumbs
				theme="white"
				:items="[
					[
						'title'	=> 'Projects',
						'link'	=> route('frontend.project.index'),
					],
					[
						'title'	=> $project->name,
					],
				]"
			/>
		</x-slot>

		<x-slot name="profileTop">
			<x-inc.single.project.top
				name="{!! $project->name !!}"
				price="{{$project->price}}"
				priceView="{{$project->price_view}}"
				:category="$projects_categories"
			/>
		</x-slot>

		<x-slot name="profileLeft">
		<x-inc.single.project.description
		photo="{{$project->user_profile_photo}}"
		name="{{$project->user_name}}"
		created="{{$project->created_at_view}}"
		rating="{{$average_rating}}"
		ratingCount="{{$reviews_count}}"
		/>
		</x-slot>
		<x-slot name="profiledescription">
			<x-inc.single.project.details
			:project="$project"
			data="{{\Carbon\Carbon::parse($project->deadline)->format('M d, Y')}}"
			geo="{{$project->user_country_name}}"
			geoImg="{{$project->user_country_image}}"
			proposals="{{$project->proposals_count}}"
			priceType="{{ $project->price_type == 1 ? language('Fixed Price') : ($project->price_type == 2 ? language('Hourly Pricing') : language('Bidding Price')) }}"
			favourites="{{$project->favourites}}"
			id="{{ $project->user_id }}"
			status="{{$project->status }}"
			proposal="{{$proposal}}"
			/>
			<x-inc.single.project.review-form toId="{{$project->user_id}}" projectId="{{$project->id}}"

			/>
		</x-slot>
		<x-slot name="overview">
			<x-inc.single.project.overview
			content="{!! $project->description !!}"
				/>

		</x-slot>
		<x-slot name="about">
			<x-inc.single.project.reviews :reviews="$reviews" />
		</x-slot>

		<x-slot name="modal">
			<x-inc.single.project.model
				proposal="{{ $proposal }}"
				status="{{ $project->status }}"
				id="{{ $project->id }}"
			/>
		</x-slot>

		<x-slot name="projects">
			<x-inc.single.project.slider
				:projects="$projects"
			/>
		</x-slot>


	</x-inc.single.layout>

	@push('css')
	<style>

	</style>
	@endPush

	@push('meta')

	<title>{!! $project->name ." - Projects" !!}</title>
	<meta name="description" content="{{language('frontend.project.description')}}">
	<meta name="keywords" content="{{language('frontend.project.keywords')}}">
	<link rel="stylesheet" href="/css/swiper-bundle.min.css" />
	<script src="/js/swiper-bundle.min.js"></script>
	@endPush


	</x-layout>
