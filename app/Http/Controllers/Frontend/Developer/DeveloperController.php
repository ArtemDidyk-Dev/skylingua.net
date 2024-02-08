<?php

namespace App\Http\Controllers\Frontend\Developer;

use App\Http\Controllers\Controller;
use App\Models\Country\Country;
use App\Models\FreelancerFavourites;
use App\Models\Project\Projects;
use App\Models\Project\ProjectsCategories;
use App\Models\Reviews\Reviews;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{

    public function index(Request $request)
    {
        
        $user_id = Auth::id();

        $filter = [];

        if (isset($request->keyword) && !empty($request->keyword)) {
            $filter['keyword'] = stripinput(strip_tags($request->keyword));
        }
        if (isset($request->minPrice) && !empty($request->minPrice)) {
            $filter['minPrice'] = (float) $request->minPrice;
        }
        if (isset($request->maxPrice) && !empty($request->maxPrice)) {
            $filter['maxPrice'] = (float) $request->maxPrice;
        }
        if (isset($request->country) && !empty($request->country)) {
            $filter['country'] = (int) $request->country;
        }
        if (isset($request->user_category) && !empty($request->user_category)) {
            $filter['user_category'] = (int) $request->user_category;
        }

        $freelancer_filter = [
            'language_id' => $request->languageID,
            'limit' => 10,
        ];
        $freelancer_filter = array_merge($freelancer_filter, $filter);
        $freelancers = User::getFreelancer($freelancer_filter);

        if ($freelancers) {

            $freelancer_favourites_arr = [];
            if (Auth::check()) {
                $freelancer_favourites = FreelancerFavourites::getFavourites($user_id);
                if ($freelancer_favourites) {
                    foreach ($freelancer_favourites as $freelancer_favourite) {
                        $freelancer_favourites_arr[$freelancer_favourite->freelancer_id] = $freelancer_favourite->employer_id;
                    }
                }
            }

            foreach ($freelancers as $freelancer_key => $freelancer) {
                $freelancers[$freelancer_key] = $freelancer;
                $freelancers[$freelancer_key]->favourites = (isset($freelancer_favourites_arr[$freelancer->id]) ? true :
                    false);

                $freelancers[$freelancer_key]->reviews_count = $freelancer->reviews_count;
                $freelancers[$freelancer_key]->average_rating = $freelancer->average_rating != null ? number_format($freelancer->average_rating, 1, ".", "") : "0.0";

            }
        }


        $freelancersMinMaxPrice = User::getFreelancerMinMaxPrice();

        $countries_filter = [
            'languageID' => $request->languageID,
            'limit' => 999
        ];
        $countries = Country::getCountries($countries_filter);

        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 999,
            'role_id' => 4
        ];
        $userCategories = UserCategory::getUserCategories($userCategories_filter);


        $firstElementCountry = $countries
            ->filter(function ($country) use ($filter) {
                return isset($filter['country']) && $filter['country'] == $country->id;
            })
            ->first();

        $firstElementCategory = $userCategories
            ->filter(function ($categories) use ($filter) {
                return isset($filter['user_category']) && $filter['user_category'] == $categories->id;
            })
            ->first();

        $selectCountries = $countries->map(function ($country) {
            return [
                'title' => $country->name,
                'value' => $country->id,
            ];
        });

        return view(
            'pages.freelancers.list',
            compact(
                'freelancers',
                'freelancersMinMaxPrice',
                'countries',
                'userCategories',
                'filter',
                'selectCountries',
                'firstElementCountry',
                'firstElementCategory'
            )
        );
    }



}