<?php

namespace App\Http\Controllers\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use Illuminate\Http\Request;
use Carbon\Carbon;
class BlogController extends Controller
{

    public function index(Request $request)
    {
        
        $blogs = Blog::getBlogs($request->languageID, 9);
        
        return view('pages.blog.blog', compact(
            'blogs',
        )
        );
    }

    public function detail(Request $request)
    {
        $page = Blog::getBlog($request->languageID, $request->slug);
        if ($page == null) {
            return redirect()->back();
        }

        $content = html_entity_decode( $page->text, ENT_QUOTES, 'UTF-8');;
        $h1 = $page->name;
        $title = empty($page->title) ? $page->name : $page->title;
        $decription = $page->description;
        $keywords = $page->keyword;
        $data =  Carbon::parse($page->updated_at)->format('d M Y');
        $breadcrumbs = [
            [
                'title' => 'Blog',
                'link' => '/blogs',
            ],
            [
                'title' => $h1
            ]
        ];
        return view('pages.blog.standart', compact(
            'content',
            'page',
            'data',
            'h1',
            'title',
            'decription',
            'keywords',
            'breadcrumbs'
        )
        );
    }

}