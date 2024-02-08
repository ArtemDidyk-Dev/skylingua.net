<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
	
	<head>
		@include('inc.head')        
	</head>

	<body>
		<x-inc.header />
		<div class="main-content">
			{{ $slot }}
		</div>	
		<x-inc.footer />
		@stack('css')
		@stack('js')
		<script src="{{ asset('build/website/js/app.js') }}"></script>
	</body>
    
</html>