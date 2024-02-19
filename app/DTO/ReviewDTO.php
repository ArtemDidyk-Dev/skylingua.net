<?php

namespace App\DTO;

class ReviewDTO
{
    public string $from;

    public int $to;

    public int $projectId;

    public float $rating;

    public string|null $review = null;

    public int $status = 0;

    public function __construct(string $from, int $to, int $projectId, float $rating, string|null $review, int $status = 0)
    {
        $this->from = $from;
        $this->to = $to;
        $this->projectId = $projectId;
        $this->rating = $rating;
        $this->review = $review;
        $this->status = $status;
    }

}
