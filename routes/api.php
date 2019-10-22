<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//ADMIN ONLY

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('dashboard', function () {
            return response()->json(['data' => 'Test Data']);
        });
    });

    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {

        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

    });

//USER & ADMIN

    Route::resource('/images', 'ImagesController');

    Route::resource('/points', 'PointsController');

    Route::resource('/pointsnames', 'PointsnamesController');

    Route::resource('/references', 'ReferencesController');

    Route::resource('/referencesnames', 'ReferencesnamesController');

    // Route::resource('/categories', 'CategoriesController', [
    //     'except' => ['edit', 'show', 'store']
    // ]);

    Route::resource('/categories', 'CategoriesController');

    Route::resource('/categoriesnames', 'CategoriesnamesController');

    Route::resource('/languages', 'LanguagesController');

    Route::resource('/contact', 'ContactController');

    // Route::resource('/contactus', 'ContactusController');

    // Route::resource('/contactform', 'ContactformController', [
    //     'except' => ['edit', 'show', 'store']
    // ]);

