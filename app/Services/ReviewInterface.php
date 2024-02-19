<?php

namespace App\Services;

interface ReviewInterface
{
    public function getReviewProjectRatingAvg(int $id);

    public function updateStatus(int $idReview, int $status);
}
