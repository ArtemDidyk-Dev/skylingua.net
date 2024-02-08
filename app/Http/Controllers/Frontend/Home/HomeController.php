<?php

namespace App\Http\Controllers\Frontend\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slide\ContactSendRequest;
use App\Mail\Frontend\SendMail;
use App\Models\Blog\Blog;
use App\Models\Blog\Faq;
use App\Models\FreelancerFavourites;
use App\Models\Partner\Partner;
use App\Models\Post\Post;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Project\Projects;
use App\Models\Project\ProjectsCategories;
use App\Models\ProjectFavourites;
use App\Models\ProjectProposals;
use App\Models\Review\Review;
use App\Models\Reviews\Reviews;
use App\Models\Service\Service;
use App\Models\Slide\Slide;
use App\Models\Team\Team;
use App\Models\User;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\UserCategory\UserCategoryTranslation;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        $user_id = Auth::id();
        $freelancer_filter = [
            'language_id' => $request->languageID,
            'limit' => 9,
        ];
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

        $project_filter = [
            'language_id' => $request->languageID,
            'approve' => 1,
            'status' => 1,
        ];
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
                    'name' => html_entity_decode($project->name, ENT_QUOTES, 'UTF-8'),
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
                    'proposals_count' => $proposals_count,
                    'description' => $project->description ? htmlspecialchars_decode($project->description) : "",
                ];
            } // foreach
        } // if
//        @dd($projects);

        $blogs = Blog::getBlogs($request->languageID, 3)->map(function($blog) {
            $blog->updated_at = Carbon::parse($blog->updated_at);
            return $blog;
        });
        

        $employerCount = User::getEmployerCount();
        $freelancersCount = User::getFreelancerCount();
        $projectsCount = Projects::getProjectsCount();
        $categories = UserCategoryTranslation::active()
            ->limit(7)
            ->get();
        $categories = $categories->map(function ($category) {
            $category->users = $category->users->take(2);
            return $category;
        });

        return view('pages.home', compact(
            'freelancers',
            'categories',
            'getProjects',
            'projects',
            'employerCount',
            'freelancersCount',
            'projectsCount',
            'blogs',
        )
        );
    }


    public function contact(Request $request)
    {

        $socials = array_map(function ($social) {
            return [
                'link' => $social->link,
                'img' => "/images/icons/contacts-$social->name.svg",
            ];
        }, json_decode(setting('social')));
        return view('pages.contacts', compact('socials'));
    }

    public function contactSendAjax(Request $request)
    {
        $name = $request->name;
        $subject = ($request->subject ? $request->subject : "");
        $email = $request->email;
        $message = $request->message;
        $data = [
            'name' => $name,
            'subject' => $subject,
            'email' => $email,
            'message' => $message,
        ];

        $responseData = [];

        if (empty($data['name'])) {
            $responseData['name'] = language('frontend.contact.form_error_name');

        }

        if (empty($data['email'])) {
            $responseData['email'] = language('frontend.contact.form_error_email');
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $responseData['email'] = language('frontend.contact.form_error_email_invalid');
            }
        }


        if (empty($data['message'])) {
            $responseData['message'] = language('frontend.contact.form_error_message');
        }


        if (!empty($data['name']) && !empty($data['email']) && !empty($data['message']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            $toMail = setting('email');

            Mail::to($toMail)
                ->send(new SendMail($data));

            return response()->json(['success' => true, 'data' => language('frontend.contact.form_success')]);
        } else {
            return response()->json([
                'error' => true,
                'data' => $responseData
            ]);
        }


    }




}
