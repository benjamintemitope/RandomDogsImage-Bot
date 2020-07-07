<?php
use App\Http\Controllers\BotManController;
use App\Conversations\StartConversation;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $user = $bot->getUser();
    $username = $user->getUsername();
    $bot->reply('Hello! ' . $username  . ' 😄');
});
//Start Bot
$botman->hears('/start', 'App\Http\Controllers\ConversationController@index');
//Random Image
$botman->hears('/random', 'App\Http\Controllers\AllBreedsController@random');
//Breed Image
$botman->hears('/b {breed}', 'App\Http\Controllers\AllBreedsController@byBreed');
//SubBreed Image
//$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
//Developer
$botman->hears('/dev', function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});
//Return current URL for Testing
$botman->hears('/url', function ($bot)
{
    $bot->reply(
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
    );
});
//Help Desk
$botman->hears('/help', 'App\Http\Controllers\HelpDeskController@index');
//Command Error
$botman->fallback('App\Http\Controllers\FallbackController@index');