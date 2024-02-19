<?php

namespace App\Providers;

use App\Http\Controllers\Admin\Faq\FaqController;
use App\Models\Comment\Comment;
use App\Models\Faq\Faq;
use App\Models\Service;
use App\Services\CommentInterface;
use App\Services\CommentRepository;
use App\Services\CommentRepositoryInterface;
use App\Services\CommentService;
use App\Services\FaqInterface;
use App\Services\FaqRepository;
use App\Services\FaqRepositoryInterface;
use App\Services\FaqService;
use App\Services\SaveFile;
use App\Services\ServiceSavaCommentImg;
use Illuminate\Database\Eloquent\Model;
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

        $this->app->bind(SaveFile::class, ServiceSavaCommentImg::class );

        $this->app->singleton(FaqInterface::class, function () {
            return new FaqService(new FaqRepository(new Faq()));
        });

        $this->app->singleton(FaqRepositoryInterface::class, function () {
            return new FaqRepository(new Faq());
        });

        $this->app->singleton(CommentInterface::class, function () {
            return new CommentService(new CommentRepository(new Comment()), new ServiceSavaCommentImg());
        });

        $this->app->singleton(CommentRepositoryInterface::class, function () {
            return new CommentRepository(new Comment());
        });



    }
}
