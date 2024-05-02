<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">

	<head>
		@include('inc.head')
	</head>

	<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M3MM5P3V"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
		<x-inc.header />
		<div class="main-content">
			{{ $slot }}
		</div>
		<x-inc.footer />
		@stack('css')
		@stack('js')
        <script src="{{ mix('js/app.js') }}"></script>
	</body>

</html>
