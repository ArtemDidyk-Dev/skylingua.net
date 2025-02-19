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

            /*   Faq START   */
            Route::get('/faq', 'Faq\FaqController@index')->name('frontend.faq.index');
            Route::post('/faq-send-ajax', 'Faq\FaqController@contactSendAjax')->name('frontend.faq.contactSendAjax');
            /*  Faq END   */

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
                Route::any('/register/store/employer', 'Cabinet\RegisterController@storeEmployer')->name('frontend.registration.employer');
            });
            /* REGISTER & LOGIN END*/

            /* CABINET Begin */
            Route::middleware('auth.check.false')->group(function () {
                Route::post('/logout', 'Cabinet\LoginController@logout')->name('frontend.login.logout');


                Route::get('/dashboard', 'Cabinet\DashboardController@index')->name('frontend.dashboard.index');
                Route::get('/dashboard/chats', 'Cabinet\ChatsController@index')->name('frontend.dashboard.chats');
                Route::any('/dashboard/create-chat/{id}', 'Cabinet\ChatsController@createChat')->name('frontend.dashboard.create-chat');
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
                            Route::get('student', 'DashboardController@employer')->name('frontend.dashboard.employer');
                            Route::get('student/projects-all', 'ProjectsController@employer')->name('frontend.dashboard.employer.projects-all');
                            Route::get('student/projects-pending', 'ProjectsController@employerPending')->name('frontend.dashboard.employer.projects-pending');
                            Route::get('student/projects-ongoing', 'ProjectsController@employerOngoing')->name('frontend.dashboard.employer.projects-ongoing');
                            Route::get('student/projects-completed', 'ProjectsController@employerCompleted')->name('frontend.dashboard.employer.projects-completed');
                            Route::post('student/projects-completed/accept', 'ProjectsController@employerProjectAccept')->name('frontend.dashboard.employer.projects-completed.accept');
                            Route::post('student/projects-completed/correct', 'ProjectsController@employerProjectCorrect')->name('frontend.dashboard.employer.projects-completed.correct');
                            Route::post('student/projects-repost', 'ProjectsController@employerProjectRepost')->name('frontend.dashboard.employer.projects-repost');
                            Route::get('student/projects-cancelled', 'ProjectsController@employerCancelled')->name('frontend.dashboard.employer.projects-cancelled');
                            Route::get('student/projects-add', 'ProjectsController@employerProjectAdd')->name('frontend.dashboard.employer.employerProjectAdd');
                            Route::post('student/projects-store', 'ProjectsController@employerProjectStore')->name('frontend.dashboard.employer.employerProjectStore');
                            Route::get('student/projects-edit/{id}', 'ProjectsController@employerProjectEdit')->name('frontend.dashboard.employer.employerProjectEdit');
                            Route::post('student/projects-update', 'ProjectsController@employerProjectUpdate')->name('frontend.dashboard.employer.employerProjectUpdate');
                            Route::post('student/projects-publish', 'ProjectsController@employerProjectPublish')->name('frontend.dashboard.employer.employerProjectPublish');
                            Route::get('student/projects-proposals/{id}', 'ProjectsController@employerProposals')->name('frontend.dashboard.employer.project.proposals');

                            Route::get('student/favourites', 'FavouritesController@employer')->name('frontend.dashboard.employer.favourites');
                            Route::get('student/review', 'ReviewsController@employer')->name('frontend.dashboard.employer.review');
                            Route::get('student/membership-plans', 'MembershipController@employer')->name('frontend.dashboard.employer.membership-plans');
                            Route::get('student/milestones', 'MilestonesController@employer')->name('frontend.dashboard.employer.milestones');
                            Route::get('student/verify-identity', 'VerifyIdentityController@employer')->name('frontend.dashboard.employer.verify-identity');
                            Route::get('student/deposit-funds', 'DepositFundsController@employer')->name('frontend.dashboard.employer.deposit-funds');
                            Route::get('student/profile-settings', 'ProfileController@editEmployer')->name('frontend.dashboard.employer.profile-settings');
                            Route::post('student/profile-settings/store', 'ProfileController@editEmployerStore')->name('frontend.dashboard.employer.profile-settings.store');

                        });
                    });
                    // Employer Dashboard end

                });

                Route::middleware('freelancer.check')->group(function (){
                    // Freelancer Dashboard start
                    Route::namespace('Cabinet')->group(function (){
                        Route::prefix('dashboard')->group(function (){
                            Route::get('freelancer', 'DashboardController@freelancer')->name('frontend.dashboard.freelancer');
                            Route::get('teacher/service-proposals', 'ProjectsController@freelancer')->name('frontend.dashboard.freelancer.project-proposals');
                            Route::get('teacher/service-hireds', 'ProjectsController@freelancerHireds')->name('frontend.dashboard.freelancer.project-hireds');
                            Route::post('teacher/service-hireds/accept', 'ProjectsController@freelancerHiredsAccept')->name('frontend.dashboard.freelancer.project-hireds.accept');
                            Route::post('teacher/service-hireds/complete', 'ProjectsController@freelancerHiredsComplete')->name('frontend.dashboard.freelancer.project-hireds.complete');
                            Route::post('teacher/service-hireds/cancel', 'ProjectsController@freelancerHiredsCancel')->name('frontend.dashboard.freelancer.project-hireds.cancel');
                            Route::post('teacher/service-proposals/store', 'ProjectsController@freelancerProposalStore')->name('frontend.dashboard.freelancer.project-proposals.store');
                            Route::post('teacher/service-proposals/store/ajax', 'ProjectsController@freelancerProposalStoreAjax')->name('frontend.dashboard.freelancer.project-proposals.store.ajax');
                            Route::post('teacher/service-proposals/edit', 'ProjectsController@freelancerProposalEdit')->name('frontend.dashboard.freelancer.project-proposals.edit');
                            Route::post('teacher/service-proposals/delete', 'ProjectsController@freelancerProposalDelete')->name('frontend.dashboard.freelancer.project-proposals.delete');
                            Route::get('teacher/service-ongoing', 'ProjectsController@freelancerOngoing')->name('frontend.dashboard.freelancer.project-ongoing');
                            Route::get('teacher/service-completed', 'ProjectsController@freelancerCompleted')->name('frontend.dashboard.freelancer.project-completed');
                            Route::post('teacher/service-completed/review', 'ProjectsController@freelancerCompletedReview')->name('frontend.dashboard.freelancer.project-completed.review');
                            Route::get('teacher/service-cancelled', 'ProjectsController@freelancerCancelled')->name('frontend.dashboard.freelancer.project-cancelled');
                            Route::get('teacher/favourites', 'FavouritesController@freelancer')->name('frontend.dashboard.freelancer.favourites');
                            Route::get('teacher/reviews', 'ReviewsController@freelancer')->name('frontend.dashboard.freelancer.reviews');

                            Route::get('teacher/portfolio', 'PortfolioController@freelancer')->name('frontend.dashboard.freelancer.portfolio');
                            Route::post('teacher/portfolio/add/store', 'PortfolioController@addStore')->name('frontend.dashboard.freelancer.portfolio.add.tore');
                            Route::post('teacher/portfolio/edit/store', 'PortfolioController@editStore')->name('frontend.dashboard.freelancer.portfolio.edit.tore');
                            Route::post('teacher/portfolio/delete/store', 'PortfolioController@deleteStore')->name('frontend.dashboard.freelancer.portfolio.delete.tore');

                            Route::get('teacher/membership', 'MembershipController@freelancer')->name('frontend.dashboard.freelancer.membership');
                            Route::get('teacher/verify-identity', 'VerifyIdentityController@freelancer')->name('frontend.dashboard.freelancer.verify-identity');
                            Route::get('teacher/withdraw-money', 'WithdrawMoneyController@freelancer')->name('frontend.dashboard.freelancer.withdraw-money');

                            Route::post('teacher/withdraw-money/bank/step1', 'WithdrawMoneyController@bankStep1')->name('frontend.dashboard.freelancer.pay.bank.step1');
                            Route::post('teacher/withdraw-money/bank/step2', 'WithdrawMoneyController@bankStep2')->name('frontend.dashboard.freelancer.pay.bank.step2');
                            Route::post('teacher/withdraw-money/bank/step3', 'WithdrawMoneyController@bankStep3')->name('frontend.dashboard.freelancer.pay.bank.step3');
                            Route::get('teacher/withdraw-money/bank/step_status/{paymentId}', 'WithdrawMoneyController@bankStepStatus')->name('frontend.dashboard.freelancer.pay.bank.stepStatus');
                            Route::get('teacher/withdraw-money/bank/progress', 'WithdrawMoneyController@bankStepProgress')->name('frontend.dashboard.freelancer.pay.bank.stepProgress');
                            Route::get('teacher/withdraw-money/bank/success', 'WithdrawMoneyController@bankStepSuccess')->name('frontend.dashboard.freelancer.pay.bank.stepSuccess');
                            Route::get('teacher/withdraw-money/bank/error', 'WithdrawMoneyController@bankStepError')->name('frontend.dashboard.freelancer.pay.bank.stepError');

                            Route::get('teacher/transaction-history', 'WithdrawMoneyController@freelancerTransactionHistory')->name('frontend.dashboard.freelancer.transaction-history');
                            Route::get('teacher/view-invoice/{id}', 'WithdrawMoneyController@freelancerViewInvoice')->name('frontend.dashboard.freelancer.view-invoice');
                            Route::get('teacher/profile-settings', 'ProfileController@editFrelancer')->name('frontend.dashboard.freelancer.profile-settings');
                            Route::post('teacher/profile-settings/store', 'ProfileController@editFrelancerStore')->name('frontend.dashboard.freelancer.-settings.store');
                            Route::post('teacher/profile-settings/store', 'ProfileController@editFrelancerStore')->name('frontend.dashboard.freelancer.profile-settings.store');
                            Route::get('teacher/subscribers', 'SubscribersController@show')->name('frontend.dashboard.subscribers');
                            Route::post('teacher/subscribers/update', 'SubscribersController@update')->name('frontend.dashboard.subscribers.update');
                            Route::post('teacher/subscribers/store', 'SubscribersController@store')->name('frontend.dashboard.subscribers.store');




                            Route::get('teacher/courses', 'CourseController@index')->name('frontend.dashboard.freelancer.courses');
                            Route::get('teacher/create', 'CourseController@create')->name('frontend.dashboard.freelancer.create.courses');
                            Route::get('teacher/{course}/edit', 'CourseController@edit')->name('frontend.dashboard.freelancer.edit.courses');
                            Route::post('teacher/courses/add/store', 'CourseController@store')->name('frontend.dashboard.freelancer.courses.add.store');
                            Route::post('teacher/courses/{course}', 'CourseController@update')->name('frontend.dashboard.courses.update');
                            Route::delete('courses/{id}/files/{file}', 'CourseController@deleteFile')->name('frontend.dashboard.courses.deleteFile');
                            Route::delete('courses/{course}', 'CourseController@destroy')->name('frontend.dashboard.courses.destroy');


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
                Route::get('/pay/subscribers/{subscriber}', 'Pay\PayController@paymentSubscribers')->name('frontend.pay.subscribers');
                Route::get('/pay/subscribers/status/{pay}', 'Pay\PayController@paymentSubscribersStatus')->name('frontend.pay.subscribers.status')->middleware('signed');


                Route::get('/pay/accesses/{access}', 'Pay\PayController@paymentAccess')->name('frontend.pay.access');
                Route::get('/pay/accesses/{access}/status/{pay}', 'Pay\PayController@paymentAccessStatus')->name('frontend.pay.accesses.status')->middleware('signed');
                /*   PAY END   */

                Route::get('/subscribers/{subscriber}/unsubscribe', 'Cabinet\SubscribersController@unsubscribe')->name('frontend.unsubscribe');

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
            Route::get('/teachers', 'Developer\DeveloperController@index')->name('frontend.developer.index');
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
            Route::post('/profile/store-comment/{toId}', 'Developer\DeveloperController@storeComment')->name('frontend.service.store-comment');
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



