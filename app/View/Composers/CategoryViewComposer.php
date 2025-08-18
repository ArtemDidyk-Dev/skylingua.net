<?php

namespace App\View\Composers;

use App\Models\UserCategory\UserCategoryTranslation;
use Illuminate\View\View;

class CategoryViewComposer
{

    public static $categoryes;
    public function __construct()
    {
        if(!self::$categoryes) {
            self::$categoryes = UserCategoryTranslation::active()->limit(6)->get();
        }
    }

    public function compose(View $view): void
    {
        $view->with('categoryes', self::$categoryes);
    }
}
