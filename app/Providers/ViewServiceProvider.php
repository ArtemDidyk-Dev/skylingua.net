<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers\MenuViewComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MenuViewComposer::class);
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
                'components.inc.header',
                'frontend.layouts.partials.header'
            ],
            MenuViewComposer::class
        );
    }
}