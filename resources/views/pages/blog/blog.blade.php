<x-layout>


    <div class="container">
        <x-inc.breadcrumbs :items="[
            [
                'title' => 'Blog',
                'link' => '/',
            ],
        ]" />
        <div class="blogs">
            <h1>
                {{ language('Feature Blog') }}
            </h1>
            @if ($blogs)
                <div class="posts__inner">
                    @foreach ($blogs as $blog)
                        <x-inc.previews.post photo="{{ empty($blog->image) ? asset('storage/no-image.png') : \App\Services\ImageService::resizeImageSize($blog->image, 'medium', 80) }}"
                            title="{!! $blog->name !!}"
                            description="{!! $blog->description !!}"
                            data="{{$blog->updated_at->format('d M Y')}}"
                            link="{{ route('frontend.blog.detail', $blog->slug) }}" />
                    @endforeach
                </div>
                {{ $blogs->appends(['search' => isset($searchText) ? $searchText : null])->render('components.inc.pagination') }}
            @else
                <p>{{ language('No Blogs') }}</p>
            @endif
        </div>
    </div>


    @push('meta')
        <title>
            {{ empty(language('frontend.blog.title')) ? language('frontend.blog.name') : language('frontend.blog.title') }}
        </title>
        <meta name="description" content="{{ language('frontend.blog.description') }}">
        <meta name="keywords" content="{{ language('frontend.blog.keywords') }}">
    @endPush


</x-layout>
