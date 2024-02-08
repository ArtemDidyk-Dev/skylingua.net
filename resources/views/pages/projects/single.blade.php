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
	
	<x-slot name="profileLeft">
	<x-inc.single.project.description
	proposal="{{$proposal}}"
	name="{!! $project->name !!}"
	createdAtView="{{$project->created_at_view}}"
	price="{{$project->price}}"
	priceView="{{$project->price_view}}"
	priceType="{{ $project->price_type == 1 ? language('Fixed Price') : ($project->price_type == 2 ? language('Hourly Pricing') : language('Bidding Price')) }}" />
	</x-slot>
	<x-slot name="profiledescription">
		<x-inc.single.project.details
		data="{{\Carbon\Carbon::parse($project->deadline)->format('M d, Y')}}"
		geo="{{$project->user_country_name}}"
		geoImg="{{$project->user_country_image}}"
		proposals="{{$project->proposals_count}}"
		priceType="{{ $project->price_type == 1 ? language('Fixed Price') : ($project->price_type == 2 ? language('Hourly Pricing') : language('Bidding Price')) }}"
		favourites="{{$project->favourites}}"
		id="{{ $project->id }}"
		status="{{$project->status }}"
		proposal="{{$proposal}}"
		/>
	</x-slot>
	<x-slot name="overview">
		<x-inc.single.project.overview
		content="{!! $project->description !!}"
			/>
		<x-inc.single.project.tags
		:tags="$projects_categories"
		
				/>
		<x-inc.single.project.links
		:links="$project->links"
		:documents="$project->document"		
		/>
	</x-slot>
	<x-slot name="about">
		<x-inc.single.project.client
		profileLink="{{route('frontend.profile.index', $project->user_id)}}"
		photo="{{$project->user_profile_photo}}"
		name="{{$project->user_name}}"
		posted="{{\Carbon\Carbon::parse($project->user_created_at)->format('M d, Y')}}"
		country="{{$project->user_country_name}}"
		category="{{$project->user_category_name}}"
		rating="{{$average_rating}}"
		ratingCount="{{$reviews_count}}"
		projectsCount="{{$projects_count}}"
		userProfile="{{$project->user_id}}"
		:socials="$socials"
		
			/>

	</x-slot>

	<x-slot name="modal">
		<x-inc.single.project.model
			proposal="{{ $proposal }}"
			status="{{ $project->status }}"
			id="{{ $project->id }}"
		/>
	</x-slot>



</x-inc.single.top>

@push('css')
<style>

</style>
@endPush

@push('meta')

<title>{!! $project->name ." - Projects" !!}</title>
<meta name="description" content="{{language('frontend.project.description')}}">
<meta name="keywords" content="{{language('frontend.project.keywords')}}">

@endPush


</x-layout>
