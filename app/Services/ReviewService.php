<?php

namespace App\Services;

use App\Models\Reviews\Reviews;
use Illuminate\Database\Eloquent\Collection;


class ReviewService implements ReviewInterface
{

    protected Reviews $reviewModel;

    public function __construct(Reviews $reviewModel)
    {
        $this->reviewModel = $reviewModel;
    }

    public function getReviewProjectRatingAvg(int $id): array
    {
        $reviews = $this->reviewModel->getReviewsByProjectId($id);

        return [
            'rating' => $reviews->avg("rating"),
            'count' => $reviews->count()
        ];

    }

    public  function updateStatus(int $idReview, int $status)
    {
        $review = $this->reviewModel->findOrFail($idReview);
        if($review) {
            $review->status = $status;
            $review->save();
            return response()->json(['success' => true, 'data' => $status]);
        }
        return response()->json(['success' => false, 'data' => $status]);
    }


}
