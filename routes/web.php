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

// -------------------[USER]-------------------

//  [PUBLIC MAP]

Route::get('/', function () {
    return view('home');
});


// -------------------[ADMIN]-------------------

// Route::get('/admin', function () {
//     return view('admin');
// });

//  [CONNEXION]

//  [ADMIN LIST]

//  [EDIT/CREATE CATEGORIES]

//  [EDIT/CREATE REFERENCES]

//  [EDIT/CREATE POINTS]