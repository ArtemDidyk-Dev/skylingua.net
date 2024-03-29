<?php

namespace App\Models\Reviews;

use App\DTO\ReviewDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function getReviews($user_id, $project_id) {
        $reviews = Reviews::select(
            'reviews.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo',
            'model_has_roles.role_id',
        )
            ->leftJoin('users', 'reviews.from', '=', 'users.id')
            ->join('model_has_roles', 'reviews.from', '=', 'model_has_roles.model_id')
            ->where('reviews.to', $user_id)
            ->where('reviews.project_id', $project_id)
            ->get();
        return $reviews;
    }

    public static function getReviewsCount($user_id, $project_id) {
        $reviewsCount = Reviews::where('to', $user_id)
            ->where('reviews.project_id', $project_id)
            ->count();

        return $reviewsCount;
    }

    public static function getReviewsByUserId($user_id) {

        $reviews = Reviews::select(
                'reviews.*',
                'users.id as user_id',
                'users.name as user_name',
                'users.profile_photo as user_profile_photo'
            )
            ->where('reviews.status', 1)
            ->leftJoin('users', 'reviews.from', '=', 'users.id')
            ->where('reviews.to', $user_id)
            ->get();

        return $reviews;
    }

    public static function getReviewsCountByUserId($user_id) {
        $reviewsCount = Reviews::where('to', $user_id)
            ->count();

        return $reviewsCount;
    }

    public static function getReviewsByProjectId($project_id) {
        $reviews = Reviews::select(
                'reviews.*',
                'users.id as user_id',
                'users.name as user_name',
                'users.profile_photo as user_profile_photo'
            )
            ->leftJoin('users', 'reviews.from', '=', 'users.id')
            ->where('reviews.project_id', $project_id)
            ->where('reviews.status', 1)
            ->groupBy('reviews.id')
            ->get();

        return $reviews;
    }

    public static function getReviewsCountByProjectId($project_id) {
        $reviewsCount = Reviews::where('project_id', $project_id)
            ->count();

        return $reviewsCount;
    }



    public static function getReviewsCountByFromTo($from, $to, $project_id) {
        $reviewsCount = Reviews::where('from', $from)
            ->where('reviews.to', $to)
            ->where('reviews.project_id', $project_id)
            ->where('reviews.status', 1)
            ->count();

        return $reviewsCount;
    }


    public static function addReview(ReviewDTO $reviewDTO) {


        return Reviews::create([
            'from' => $reviewDTO->from,
            'to' => $reviewDTO->to,
            'rating' => $reviewDTO->rating,
            'review' => $reviewDTO->review,
            'status' => $reviewDTO->status,
        ]);

    }
}
