<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function pagesTranlations()
    {
        return $this->hasMany('App\Models\Page\PageTranslation','page_id','id');
    }

}
