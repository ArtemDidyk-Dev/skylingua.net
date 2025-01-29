<?php

namespace App\Models\Slide;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Slide extends Model
{
    use HasFactory;

    protected $table = 'slides';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function slidesTranlations()
    {
        return $this->hasMany('App\Models\Slide\SlideTranslation','slide_id','id');
    }

    public static function getSlides($languageID) {

        $slides = Slide::where('language_id', $languageID)
            ->where('status', 1)
            ->join('slides_translations', 'slides.id', '=', 'slides_translations.slide_id')
            ->orderBy('sort', 'ASC')
            ->get();

        return $slides;

    }

}
