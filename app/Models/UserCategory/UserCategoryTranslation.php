<?php

namespace App\Models\UserCategory;

use App\Models\Reviews\Reviews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Projects;
use App\Models\User;
class UserCategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'user_categories_translations';
    protected $guarded = [];

    public function users() {
        return $this->hasMany(User::class, 'user_category', 'user_category_id' );
    }

    public function scopeActive($query)
    {
         return $query->with(['userCategory' =>function($q) {
            $q->where(['role_id' => 4, 'status' => 1]);
         }])
         ->whereHas('userCategory', function($q) {
            $q->where(['role_id' => 4, 'status' => 1]);
         })
         ->with(['users' => function($q) {
            $q->with("reviews")->where(['status' => 1, 'approve' => 1]);
          }])
          ->whereHas('users', function($q) {
            $q->with("reviews")->where(['status' => 1, 'approve' => 1]);
          });
      
    }

    public function userCategory() 
    {
        return $this->hasMany(UserCategory::class, 'id', 'user_category_id');
    }

}
