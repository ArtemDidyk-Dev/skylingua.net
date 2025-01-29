<?php

namespace App\Models\UserCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    protected $table = 'user_categories';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function userCategoriesTranlations()
    {
        return $this->hasMany('App\Models\UserCategory\UserCategoryTranslation','user_category_id','id');
    }

    public static function getUserCategories($data = []) {

        $user_categories = UserCategory::where('language_id', $data['languageID'])
            ->where('status', 1)
            ->where('role_id', $data['role_id'] ? (int)$data['role_id'] : "")
            ->join('user_categories_translations', 'user_categories.id', '=', 'user_categories_translations.user_category_id')
            ->orderBy('sort', 'ASC')
            ->limit( isset($data['limit']) && $data['limit'] > 0 ? (int)$data['limit'] : 9 )
            ->get();

        return $user_categories;

    }

    
}
