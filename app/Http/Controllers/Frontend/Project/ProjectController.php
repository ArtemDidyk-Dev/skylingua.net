<?php

namespace App\Http\Controllers\Frontend\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectAddRequest;
use App\Http\Requests\Project\ProjectEditRequest;
use App\Models\Country\Country;
use App\Models\Project\Projects;
use App\Models\Project\ProjectsCategories;
use App\Models\ProjectFavourites;
use App\Models\ProjectProposals;
use App\Models\Reviews\Reviews;
use App\Models\Setting\Setting;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
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
        if (isset($request->price_type) && !empty($request->price_type)) {
            $filter['price_type'] = (int) $request->price_type;
        }
        if (isset($request->country) && !empty($request->country)) {
            $filter['country'] = (int) $request->country;
        }
        if (isset($request->project_category) && !empty($request->project_category)) {
            $filter['project_category'] = (int) $request->project_category;
        }


        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1,
            'approve' => 1,
            'limit' => 10
        ];
        $project_filter = array_merge($project_filter, $filter);
        $getProjects = Projects::getProjects($project_filter);


        $projects = [];
        if ($getProjects) {

            $project_favourites_arr = [];
            if (Auth::check()) {
                $project_favourites = ProjectFavourites::getFavourites($user_id);
                if ($project_favourites) {
                    foreach ($project_favourites as $project_favourite) {
                        $project_favourites_arr[$project_favourite->project_id] = $project_favourite->freelancer_id;
                    }
                }
            }


            foreach ($getProjects as $project) {

                $proposals_count = 0;
                $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($project->id);
                if ($getProposalsCount) {
                    $proposals_count = $getProposalsCount;
                }

                $diffInDays = Carbon::parse($project->created_at)->diffInDays();
                $showDiff = Carbon::parse($project->created_at)->diffForHumans();
                if ($diffInDays > 0) {
                    $showDiff .= ', ' . Carbon::parse($project->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                }

                $projects_categories_filter = [
                    'language_id' => $request->languageID
                ];
                $ProjectsCategories = ProjectsCategories::get($project->id, $projects_categories_filter);
                $projects_categories = [];
                if ($ProjectsCategories != null) {
                    foreach ($ProjectsCategories as $ProjectsCategory) {
                        $projects_categories[] = $ProjectsCategory->user_category_name;
                    }
                }

                $projects[] = [
                    'id' => $project->id,
                    'name' => $project->name,
                    'price_type' => $project->price_type,
                    'price' => $project->price,
                    'price_view' => ($project->price ? number_format($project->price, 2, ".", " ") : 0),
                    'country_name' => $project->user_country_name,
                    'country_image' => $project->user_country_image ? asset($project->user_country_image) : "",
                    'user_id' => $project->user_id,
                    'user_name' => $project->user_name,
                    'user_profile_photo' => $project->user_profile_photo ? asset('storage/profile/' . $project->user_profile_photo) : asset('storage/no-image.jpg'),
                    'created_at_view' => $showDiff,
                    'projects_categories' => $projects_categories,
                    'deadline' => $project->deadline,
                    'favourites' => (isset($project_favourites_arr[$project->id]) ? true : false),
                    'proposals_count' => $proposals_count
                ];
            } // foreach
        } // if


        $getProjectsMinMaxPrice = Projects::getProjectsMinMaxPrice($project_filter);


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
        $selectCountries = $countries->map(function ($country) {
            return [
                'title' => $country->name,
                'value' => $country->id,
            ];
        });

        return view('pages.services.list', compact(
            'getProjects',
            'projects',
            'getProjectsMinMaxPrice',
            'countries',
            'userCategories',
            'filter',
            'selectCountries',
            'firstElementCountry'
        )
        );
    }


    public function detail(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int) $request->id;

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $project_filter = [
            'language_id' => $request->languageID,
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        $project_favourites = false;
        if (Auth::check()) {
            $getFavourite = ProjectFavourites::getFavourite($user_id, $project_id);
            if ($getFavourite) {
                $project_favourites = true;
            }
        }

        $project->user_country_image = $project->user_country_image ? asset($project->user_country_image) : "";
        $project->user_profile_photo = $project->user_profile_photo ? asset('storage/profile/' . $project->user_profile_photo) : asset('storage/no-image.jpg');
        $project->links = $project->links ? json_decode($project->links) : [];
        $project->user_social = $project->user_social ? json_decode($project->user_social) : [];
        $project->description = $project->description ? htmlspecialchars_decode($project->description) : "";
        $project->price_view = $project->price ? number_format($project->price, 2, ".", " ") : 0;
        $project->document = $project->document ? explode("|", $project->document) : [];

        $diffInDays = \Carbon\Carbon::parse($project->created_at)->diffInDays();
        $showDiff = \Carbon\Carbon::parse($project->created_at)->diffForHumans();
        if ($diffInDays > 0) {
            $showDiff .= ', ' . \Carbon\Carbon::parse($project->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
        }
        $project->created_at_view = $showDiff;
        $project->favourites = $project_favourites;


        $project->proposals_count = 0;
        $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($project->id);
        if ($getProposalsCount) {
            $project->proposals_count = $getProposalsCount;
        }


        $projects_categories_filter = [
            'language_id' => $request->languageID,
        ];
        $projects_categories = ProjectsCategories::get($project_id, $projects_categories_filter);
        if ($projects_categories == null) {
            $projects_categories = [];
        }


        $projects_count = Projects::getProjectsCountByUserId($project->user_id);


        $proposal = ProjectProposals::getProposal($user_id, $project->id);


        $getReviews = Reviews::getReviewsByUserId($project->user_id);
        $reviews = [];
        $average_rating = 0;
        if ($getReviews) {
            foreach ($getReviews as $review) {
                $diffInDays = \Carbon\Carbon::parse($review->created_at)->diffInDays();
                $showDiff = \Carbon\Carbon::parse($review->created_at)->diffForHumans();
                if ($diffInDays > 0) {
                    $showDiff .= ', ' . \Carbon\Carbon::parse($review->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                }
                $review->review = str_replace("\r\n", "<br />", $review->review);
                $review->rating_view = number_format($review->rating, 1, ".", "");
                $review->created_at_view = $showDiff;
                $review->user_profile_photo = !empty($review->user_profile_photo) ? asset('storage/profile/' . $review->user_profile_photo) : asset('storage/no-photo.jpg');
                $reviews[] = $review;

                $average_rating = $average_rating + (float) $review->rating;
            }
            $reviews_count = count($reviews);
            if ($reviews_count > 0) {
                $average_rating = $average_rating / $reviews_count;
            }
            $average_rating = number_format($average_rating, 1, ".", "");
        }

        $socials = array_map(function($social) {
            return  [
                'link' => $social->link,
                'img' => "/images/icons/contacts-$social->name.svg",
            ];
        }, $project->user_social);
     
        return view('pages.services.single', compact(
            'auth_user',
            'user',
            'project',
            'projects_count',
            'projects_categories',
            'proposal',
            'reviews',
            'average_rating',
            'reviews_count',
            'socials'
            
        )
        );
    }


    public function ajaxList(Request $request)
    {


        return response()->json([
            'success' => true,
        ]);
    }


}