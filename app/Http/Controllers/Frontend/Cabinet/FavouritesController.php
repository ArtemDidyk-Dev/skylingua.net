<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\FreelancerFavourites;
use App\Models\Project\Projects;
use App\Models\Project\ProjectsCategories;
use App\Models\ProjectFavourites;
use App\Models\Reviews\Reviews;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritesController extends Controller
{

    public function __construct()
    {

    }

    public function freelancer(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $favourites = [];
        $favourites_total = 0;
        $getFavourites = ProjectFavourites::getFavourites($user_id);
        if ($getFavourites) {
            foreach ($getFavourites as $getFavourite) {
                $project_filter = [
                    'language_id' => $request->languageID
                ];
                $getProject = Projects::getProject($getFavourite->project_id, $project_filter);
                if ($getProject) {

                    $projects_categories_filter = [
                        'language_id' => $request->languageID
                    ];
                    $ProjectsCategories = ProjectsCategories::get($getProject->id, $projects_categories_filter);
                    $projects_categories = [];
                    if ($ProjectsCategories != null) {
                        foreach ($ProjectsCategories as $ProjectsCategory) {
                            $projects_categories[] = $ProjectsCategory->user_category_name;
                        }
                    }

                    $diffInDays = Carbon::parse($getProject->created_at)->diffInDays();
                    $showDiff = Carbon::parse($getProject->created_at)->diffForHumans();
                    if ($diffInDays > 0) {
                        $showDiff .= ', ' . Carbon::parse($getProject->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                    }

                    $getProject->user_profile_photo = $getProject->user_profile_photo ? asset('storage/profile/'. $getProject->user_profile_photo) : asset('storage/no-image.jpg');
                    $getProject->user_country_image = $getProject->user_country_image ? asset( $getProject->user_country_image) : "";
                    $getProject->price_view = ($getProject->price ? number_format($getProject->price, 2, ".", " ") : 0);
                    $getProject->created_at_view = $showDiff;
                    $getProject->projects_categories = $projects_categories;
                    $getProject->favourites = true;
                    $favourites[] = $getProject;
                }
            } // foraech

            $favourites_total = count($favourites);
        } // if

//        @dd($favourites);


        return view('frontend.dashboard.freelancer.favourites', compact(
            'auth_user',
            'user',
            'favourites',
            'favourites_total'
        ));
    }

    public function employer(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $favourites = [];
        $getFavourites = FreelancerFavourites::getFavourites($user_id);
        if ($getFavourites) {
            foreach ($getFavourites as $getFavourite) {
                $freelancer_filter = [
                    'language_id' => $request->languageID,
                ];
                $getUser = User::getUserInfo($getFavourite->freelancer_id, $freelancer_filter);
                if ($getUser) {
                    $getUser->favourites = true;

                    $getUser->reviews_count = $getUser->reviews_count;
                    $getUser->average_rating = $getUser->average_rating != null ? number_format($getUser->average_rating, 1, ".", "" ) : "0.0";

                    $favourites[] = $getUser;
                }
            } // foraech
        } // if


        return view('frontend.dashboard.employer.favourites', compact(
            'auth_user',
            'user',
            'favourites'
        ));
    }


}
