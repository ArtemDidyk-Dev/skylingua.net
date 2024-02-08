<x-layout>


<x-inc.single.layout>
	<x-slot name="breadcrumbs">
		<x-inc.breadcrumbs
			theme="white"
			:items="[
				[
					'title'	=> $user->name,

				],
			]"
		/>
	</x-slot>
	<x-slot name="profileLeft">
		<x-inc.single.employer.profile
		name="{{$user->name}}"
		category="{{$user->user_category_name}}"
		data="{{$user->created_at->format('M d, Y')}}"
		geo="{{ $user->user_country_name }}"
		gender="{{ $user->gender == 1 ? language('Male') : language('Famele') }}"
		rating="{{$average_rating}}"
		ratingCount="{{$reviews_count}}"
		profileLink="{{ $user->user_profile_link }}  "
		rate="{{$user->hourly_rate}}"
		proflieImg="{{ $user->profile_photo }}"
		id="{{$user->id}}"
		/>
	</x-slot>
	<x-slot  name="profiledescription">
		
	</x-slot>
	<x-slot name="overview">
		<x-inc.single.employer.overview
		description="{!! $user->description !!}"
		/>
		<x-inc.single.employer.reviews
		:reviews="$reviews"
		/>
	</x-slot>
	<x-slot name="about">
	
	</x-slot>
	<x-slot name="modal">

	</x-slot>
</x-inc.single.layout>

@push('meta')

<title>{{$user->name ." - Employer"}}</title>
<meta name="description" content="{{language('frontend.developer.description')}}">
<meta name="keywords" content="{{language('frontend.developer.keywords')}}">

@endPush

</x-layout>
