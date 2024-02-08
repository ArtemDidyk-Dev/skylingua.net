<?php


use Illuminate\Support\Facades\Route;

/**
 * FAYL MANAGER UCUN CONNECTOR
 * /ckfinder/connector bu yolu deyishme ishlemeyecek ckfinder fayl yuklmeleri ve s.
 */
Route::middleware(['auth', 'StatususerCheck', 'Common', 'CustomCKFinderAuth', 'FileManager'])->group(function () {
    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');
});


/* BACKEND START  */
Route::namespace('Admin')->group(function () {
    Route::prefix('lamratum')->middleware(['auth', 'StatususerCheck', 'Common'])->group(function () {
        /*   Admin Dashboard   */
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('/permission', 'AdminController@permission')->name('admin.permission');

        /*   Language START  */
        Route::namespace('Language')->group(function () {

            /*   Language   */
            Route::prefix('language')->group(function () {
                Route::get('/', 'LanguageController@index')->name('admin.language.index');
                Route::post('/add', 'LanguageController@add')->name('admin.language.add');
                Route::post('/update', 'LanguageController@update')->name('admin.language.update');
                Route::post('/delete', 'LanguageController@delete')->name('admin.language.delete');
                Route::post('/delete-ajax', 'LanguageController@deleteAjax')->name('admin.language.deleteAjax');
                Route::post('/edit-ajax', 'LanguageController@editAjax')->name('admin.language.editAjax');
                Route::post('/default-status', 'LanguageController@defaultStatus')->name('admin.language.defaultStatus');
                Route::post('/sort-ajax', 'LanguageController@sortAjax')->name('admin.language.sortAjax');
                Route::post('/status-ajax', 'LanguageController@statusAjax')->name('admin.language.statusAjax');
                Route::get('/search/{text?}', 'LanguageController@search')->name('admin.language.search');
            });

            /*   Language GROUPS   */
            Route::prefix('language-group')->group(function () {
                Route::get('/', 'LanguageGroupController@index')->name('admin.languageGroup.index');
                Route::post('/add', 'LanguageGroupController@groupAdd')->name('admin.languageGroup.add');
                Route::post('/update', 'LanguageGroupController@groupUpdate')->name('admin.languageGroup.update');
                Route::post('/delete', 'LanguageGroupController@groupDelete')->name('admin.languageGroup.delete');
                Route::post('/delete-ajax', 'LanguageGroupController@deleteAjax')->name('admin.languageGroup.deleteAjax');
                Route::post('/edit-ajax', 'LanguageGroupController@groupEditAjax')->name('admin.languageGroup.editAjax');
                Route::get('/search/{text?}', 'LanguageGroupController@groupSearch')->name('admin.languageGroup.search');
                /*   Language Group Detail   */
                Route::get('/detail/{id}', 'LanguageGroupController@groupDetail')->where('id', '[0-9]+')->name('admin.languageGroup.detail');
                Route::post('/detail-phrase-add', 'LanguageGroupController@groupDetailPhraseAdd')->name('admin.languageGroup.phraseAdd');
                Route::post('/detail-phrase-edit-ajax', 'LanguageGroupController@groupDetailPhraseEditAjax')->name('admin.languageGroup.phraseEditAjax');
                Route::post('/detail-phrase-update', 'LanguageGroupController@groupDetailPhraseUpdate')->name('admin.languageGroup.phraseUpdate');
                Route::get('/detail/search/{id?}/{text?}', 'LanguageGroupController@groupDetailSearch')->name('admin.languageGroup.groupDetailSearch');
                Route::post('/detail/delete', 'LanguageGroupController@groupDetailDelete')->name('admin.languageGroup.groupDetailDelete');
                Route::post('/detail/delete-ajax', 'LanguageGroupController@groupDetailDeleteAjax')->name('admin.languageGroup.groupDetailDeleteAjax');
            });


            /*   Language Phrase   */
            Route::prefix('language-phrase')->group(function () {
                Route::get('/', 'LanguagePhraseController@index')->name('admin.languagePhrase.index');
                Route::post('/phrase-add', 'LanguagePhraseController@add')->name('admin.languagePhrase.add');
                Route::post('/phrase-edit-ajax', 'LanguagePhraseController@editAjax')->name('admin.languagePhrase.editAjax');
//                Route::post('/phrase-update', 'LanguagePhraseController@update')->name('admin.languagePhrase.update');
                Route::get('/search/{text?}', 'LanguagePhraseController@search')->name('admin.languagePhrase.search');
                Route::post('/delete', 'LanguagePhraseController@delete')->name('admin.languagePhrase.delete');
                Route::post('/delete-ajax', 'LanguagePhraseController@deleteAjax')->name('admin.languagePhrase.deleteAjax');
            });

        });
        /*   Language END  */


        /*   MENU START   */
        Route::namespace('Menu')->group(function () {
            Route::prefix('menu')->group(function () {
                Route::get('/', 'MenuController@index')->name('admin.menu.index');
                Route::get('/add', 'MenuController@add')->name('admin.menu.add');
                Route::post('/add-menu-name', 'MenuController@addMenuName')->name('admin.menu.addMenuName');
                Route::post('/delete', 'MenuController@delete')->name('admin.menu.delete');
                Route::get('/edit/{id}', 'MenuController@edit')->name('admin.menu.edit');
                Route::post('/position-add', 'MenuController@positionAdd')->name('admin.menu.positionAdd');
                Route::post('/position-delete-ajax', 'MenuController@positionDeletAjax')->name('admin.menu.position.delete.ajax');
                Route::post('/edit-ajax', 'MenuController@editAjax')->name('admin.menu.edit.ajax');
                Route::post('/store-ajax', 'MenuController@storeAjax')->name('admin.menu.store.ajax');
                Route::post('/change-ajax', 'MenuController@changeAjax')->name('admin.menu.change.ajax');
                Route::post('/delete-ajax', 'MenuController@deleteAjax')->name('admin.menu.delete.ajax');

            });
        });
        /*   MENU END   */


        /*   USERS START   */
        Route::namespace('User')->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', 'UserController@index')->name('admin.user.index');
                Route::get('/add', 'UserController@add')->name('admin.user.add');
                Route::post('/store', 'UserController@store')->name('admin.user.store');
                Route::get('/edit/{id}', 'UserController@edit')->name('admin.user.edit');
                Route::post('/update', 'UserController@update')->name('admin.user.update');
                Route::get('/search', 'UserController@search')->name('admin.users.search');
                Route::get('/status-ajax', 'UserController@statusAjax');
                Route::post('/status-ajax', 'UserController@statusAjax')->name('admin.user.statusAjax');
                Route::post('/delete-ajax', 'UserController@deleteAjax')->name('admin.user.deleteAjax');
                Route::post('/delete', 'UserController@delete')->name('admin.user.delete');
                Route::post('/get-user_categories-ajax', 'UserController@getUserCategoriesAjax')->name('admin.user.getUserCategoriesAjax');

            });

            Route::prefix('profil')->group(function () {
                Route::get('/edit/{id}', 'UserController@profilEdit')->name('admin.user.profilEdit');
                Route::post('/profilUpdate', 'UserController@profilUpdate')->name('admin.user.profilUpdate');
            });

        });
        /*   USERS END   */


        /*   SETTINGS START   */
        Route::namespace('Setting')->group(function () {
            Route::prefix('setting')->group(function () {
                Route::get('/', 'SettingController@index')->name('admin.setting.index');
                Route::post('/update', 'SettingController@update')->name('admin.setting.update');
                Route::post('/search-icons', 'SettingController@searchIcons')->name('admin.setting.searchIcons');

            });
        });
        /*   SETTINGS END   */


        /*   SLIDE START   */
        Route::namespace('Slide')->group(function () {
            Route::prefix('slide')->group(function () {
                Route::get('/', 'SlideController@index')->name('admin.slide.index');
                Route::get('/add', 'SlideController@add')->name('admin.slide.add');
                Route::post('/store', 'SlideController@store')->name('admin.slide.store');
                Route::get('/edit/{id}', 'SlideController@edit')->name('admin.slide.edit');
                Route::post('/update', 'SlideController@update')->name('admin.slide.update');
                Route::post('/sort-ajax', 'SlideController@sortAjax')->name('admin.slide.sortAjax');
                Route::post('/status-ajax', 'SlideController@statusAjax')->name('admin.slide.statusAjax');
                Route::post('/delete', 'SlideController@delete')->name('admin.slide.delete');
                Route::post('/delete-ajax', 'SlideController@deleteAjax')->name('admin.slide.deleteAjax');

            });
        });
        /*   SLIDE END   */


        /*   PAGES START   */
        Route::namespace('Page')->group(function () {
            Route::prefix('page')->group(function () {
                Route::get('/', 'PageController@index')->name('admin.page.index');
                Route::get('/add', 'PageController@add')->name('admin.page.add');
                Route::post('/store', 'PageController@store')->name('admin.page.store');
                Route::get('/edit/{id}', 'PageController@edit')->name('admin.page.edit');
                Route::post('/update', 'PageController@update')->name('admin.page.update');
                Route::post('/slug', 'PageController@slug')->name('admin.page.slug');
                Route::post('/status-ajax', 'PageController@statusAjax')->name('admin.page.statusAjax');
                Route::post('/delete', 'PageController@delete')->name('admin.page.delete');
                Route::post('/delete-ajax', 'PageController@deleteAjax')->name('admin.page.deleteAjax');
                Route::get('/search', 'PageController@search')->name('admin.page.search');

            });
        });
        /*   PAGES END   */



        /*   Portfolio START   */
        Route::namespace('Portfolio')->group(function () {
            Route::prefix('portfolio')->group(function () {
                Route::get('/', 'PortfolioController@index')->name('admin.portfolio.index');
                Route::get('/add', 'PortfolioController@add')->name('admin.portfolio.add');
                Route::post('/store', 'PortfolioController@store')->name('admin.portfolio.store');
                Route::get('/edit/{id}', 'PortfolioController@edit')->name('admin.portfolio.edit');
                Route::post('/update', 'PortfolioController@update')->name('admin.portfolio.update');
                Route::post('/slug', 'PortfolioController@slug')->name('admin.portfolio.slug');
                Route::post('/status-ajax', 'PortfolioController@statusAjax')->name('admin.portfolio.statusAjax');
                Route::post('/delete', 'PortfolioController@delete')->name('admin.portfolio.delete');
                Route::post('/delete-ajax', 'PortfolioController@deleteAjax')->name('admin.portfolio.deleteAjax');
                Route::get('/search', 'PortfolioController@search')->name('admin.portfolio.search');

            });
        });
        /*   Portfolio END   */


        /*   BLOGS START   */
        Route::namespace('Blog')->group(function () {
            Route::prefix('blog')->group(function () {
                Route::get('/', 'BlogController@index')->name('admin.blog.index');
                Route::get('/add', 'BlogController@add')->name('admin.blog.add');
                Route::post('/store', 'BlogController@store')->name('admin.blog.store');
                Route::get('/edit/{id}', 'BlogController@edit')->name('admin.blog.edit');
                Route::post('/update', 'BlogController@update')->name('admin.blog.update');
                Route::post('/slug', 'BlogController@slug')->name('admin.blog.slug');
                Route::post('/status-ajax', 'BlogController@statusAjax')->name('admin.blog.statusAjax');
                Route::post('/delete', 'BlogController@delete')->name('admin.blog.delete');
                Route::post('/delete-ajax', 'BlogController@deleteAjax')->name('admin.blog.deleteAjax');
                Route::get('/search', 'BlogController@search')->name('admin.blog.search');
                Route::post('/sort-ajax', 'BlogController@sortAjax')->name('admin.blog.sortAjax');

            });
        });
        /*   BLOGS END   */


        /*   Notifications START   */
        Route::namespace('Notification')->group(function () {
            Route::prefix('notification')->group(function () {
                Route::get('/', 'NotificationController@index')->name('admin.notification.index');
                Route::post('/status-ajax', 'NotificationController@statusAjax')->name('admin.notification.statusAjax');
                Route::post('/delete', 'NotificationController@delete')->name('admin.notification.delete');
                Route::post('/delete-ajax', 'NotificationController@deleteAjax')->name('admin.notification.deleteAjax');
                Route::get('/search', 'NotificationController@search')->name('admin.notification.search');

            });
        });
        /*   Notifications END   */



         /*   Notifications END   */

        /*   Pays START   */
        Route::namespace('Pay')->group(function () {
            Route::prefix('pay')->group(function () {
                Route::get('/', 'PayController@index')->name('admin.pay.index');
                Route::post('/status-ajax', 'PayController@statusAjax')->name('admin.pay.statusAjax');
                Route::post('/delete', 'PayController@delete')->name('admin.pay.delete');
                Route::post('/delete-ajax', 'PayController@deleteAjax')->name('admin.pay.deleteAjax');
//                Route::get('/search', 'PayController@search')->name('admin.pay.search');
                Route::post('/sort-ajax', 'PayController@sortAjax')->name('admin.pay.sortAjax');

            });
        });
        /*   Pays END   */


        /*   Pay OUT START   */
        Route::namespace('Pay')->group(function () {
            Route::prefix('payout')->group(function () {
                Route::get('/', 'PayOutController@index')->name('admin.payout.index');
                Route::post('/status-ajax', 'PayOutController@statusAjax')->name('admin.payout.statusAjax');
                Route::post('/delete', 'PayOutController@delete')->name('admin.payout.delete');
                Route::post('/delete-ajax', 'PayOutController@deleteAjax')->name('admin.payout.deleteAjax');
                Route::get('/search', 'PayOutController@search')->name('admin.payout.search');
                Route::post('/sort-ajax', 'PayOutController@sortAjax')->name('admin.payout.sortAjax');
                Route::get('/search', 'PayOutController@search')->name('admin.payout.search');
                Route::get('/search-id/{user_id?}', 'PayOutController@searchID')->name('admin.payout.searchID');
            });
        });
        /*   Pay OUT END   */


        /*   USER CATEGORIES START   */
        Route::namespace('UserCategory')->group(function () {
            Route::prefix('user_category')->group(function () {
                Route::get('/', 'UserCategoryController@index')->name('admin.user_category.index');
                Route::get('/add', 'UserCategoryController@add')->name('admin.user_category.add');
                Route::post('/store', 'UserCategoryController@store')->name('admin.user_category.store');
                Route::get('/edit/{id}', 'UserCategoryController@edit')->name('admin.user_category.edit');
                Route::post('/update', 'UserCategoryController@update')->name('admin.user_category.update');
                Route::post('/slug', 'UserCategoryController@slug')->name('admin.user_category.slug');
                Route::post('/status-ajax', 'UserCategoryController@statusAjax')->name('admin.user_category.statusAjax');
                Route::post('/delete', 'UserCategoryController@delete')->name('admin.user_category.delete');
                Route::post('/delete-ajax', 'UserCategoryController@deleteAjax')->name('admin.user_category.deleteAjax');
                Route::get('/search', 'UserCategoryController@search')->name('admin.user_category.search');
                Route::post('/sort-ajax', 'UserCategoryController@sortAjax')->name('admin.user_category.sortAjax');

            });
        });
        /*   USER CATEGORIES END   */





        /*   Review START   */
        Route::namespace('Review')->group(function () {
            Route::prefix('review')->group(function () {
                Route::get('/', 'ReviewController@index')->name('admin.review.index');
                Route::get('/add', 'ReviewController@add')->name('admin.review.add');
                Route::post('/store', 'ReviewController@store')->name('admin.review.store');
                Route::get('/edit/{id}', 'ReviewController@edit')->name('admin.review.edit');
                Route::post('/update', 'ReviewController@update')->name('admin.review.update');
                Route::post('/sort-ajax', 'ReviewController@sortAjax')->name('admin.review.sortAjax');
                Route::post('/delete', 'ReviewController@delete')->name('admin.review.delete');
                Route::post('/delete-ajax', 'ReviewController@deleteAjax')->name('admin.review.deleteAjax');
                Route::post('/all-delete-ajax', 'ReviewController@allDeleteAjax')->name('admin.review.allDeleteAjax');

            });
        });
        /*   Review END   */



        /*   COUNTRIES START   */
        Route::namespace('Country')->group(function () {
            Route::prefix('country')->group(function () {
                Route::get('/', 'CountryController@index')->name('admin.country.index');
                Route::get('/add', 'CountryController@add')->name('admin.country.add');
                Route::post('/store', 'CountryController@store')->name('admin.country.store');
                Route::get('/edit/{id}', 'CountryController@edit')->name('admin.country.edit');
                Route::post('/update', 'CountryController@update')->name('admin.country.update');
                Route::post('/slug', 'CountryController@slug')->name('admin.country.slug');
                Route::post('/status-ajax', 'CountryController@statusAjax')->name('admin.country.statusAjax');
                Route::post('/delete', 'CountryController@delete')->name('admin.country.delete');
                Route::post('/delete-ajax', 'CountryController@deleteAjax')->name('admin.country.deleteAjax');
                Route::get('/search', 'CountryController@search')->name('admin.country.search');
                Route::post('/sort-ajax', 'CountryController@sortAjax')->name('admin.country.sortAjax');

            });
        });
        /*   COUNTRIES END   */


        /*   PROJECTS START   */
        Route::namespace('Project')->group(function () {
            Route::prefix('projects')->group(function () {
                Route::get('/', 'ProjectController@index')->name('admin.project.index');
                Route::get('/search', 'ProjectController@search')->name('admin.project.search');
                Route::get('/add', 'ProjectController@add')->name('admin.project.add');
                Route::post('/nameSearch', 'ProjectController@nameSearch')->name('admin.project.nameSearch');
                Route::post('/store', 'ProjectController@store')->name('admin.project.store');
                Route::get('/edit/{id}', 'ProjectController@edit')->name('admin.project.edit');
                Route::post('/update', 'ProjectController@update')->name('admin.project.update');
                Route::post('/delete-ajax', 'ProjectController@deleteAjax')->name('admin.project.deleteAjax');
                Route::post('/delete', 'ProjectController@delete')->name('admin.project.delete');
                Route::post('/fileUploadAjax', 'ProjectController@fileUploadAjax')->name('admin.project.fileUploadAjax');
                Route::post('/fileDeleteAjax', 'ProjectController@fileDeleteAjax')->name('admin.project.fileDeleteAjax');

            });
        });
        /*   PROJECTS END   */




        /*   FILE MANAGER START   */
        Route::namespace('Filemanager')
            ->middleware(['FileManager'])
            ->group(function () {
                Route::get('/file-manager', 'FileManagerController@index')->name('admin.FileManager.index');
            });

        /*   FILE MANAGER END   */


        /*   CACHE CLEAR START  */
        Route::post('cache-clear', 'AdminController@cacheClear')->name('admin.cacheClear');
        /*   CACHE CLEAR END  */


    });
});
/* BACKEND END  */


/* LOGIN START  */
Route::prefix('lamratum')->group(function () {
    Route::get('/login', 'Auth\LoginController@index')->name('admin.login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');
});
/* LOGIN END  */


/*   LOGGER VIEW START   */
Route::prefix('lamratum')->middleware('auth')->group(function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('admin.logs');
});
/*   LOGGER VIEW END   */


/* FRONTEND START  */

Route::group(
    [
        'prefix' => LocalizationService::locale(),
        'middleware' => ['setLocale', 'Common']
    ],
    function () {
        Route::namespace('Frontend')->group(function () {


            /*   HOME START   */
            Route::get('/', 'Home\HomeController@index')->name('frontend.home.index');
            /*   HOME END   */

            /*   CONTACT START   */
            Route::get('/contact', 'Home\HomeController@contact')->name('frontend.home.contact');
            Route::post('/contact-send-ajax', 'Home\HomeController@contactSendAjax')->name('frontend.home.contactSendAjax');
            /*   CONTACT END   */

            /*   PAGE START   */
            Route::get('/page/{slug}', 'Page\PageController@page')->name('frontend.page.index');
            /*   PAGE END   */



            /*   BLOG START   */
            Route::get('/blogs', 'Blog\BlogController@index')->name('frontend.blog.index');
            Route::get('/blogs/{slug}', 'Blog\BlogController@detail')->name('frontend.blog.detail');
            /*   BLOG END   */



            /* REGISTER & LOGIN BEGIN*/

            Route::middleware('auth.check.true')->group(function () {
                Route::get('/register', 'Cabinet\RegisterController@register')->name('frontend.cabinet.register');
                Route::post('/register/store', 'Cabinet\RegisterController@store')->name('frontend.cabinet.registerStore');
                Route::get('/register/success', 'Cabinet\RegisterController@success')->name('frontend.cabinet.success');
                Route::get('/verify', 'Cabinet\RegisterController@verify')->name('frontend.cabinet.verify');

                Route::get('/login', 'Cabinet\LoginController@index')->name('frontend.login.index');
                Route::post('/login/store', 'Cabinet\LoginController@store')->name('frontend.login.store');

                Route::get('/forgot', 'Cabinet\ForgotController@index')->name('frontend.forgot.index');
                Route::post('/forgot/store', 'Cabinet\ForgotController@store')->name('frontend.forgot.store');
                Route::get('/forgot/success', 'Cabinet\ForgotController@success')->name('frontend.forgot.success');
                Route::get('/forgot/error', 'Cabinet\ForgotController@error')->name('frontend.forgot.error');
                Route::get('/password_resets', 'Cabinet\ForgotController@passwordresets')->name('frontend.forgot.password_resets');
                Route::post('/password_resets/store', 'Cabinet\ForgotController@passwordresetstore')->name('frontend.password_resets.store');

                Route::get('/dashboard/recovery-account', 'Cabinet\ProfileController@recoveryAccount')->name('frontend.dashboard.recovery-account');
            });
            /* REGISTER & LOGIN END*/

            /* CABINET Begin */
            Route::middleware('auth.check.false')->group(function () {
                Route::post('/logout', 'Cabinet\LoginController@logout')->name('frontend.login.logout');


                Route::get('/dashboard', 'Cabinet\DashboardController@index')->name('frontend.dashboard.index');
                Route::get('/dashboard/chats', 'Cabinet\ChatsController@index')->name('frontend.dashboard.chats');
                Route::get('/dashboard/create-chat/{id}', 'Cabinet\ChatsController@createChat')->name('frontend.dashboard.create-chat');
                Route::get('/dashboard/delete-chat/{id}', 'Cabinet\ChatsController@deleteChat')->name('frontend.dashboard.delete-chat');
                Route::post('/dashboard/getMessages', 'Cabinet\ChatsController@getMessagesAjax')->name('frontend.dashboard.getMessages');
                Route::post('/dashboard/getCount', 'Cabinet\ChatsController@getCountAjax')->name('frontend.dashboard.getCount');
                Route::post('/dashboard/getCountNewMessageAjax', 'Cabinet\ChatsController@getCountNewMessageAjax')->name('frontend.dashboard.getCountNewMessageAjax');

                Route::post('/dashboard/fileUpload', 'Cabinet\ChatsController@fileUploadAjax')->name('frontend.dashboard.fileUpload');
                Route::post('/dashboard/fileDelete', 'Cabinet\ChatsController@fileDeleteAjax')->name('frontend.dashboard.fileDelete');
                Route::post('/dashboard/addMessages', 'Cabinet\ChatsController@addMessagesAjax')->name('frontend.dashboard.addMessages');
                Route::get('/dashboard/change-password', 'Cabinet\ProfileController@changePassword')->name('frontend.dashboard.change-password');
                Route::post('/dashboard/change-password/store', 'Cabinet\ProfileController@changePasswordStore')->name('frontend.dashboard.change-password.store');
                Route::get('/dashboard/delete-account', 'Cabinet\ProfileController@deleteAccount')->name('frontend.dashboard.delete-account');
                Route::post('/dashboard/delete-account/store', 'Cabinet\ProfileController@deleteAccountStore')->name('frontend.dashboard.delete-account.store');

                Route::post('/dashboard/ajaxAddFreelancerFavourites', 'Cabinet\ProfileController@ajaxAddFreelancerFavourites')->name('frontend.ajax_add_freelancer_favourites');
                Route::post('/dashboard/ajaxAddProjectFavourites', 'Cabinet\ProjectsController@ajaxAddProjectFavourites')->name('frontend.ajax_add_project_favourites');


                Route::middleware('employer.check')->group(function (){
                    // Employer Dashboard start
                    Route::namespace('Cabinet')->group(function (){
                        Route::prefix('dashboard')->group(function (){
                            Route::get('employer', 'DashboardController@employer')->name('frontend.dashboard.employer');
                            Route::get('employer/projects-all', 'ProjectsController@employer')->name('frontend.dashboard.employer.projects-all');
                            Route::get('employer/projects-pending', 'ProjectsController@employerPending')->name('frontend.dashboard.employer.projects-pending');
                            Route::get('employer/projects-ongoing', 'ProjectsController@employerOngoing')->name('frontend.dashboard.employer.projects-ongoing');
                            Route::get('employer/projects-completed', 'ProjectsController@employerCompleted')->name('frontend.dashboard.employer.projects-completed');
                            Route::post('employer/projects-completed/accept', 'ProjectsController@employerProjectAccept')->name('frontend.dashboard.employer.projects-completed.accept');
                            Route::post('employer/projects-completed/correct', 'ProjectsController@employerProjectCorrect')->name('frontend.dashboard.employer.projects-completed.correct');
                            Route::post('employer/projects-repost', 'ProjectsController@employerProjectRepost')->name('frontend.dashboard.employer.projects-repost');
                            Route::get('employer/projects-cancelled', 'ProjectsController@employerCancelled')->name('frontend.dashboard.employer.projects-cancelled');
                            Route::get('employer/projects-add', 'ProjectsController@employerProjectAdd')->name('frontend.dashboard.employer.employerProjectAdd');
                            Route::post('employer/projects-store', 'ProjectsController@employerProjectStore')->name('frontend.dashboard.employer.employerProjectStore');
                            Route::get('employer/projects-edit/{id}', 'ProjectsController@employerProjectEdit')->name('frontend.dashboard.employer.employerProjectEdit');
                            Route::post('employer/projects-update', 'ProjectsController@employerProjectUpdate')->name('frontend.dashboard.employer.employerProjectUpdate');
                            Route::post('employer/projects-publish', 'ProjectsController@employerProjectPublish')->name('frontend.dashboard.employer.employerProjectPublish');
                            Route::get('employer/projects-proposals/{id}', 'ProjectsController@employerProposals')->name('frontend.dashboard.employer.project.proposals');

                            Route::get('employer/favourites', 'FavouritesController@employer')->name('frontend.dashboard.employer.favourites');
                            Route::get('employer/review', 'ReviewsController@employer')->name('frontend.dashboard.employer.review');
                            Route::get('employer/membership-plans', 'MembershipController@employer')->name('frontend.dashboard.employer.membership-plans');
                            Route::get('employer/milestones', 'MilestonesController@employer')->name('frontend.dashboard.employer.milestones');
                            Route::get('employer/verify-identity', 'VerifyIdentityController@employer')->name('frontend.dashboard.employer.verify-identity');
                            Route::get('employer/deposit-funds', 'DepositFundsController@employer')->name('frontend.dashboard.employer.deposit-funds');
                            Route::get('employer/profile-settings', 'ProfileController@editEmployer')->name('frontend.dashboard.employer.profile-settings');
                            Route::post('employer/profile-settings/store', 'ProfileController@editEmployerStore')->name('frontend.dashboard.employer.profile-settings.store');

                        });
                    });
                    // Employer Dashboard end

                });

                Route::middleware('freelancer.check')->group(function (){
                    // Freelancer Dashboard start
                    Route::namespace('Cabinet')->group(function (){
                        Route::prefix('dashboard')->group(function (){
                            Route::get('freelancer', 'DashboardController@freelancer')->name('frontend.dashboard.freelancer');
                            Route::get('designer/project-proposals', 'ProjectsController@freelancer')->name('frontend.dashboard.freelancer.project-proposals');
                            Route::get('designer/project-hireds', 'ProjectsController@freelancerHireds')->name('frontend.dashboard.freelancer.project-hireds');
                            Route::post('designer/project-hireds/accept', 'ProjectsController@freelancerHiredsAccept')->name('frontend.dashboard.freelancer.project-hireds.accept');
                            Route::post('designer/project-hireds/complete', 'ProjectsController@freelancerHiredsComplete')->name('frontend.dashboard.freelancer.project-hireds.complete');
                            Route::post('designer/project-hireds/cancel', 'ProjectsController@freelancerHiredsCancel')->name('frontend.dashboard.freelancer.project-hireds.cancel');
                            Route::post('designer/project-proposals/store', 'ProjectsController@freelancerProposalStore')->name('frontend.dashboard.freelancer.project-proposals.store');
                            Route::post('designer/project-proposals/store/ajax', 'ProjectsController@freelancerProposalStoreAjax')->name('frontend.dashboard.freelancer.project-proposals.store.ajax');
                            Route::post('designer/project-proposals/edit', 'ProjectsController@freelancerProposalEdit')->name('frontend.dashboard.freelancer.project-proposals.edit');
                            Route::post('designer/project-proposals/delete', 'ProjectsController@freelancerProposalDelete')->name('frontend.dashboard.freelancer.project-proposals.delete');
                            Route::get('designer/project-ongoing', 'ProjectsController@freelancerOngoing')->name('frontend.dashboard.freelancer.project-ongoing');
                            Route::get('designer/project-completed', 'ProjectsController@freelancerCompleted')->name('frontend.dashboard.freelancer.project-completed');
                            Route::post('designer/project-completed/review', 'ProjectsController@freelancerCompletedReview')->name('frontend.dashboard.freelancer.project-completed.review');
                            Route::get('designer/project-cancelled', 'ProjectsController@freelancerCancelled')->name('frontend.dashboard.freelancer.project-cancelled');
                            Route::get('designer/favourites', 'FavouritesController@freelancer')->name('frontend.dashboard.freelancer.favourites');
                            Route::get('designer/reviews', 'ReviewsController@freelancer')->name('frontend.dashboard.freelancer.reviews');

                            Route::get('designer/portfolio', 'PortfolioController@freelancer')->name('frontend.dashboard.freelancer.portfolio');
                            Route::post('designer/portfolio/add/store', 'PortfolioController@addStore')->name('frontend.dashboard.freelancer.portfolio.add.tore');
                            Route::post('designer/portfolio/edit/store', 'PortfolioController@editStore')->name('frontend.dashboard.freelancer.portfolio.edit.tore');
                            Route::post('designer/portfolio/delete/store', 'PortfolioController@deleteStore')->name('frontend.dashboard.freelancer.portfolio.delete.tore');

                            Route::get('designer/membership', 'MembershipController@freelancer')->name('frontend.dashboard.freelancer.membership');
                            Route::get('designer/verify-identity', 'VerifyIdentityController@freelancer')->name('frontend.dashboard.freelancer.verify-identity');
                            Route::get('designer/withdraw-money', 'WithdrawMoneyController@freelancer')->name('frontend.dashboard.freelancer.withdraw-money');

                            Route::post('designer/withdraw-money/bank/step1', 'WithdrawMoneyController@bankStep1')->name('frontend.dashboard.freelancer.pay.bank.step1');
                            Route::post('designer/withdraw-money/bank/step2', 'WithdrawMoneyController@bankStep2')->name('frontend.dashboard.freelancer.pay.bank.step2');
                            Route::post('designer/withdraw-money/bank/step3', 'WithdrawMoneyController@bankStep3')->name('frontend.dashboard.freelancer.pay.bank.step3');
                            Route::get('designer/withdraw-money/bank/step_status/{paymentId}', 'WithdrawMoneyController@bankStepStatus')->name('frontend.dashboard.freelancer.pay.bank.stepStatus');
                            Route::get('designer/withdraw-money/bank/progress', 'WithdrawMoneyController@bankStepProgress')->name('frontend.dashboard.freelancer.pay.bank.stepProgress');
                            Route::get('designer/withdraw-money/bank/success', 'WithdrawMoneyController@bankStepSuccess')->name('frontend.dashboard.freelancer.pay.bank.stepSuccess');
                            Route::get('designer/withdraw-money/bank/error', 'WithdrawMoneyController@bankStepError')->name('frontend.dashboard.freelancer.pay.bank.stepError');

                            Route::get('designer/transaction-history', 'WithdrawMoneyController@freelancerTransactionHistory')->name('frontend.dashboard.freelancer.transaction-history');
                            Route::get('designer/view-invoice/{id}', 'WithdrawMoneyController@freelancerViewInvoice')->name('frontend.dashboard.freelancer.view-invoice');
                            Route::get('designer/profile-settings', 'ProfileController@editFrelancer')->name('frontend.dashboard.freelancer.profile-settings');
                            Route::post('designer/profile-settings/store', 'ProfileController@editFrelancerStore')->name('frontend.dashboard.freelancer.-settings.store');
                            Route::post('designer/profile-settings/store', 'ProfileController@editFrelancerStore')->name('frontend.dashboard.freelancer.profile-settings.store');

                        });
                    });
                    // Freelancer Dashboard end
                });




                Route::get('/dashboard/notification', 'Cabinet\NotificationController@index')->name('frontend.cabinet.notification');
                Route::post('/dashboard/notification/delete', 'Cabinet\NotificationController@delete')->name('frontend.notification.delete');
                Route::post('/dashboard/notification/mark', 'Cabinet\NotificationController@mark')->name('frontend.notification.mark');


                /* get Projects Count */
                Route::get('/dashboard/ajax_projects_count', 'Cabinet\ProjectsController@ajaxProjectsCount')->name('frontend.ajax_projects_count');
                /* /get Projects Count */


                /*   PAY START   */
                Route::post('/pay/go', 'Pay\PayController@go')->name('frontend.pay.go');
                Route::get('/pay/go_get', 'Pay\PayController@go')->name('frontend.pay.go_get');
                Route::get('/pay/status', 'Pay\PayController@status')->name('frontend.pay.status');
                Route::get('/pay/success', 'Pay\PayController@success')->name('frontend.pay.success');
                Route::get('/pay/error', 'Pay\PayController@error')->name('frontend.pay.error');
                Route::get('/pay/link/{id}', 'Pay\PayController@link')->name('frontend.pay.link');
                Route::get('/pay/link2', 'Pay\PayController@link2')->name('frontend.pay.link2');
                /*   PAY END   */

//                Route::get('/cabinet', 'Cabinet\CabinetController@index')->name('frontend.cabinet.cabinet');
//                Route::get('/cabinet/edit/{id}', 'Cabinet\CabinetController@edit')->name('frontend.cabinet.edit');
//                Route::post('/cabinet/edit/{id}/store', 'Cabinet\CabinetController@store')->name('frontend.cabinet.store');

//                Route::get('/cabinet/add', 'Cabinet\CabinetController@add')->name('frontend.cabinet.add');
//                Route::post('/cabinet/edit/add', 'Cabinet\CabinetController@addStore')->name('frontend.cabinet.addStore');

//                Route::get('/cabinet/employee', 'Cabinet\CabinetController@employee')->name('frontend.cabinet.employee');
//                Route::get('/cabinet/institution', 'Cabinet\CabinetController@institution')->name('frontend.cabinet.institution');

//                Route::get('/cabinet/notification', 'Cabinet\NativicationController@index')->name('frontend.cabinet.notification');
//                Route::post('/cabinet/notification/delete', 'Cabinet\NativicationController@delete')->name('frontend.notification.delete');
//                Route::post('/cabinet/notification/mark', 'Cabinet\NativicationController@mark')->name('frontend.notification.mark');

//                Route::get('/cabinet/history', 'Cabinet\HistoryController@index')->name('frontend.cabinet.history');
//                Route::get('/cabinet/pay', 'Cabinet\PayController@index')->name('frontend.cabinet.pay');
            });
            /* CABINET End */


            /*   DEVELOPER START   */
            Route::get('/designers', 'Developer\DeveloperController@index')->name('frontend.developer.index');
            /*   DEVELOPER END   */

            /*   PROJECT START   */
            Route::get('/projects', 'Project\ProjectController@index')->name('frontend.project.index');
            Route::get('/projects/detail/{id}', 'Project\ProjectController@detail')->name('frontend.project.detail');
            Route::get('/projects/ajax-list', 'Project\ProjectController@ajaxList')->name('frontend.project.ajax-list');
            /*   PROJECT END   */


            /*   PROFILE START   */
//            Route::get('/institution', 'Profile\ProfileController@institution')->name('frontend.profile.institution');
//            Route::get('/employee', 'Profile\ProfileController@employee')->name('frontend.profile.employee');
            Route::get('/profile/{id}', 'Cabinet\ProfileController@index')->name('frontend.profile.index');
            /*   PROFILE END   */






            /*   LANGUAGE START  */
            /*   QEYD DIL DEYIHSIKILIYI OLDUQDA FRONTENDDE BURASI ISHLEYIR   */
            Route::namespace('Language')->group(function () {
                Route::prefix('language')->group(function () {
                    Route::post('/change', 'LanguageController@change')->name('frontend.language.change');
                });
            });
            /*   LANGUAGE END  */


            /*   SITEMAP START   */
            Route::get('/sitemap.xml', 'Sitemap\SitemapController@index')->name('frontend.sitemap.index');
            /*   SITEMAP END   */

        });
    });

/* FRONTEND END  */



