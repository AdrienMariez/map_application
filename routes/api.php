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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// -------------------[ADMIN]-------------------

    //  [CONNEXION]

        Route::resource('/auth/register', 'AuthController@register', [
            'except' => ['edit', 'show', 'store']
        ]);

        Route::post('auth/login', 'AuthController@login');
        
        Route::group(['middleware' => 'jwt.auth'], function(){
            Route::get('auth/user', 'AuthController@user');
            Route::post('auth/logout', 'AuthController@logout');
        });
        
        Route::group(['middleware' => 'jwt.refresh'], function(){
            Route::get('auth/refresh', 'AuthController@refresh');
        });

// -------------------[USER]-------------------

    //  [PUBLIC MAP]

    Route::resource('/points', 'PointsController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/pointsnames', 'PointsnamesController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/languages', 'LanguagesController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/references', 'ReferencesController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/referencesnames', 'ReferencesnamesController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/categories', 'CategoriesController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/categoriesnames', 'CategoriesnamesController', [
        'except' => ['edit', 'show', 'store']
    ]);

    Route::resource('/contactform', 'ContactformController', [
        'except' => ['edit', 'show', 'store']
    ]);