<?php

namespace App\View\Composers;

use App\Models\Project\ProjectsCategories;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryViewComposer
{   

    public static $approvedProjectsWithCategories;
    public static $categoryes;
    public function __construct(Request $request)
    {
        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1,
            'approve' => 1,
        ];

        if(!self::$categoryes) {
            self::$categoryes = ProjectsCategories::getCategories($project_filter)->take(7);
        }
    }

    public function compose(View $view): void
    {
        $view->with('categoryes', self::$categoryes);
    }
}