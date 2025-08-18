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
            <div class="posts__bottom">
                <x-inc.btns.all color="blue" title="{{ language('SEE ALL BLOGS') }}" link="{{ route('frontend.blog.index') }}" >
                </x-inc.btns.all>
            </div>
        </div>

    </div>
</section>

