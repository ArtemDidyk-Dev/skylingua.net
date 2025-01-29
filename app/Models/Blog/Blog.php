<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function blogsTranlations()
    {
        return $this->hasMany('App\Models\Blog\BlogTranslation','blog_id','id');
    }

    public static function getBlogs($languageID, $limit = 10) {

        $blogs = Blog::where('language_id', $languageID)
            ->where('status', 1)
            ->join('blogs_translations', 'blogs.id', '=', 'blogs_translations.blog_id')
            ->orderBy('sort', 'ASC')
            ->paginate($limit);

        return $blogs;

    }

    public static function getBlog($languageID, $slug) {

        $blog = Blog::where('language_id', (int)$languageID)
            ->join('blogs_translations', 'blogs.id', '=', 'blogs_translations.blog_id')
            ->where('status', 1)
            ->where('slug', stripinput($slug))
            ->first();

        return $blog;

    }

}
