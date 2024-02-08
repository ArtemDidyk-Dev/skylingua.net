<?php

namespace App\Providers;

use App\View\Composers\CategoryViewComposer;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryViewComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
                'components.inc.footer',
                'frontend.layouts.partials.footer',
            ],
            CategoryViewComposer::class
        );
    }
}
