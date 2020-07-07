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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', function () {
    return redirect('https://www.youtube.com/watch?v=ndsEQLgidyU');
});
Route::get('/wp-admin', function () {
    return redirect('https://www.youtube.com/watch?v=ndsEQLgidyU');
});
Route::get('/login', function () {
    return redirect('https://www.youtube.com/watch?v=ndsEQLgidyU');
});
//Route::get('/botman/tinker', 'BotManController@tinker');

