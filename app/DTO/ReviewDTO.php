<?php

namespace App\DTO;

class ReviewDTO
{
    public string $from;

    public int $to;

    public float $rating;

    public string|null $review = null;

    public int $status = 0;

    public function __construct(string $from, int $to,  float $rating, string|null $review, int $status = 0)
    {
        $this->from = $from;
        $this->to = $to;
        $this->rating = $rating;
        $this->review = $review;
        $this->status = $status;
    }

}
