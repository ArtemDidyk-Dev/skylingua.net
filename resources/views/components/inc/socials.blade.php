<div class="contacts-socials {{$class ?? ''}}">
	@foreach ($links as $link)
		<a href="{{$link['link']}}" class="contacts-social" rel="nofollow" target="_blank">
			<img src="{{ asset('build/website/' . $link['img']) }}" alt="" class="contacts-social-img">
		</a>
	@endforeach
</div>
