<?php
use Illuminate\Support\Facades\Route;
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
                Route::get('/edit/{pay}', 'PayController@edit')->name('admin.pay.edit');
                Route::post('/update/{pay}', 'PayController@update')->name('admin.pay.update');
                Route::post('/status-ajax', 'PayController@statusAjax')->name('admin.pay.statusAjax');
                Route::post('/delete', 'PayController@delete')->name('admin.pay.delete');
                Route::post('/delete-ajax', 'PayController@deleteAjax')->name('admin.pay.deleteAjax');
//                Route::get('/search', 'PayController@search')->name('admin.pay.search');
                Route::post('/sort-ajax', 'PayController@sortAjax')->name('admin.pay.sortAjax');

            });
        });
        /*   Pays END   */

        Route::namespace('Faq')->group(function () {
            Route::prefix('faq')->group(function () {
                Route::get('/', 'FaqController@index')->name('admin.faq.index');
                Route::get('/create', 'FaqController@create')->name('admin.faq.create');
                Route::post('/store', 'FaqController@store')->name('admin.faq.store');
                Route::post('/update/{faq}', 'FaqController@update')->name('admin.faq.update');
                Route::get('/edit/{faq}', 'FaqController@edit')->name('admin.faq.edit');
                Route::delete('/delete', 'FaqController@delete')->name('admin.faq.delete');
            });
        });

        Route::namespace('Comment')->group(function () {
            Route::prefix('Comment')->group(function () {
                Route::get('/', 'CommentController@index')->name('admin.comment.index');
                Route::get('/create', 'CommentController@create')->name('admin.comment.create');
                Route::post('/store', 'CommentController@store')->name('admin.comment.store');
                Route::post('/update/{comment}', 'CommentController@update')->name('admin.comment.update');
                Route::get('/edit/{comment}', 'CommentController@edit')->name('admin.comment.edit');
                Route::delete('/delete', 'CommentController@delete')->name('admin.comment.delete');
            });
        });



        Route::namespace('Subscriber')->group(function () {
            Route::prefix('subscriber')->group(function () {
                Route::get('/', 'SubscriberController@index')->name('admin.subscriber.index');
                Route::get('/create', 'SubscriberController@create')->name('admin.subscriber.create');
                Route::post('/store', 'SubscriberController@store')->name('admin.subscriber.store');
                Route::post('/update/{subscriber}', 'SubscriberController@update')->name('admin.subscriber.update');
                Route::get('/edit/{subscriber}', 'SubscriberController@edit')->name('admin.subscriber.edit');
                Route::delete('/delete', 'SubscriberController@delete')->name('admin.subscriber.delete');
            });
        });


        Route::namespace('Course')->group(function () {
            Route::prefix('courses')->group(function () {
                Route::get('/', 'CourseController@index')->name('admin.courses.index');
                Route::get('/create', 'CourseController@create')->name('admin.courses.create');
                Route::post('/store', 'CourseController@store')->name('admin.courses.store');
                Route::post('/update/{course}', 'CourseController@update')->name('admin.courses.update');
                Route::get('/edit/{course}', 'CourseController@edit')->name('admin.courses.edit');
                Route::delete('/delete/{id}', 'CourseController@delete')->name('admin.courses.delete');
                Route::delete('/courses/{course}/file/{file}', 'CourseController@deleteFile')->name('admin.courses.delete.file');
            });
        });

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
                Route::post('/status-ajax', 'ReviewController@statusAjax')->name('admin.review.statusAjax');
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
