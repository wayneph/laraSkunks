<?php

use Illuminate\Support\Facades\Route;

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

/* Route:: / -> index page */
Route::get('/', function () {
    return view('welcome');
});

/* Route:: / -> demo of one. */
Route::get('/one.php', function () {
    return view('one');
});

/* Route:: / -> login */
Route::get('/one.php', function () {
    return view('one');
});
