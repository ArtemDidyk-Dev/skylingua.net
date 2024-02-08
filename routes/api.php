<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::namespace('Api')->group(function () {
    Route::post('login', 'ApiController@login')->name('api.login');
});


Route::middleware('auth:api')->group(function () {
    Route::namespace('Api')->group(function () {
        Route::get('getUser', 'ApiController@getUser')->name('api.getUser');
    });

});


Route::middleware('client')->group(function () {
    Route::namespace('Api')->group(function () {
        Route::post('orders', 'ApiController@orders')->name('api.orders');
        Route::post('login2', 'ApiController@login')->name('api.login');
    });

});


/*   CREATE TOKEN FOR WEB CLIENT START   */
Route::middleware('api.secret.key')->group(function () {
    Route::namespace('Api')->group(function () {
        Route::post('createTokenForClient', 'ApiController@createTokenForClient')->name('api.createTokenForClient');
    });
});


Route::namespace('\Laravel\Passport\Http\Controllers')
    ->middleware(['throttle'])->group(function () {
        Route::post('createTokenForClientAccess', 'AccessTokenController@issueToken');
    });
/*   CREATE TOKEN FOR WEB CLIENT END   */




