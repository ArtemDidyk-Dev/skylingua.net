<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Services\Interfaces\ServiceSystemInterface;
use App\Services\ServiceSystem;
use App\Http\Controllers\Admin\Services\ServicesController;
use App\View\Components\ServiceListComponent;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        /*   Client Token alarken problem cixdi ve bunu istifade etdim   */
        Passport::withoutCookieSerialization();
    }
}