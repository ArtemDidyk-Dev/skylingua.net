<section class="posts">
    <div class="container">
        <h2>{{ language('Feature') }} {{ language('Blog') }}</h2>

        <div class="posts__inner">
            @foreach ($blogs as $blog)
                <x-inc.previews.post
                    photo="{{ empty($blog->image) ? asset('storage/no-image.png') : \App\Services\ImageService::resizeImageSize($blog->image, 'medium', 80) }}"
                    title="{{ $blog->name }}" description="{{ $blog->description }}"
                    link="{{ route('frontend.blog.detail', $blog->slug) }}"
                    data="{{$blog->updated_at->format('d M Y')}}"
                    />
                @endforeach
        </div>
        <div class="posts__bottom">
            <x-inc.btns.link-svg class="full-pink" title="{{ language('SEE ALL BLOGS') }}"
                    href="{{ route('frontend.blog.index') }}" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path d="M8.12402 17.5L16.124 9.5M16.124 9.5H8.12402M16.124 9.5V17.5" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </x-inc.btns.link-svg>
        </div>
       
    </div>
</section>

