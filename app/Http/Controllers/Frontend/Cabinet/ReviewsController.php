<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Reviews\Reviews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
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

        $getReviews = Reviews::getReviewsByUserId($user_id);
        $reviews = [];
        if ($getReviews) {
            foreach ($getReviews as $review) {
                $diffInDays = \Carbon\Carbon::parse($review->created_at)->diffInDays();
                $showDiff = \Carbon\Carbon::parse($review->created_at)->diffForHumans();
                if ($diffInDays > 0) {
                    $showDiff .= ', ' . \Carbon\Carbon::parse($review->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                }
                $review->review = str_replace("\r\n", "<br />", $review->review);
                $review->rating_view = number_format($review->rating, 1, ".", "" );
                $review->created_at_view = $showDiff;
                $review->user_profile_photo = !empty($review->user_profile_photo) ? asset('storage/profile/'. $review->user_profile_photo) : asset('storage/no-photo.jpg');
                $reviews[] = $review;
            }
        }

        return view('frontend.dashboard.freelancer.reviews', compact(
            'auth_user',
            'user',
            'reviews'
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

        $getReviews = Reviews::getReviewsByUserId($user_id);
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
                $review->rating_view = number_format($review->rating, 1, ".", "" );
                $review->created_at_view = $showDiff;
                $review->user_profile_photo = !empty($review->user_profile_photo) ? asset('storage/profile/'. $review->user_profile_photo) : asset('storage/no-photo.jpg');
                $reviews[] = $review;

                $average_rating = $average_rating+(float)$review->rating;
            }
            $reviews_count = count($reviews);
            if($reviews_count > 0) {
                $average_rating = $average_rating / count($reviews);
            }
            $average_rating = number_format($average_rating, 1, ".", "" );
        }

//        @dd($reviews);

        return view('frontend.dashboard.employer.reviews', compact(
            'auth_user',
            'user',
            'reviews'
        ));
    }


}
