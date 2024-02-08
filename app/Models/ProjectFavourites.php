<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFavourites extends Model
{
    use HasFactory;

    protected $table = 'project_favourites';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function getFavourites($freelancer_id) {
        $favourites = ProjectFavourites::where('freelancer_id', $freelancer_id)
            ->get();

        return $favourites;
    }

    public static function getFavourite($freelancer_id, $project_id) {
        $favourite = ProjectFavourites::where('freelancer_id', $freelancer_id)
            ->where('project_id', $project_id)
            ->first();

        return $favourite;
    }

    public static function addFavourites($freelancer_id, $project_id) {
        $favourites = ProjectFavourites::create([
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id
        ]);

        return $favourites;
    }

    public static function removeFavourites($freelancer_id, $project_id) {
        $favourite = ProjectFavourites::where('freelancer_id', $freelancer_id)
            ->where('project_id', $project_id)
            ->delete();

        return $favourite;
    }

}
