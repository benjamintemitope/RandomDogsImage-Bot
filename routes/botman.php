<?php
use App\Http\Controllers\BotManController;
use App\Conversations\StartConversation;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');

//Start Bot
$botman->hears(['/start', '/start@{username}'], function ($bot) {
    $user = $bot->getUser();
    $username = $user->getUsername();
    $bot->reply('Hello! ' . $username);
});
$botman->hears(['/start', '/start@{username}'], 'App\Http\Controllers\ConversationController@index');

//Random Image
$botman->hears(['/random', '🎲 Random Dog Image', '/random@{username}'], 'App\Http\Controllers\AllBreedsController@random');


/**
 * Breed Commands
 */
//Fetch {breed}
$botman->hears('/b {breed}', 'App\Http\Controllers\BreedController@byBreed');
//Breed Search
$botman->hears(['/b', '/bs', '/b@{username}', '/bs@{username}', '🖼 A Image by breed'], 'App\Http\Controllers\ConversationController@byBreed');
//Breed Search {breed}
$botman->hears('/bs {breed}', 'App\Http\Controllers\SearchBreedsController@byBreed');


/**
 * Sub-breed Commands
 */

//Fetch {breed}:{subBreed}
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
//Sub-Breed Search
$botman->hears(['/s', '/ss', '/s@{username}', '/ss@{username}', '🖼 A Image by Sub-Breed'], 'App\Http\Controllers\ConversationController@bySubBreed');
//Sub-Breed Search {subBreed}
$botman->hears('/ss {subBreed}', 'App\Http\Controllers\SearchBreedsController@bySubBreed');



//Developer
$botman->hears(['/dev', '/dev@{username}'], function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});

//Help Desk
$botman->hears(['/help', '/help@{username}', '❓ Help Center'], 'App\Http\Controllers\HelpDeskController@index');

//Command Error
$botman->fallback('App\Http\Controllers\FallbackController@index');

//Sticker Send
$botman->hears('dice', function($bot){
    $bot->sendRequest('sendSticker', [
        'sticker' => 'CAACAgIAAxkBAAEBBGhfBOSYqHcypPTn9rBRDDu5h3IZ4AACYm4AAp7OCwABPf4vNIQDD-0aBA'
    ]);
});