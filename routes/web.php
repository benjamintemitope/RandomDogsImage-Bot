<?php

use App\Http\Controllers\ConversationController;

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

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth')->name('logs');

Route::get('reviews', 'ReviewController@index')->middleware('auth')->name('reviews');

//Send Conversation
Route::post('send/{id}', 'SendConversation@sendConversation')->middleware('auth');

/*Route::get('/botman/tinker', 'BotManController@tinker');*/
