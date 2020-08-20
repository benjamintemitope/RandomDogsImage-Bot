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

//Send Conversation
Route::post('send/{id}', 'SendConversation@sendConversation');

/*Route::get('/botman/tinker', 'BotManController@tinker');*/
