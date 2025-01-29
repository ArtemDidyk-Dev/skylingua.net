<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerFavourites extends Model
{
    use HasFactory;

    protected $table = 'freelancer_favourites';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function getFavourites($employer_id) {
        $favourites = FreelancerFavourites::where('employer_id', $employer_id)
            ->get();

        return $favourites;
    }

    public static function getFavourite($employer_id, $freelancer_id) {
        $favourite = FreelancerFavourites::where('employer_id', $employer_id)
            ->where('freelancer_id', $freelancer_id)
            ->first();

        return $favourite;
    }

    public static function addFavourites($employer_id, $freelancer_id) {
        $favourites = FreelancerFavourites::create([
            'employer_id' => $employer_id,
            'freelancer_id' => $freelancer_id
        ]);

        return $favourites;
    }

    public static function removeFavourites($employer_id, $freelancer_id) {
        $favourite = FreelancerFavourites::where('employer_id', $employer_id)
            ->where('freelancer_id', $freelancer_id)
            ->delete();

        return $favourite;
    }

}
