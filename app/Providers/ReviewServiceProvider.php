<?php

namespace App\Providers;

use App\Services\ReviewInterface;
use App\Services\ReviewService;
use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ReviewInterface::class, ReviewService::class);
    }
}
