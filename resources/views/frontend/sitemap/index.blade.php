<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    {{--   HomePage--}}
    <url>
        <loc>{{ route('frontend.home.index') }}</loc>
{{--        <lastmod>{{ \Carbon\Carbon::now()->toDateString()}}</lastmod>--}}
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>

    {{--   ContactPage--}}
    <url>
        <loc>{{ route('frontend.home.contact') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>

    {{--   ServicePage--}}
    <url>
        <loc>{{ route('frontend.service.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>

   {{--    ServiceDetail--}}
    @foreach($services as $service)
    <url>
        <loc>{{ route('frontend.service.detail',$service->slug) }}</loc>
        <changefreq>weekly</changefreq>
        <lastmod>{{ \Illuminate\Support\Carbon::parse($service->updated_at)->format('Y-m-d') }}T{{ \Illuminate\Support\Carbon::parse($service->updated_at)->format('H:i:s') }}+03:00</lastmod>
        <priority>1.0</priority>
    </url>
    @endforeach

    {{--   BlogsPage--}}
    <url>
        <loc>{{ route('frontend.post.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>

    {{--   BlogsDetail--}}
    @foreach($posts as $post)
        <url>
            <loc>{{ route('frontend.post.detail',$post->slug) }}</loc>
            <changefreq>weekly</changefreq>
            <lastmod>{{ \Illuminate\Support\Carbon::parse($post->updated_at)->format('Y-m-d') }}T{{ \Illuminate\Support\Carbon::parse($post->updated_at)->format('H:i:s') }}+03:00</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach


    {{--   TeamsPage--}}
    <url>
        <loc>{{ route('frontend.team.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>

    {{--   TeamsDetail--}}
    @foreach($teams as $team)
        <url>
            <loc>{{ route('frontend.team.detail',$team->slug) }}</loc>
            <changefreq>weekly</changefreq>
            <lastmod>{{ \Illuminate\Support\Carbon::parse($team->updated_at)->format('Y-m-d') }}T{{ \Illuminate\Support\Carbon::parse($team->updated_at)->format('H:i:s') }}+03:00</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach

    {{--   Pages--}}
    @foreach($pages as $page)
        <url>
            <loc>{{ route('frontend.page.index',$page->slug) }}</loc>
            <changefreq>weekly</changefreq>
            <lastmod>{{ \Illuminate\Support\Carbon::parse($page->updated_at)->format('Y-m-d') }}T{{ \Illuminate\Support\Carbon::parse($page->updated_at)->format('H:i:s') }}+03:00</lastmod>
            <priority>1.0</priority>
        </url>
    @endforeach

</urlset>
