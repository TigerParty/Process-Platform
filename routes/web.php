<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::group(['prefix' => 'location'], function() {
            Route::get('/', 'RegionController@index')->name('admin.region.index');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Internal Auth API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'api'], function() {
        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
            Route::group(['prefix' => 'location'], function() {
                Route::get('/', 'RegionController@indexApi')->name('admin.region.indexApi');
                Route::post('/', 'RegionController@storeApi')->name('admin.region.storeApi');
                Route::put('/{id}', 'RegionController@updateApi')->name('admin.region.updateApi');
                Route::delete('/{id}', 'RegionController@deleteApi')->name('admin.region.deleteApi');
            });
        });
    });
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('login', 'LoginController@showLoginForm')->name('admin.showLogin');
    Route::post('login', 'LoginController@login')->name('admin.login');
    Route::get('logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['namespace' => 'Frontend'], function() {
    Route::get('/', 'HomeController@index');
});

/*
|--------------------------------------------------------------------------
| Internal Public API Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api'], function() {
    Route::group(['namespace' => 'Frontend'], function() {

        Route::get('/region', 'RegionController@indexApi');
    });

    Route::group(['prefix' => 'activiti'], function() {
        Route::get('/', 'ActivitiController@getApi');
        Route::post('/', 'ActivitiController@postApi');
    });
});
