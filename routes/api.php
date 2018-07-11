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

Route::resource('/points', 'PointsController', [
    'except' => ['edit', 'show', 'store']
]);

Route::resource('/languages', 'LanguagesController', [
    'except' => ['edit', 'show', 'store']
]);

Route::resource('/references', 'ReferencesController', [
    'except' => ['edit', 'show', 'store']
]);

Route::resource('/categories', 'CategoriesController', [
    'except' => ['edit', 'show', 'store']
]);