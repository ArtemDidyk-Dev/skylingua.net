<?php

namespace App\Http\Controllers\Frontend\Page;

use App\Http\Controllers\Controller;
use App\Models\Page\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{


    public function page(Request $request)
    {

        $page = Page::where('language_id', $request->languageID)
            ->where('status', 1)
            ->where('slug', $request->slug)
            ->join('pages_translations', 'pages.id', '=', 'pages_translations.page_id')
            ->select(
                '*',
                'pages.updated_at as updated_at',
            )
            ->first();


        if (!$page) {
            abort(404);
        }

        $content = html_entity_decode( $page->text, ENT_QUOTES, 'UTF-8');;
        $h1 = $page->name;
        $title = empty($page->title) ? $page->name : $page->title;
        $decription = $page->description;
        $keywords = $page->keyword;
        $breadcrumbs = [
            [
                'title' => $h1,
            ],
        ];
        
        return view('pages.standart', compact(
            'page',
            'content',
            'h1',
            'title',
            'decription',
            'keywords',
            'breadcrumbs'
        )
        );
    }


}