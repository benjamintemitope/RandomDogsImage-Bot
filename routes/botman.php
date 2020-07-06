<?php
use App\Http\Controllers\BotManController;
use App\Conversations\StartConversation;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    $user = $bot->getUser();
    $username = $user->getUsername();
    $bot->reply('Hello! ' . $username  . ' 😄');
});
$botman->hears('/start', 'App\Http\Controllers\ConversationController@index');

$botman->hears('/random', 'App\Http\Controllers\AllBreedsController@random');
$botman->hears('/b {breed}', 'App\Http\Controllers\AllBreedsController@byBreed');
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');

$botman->fallback('App\Http\Controllers\FallbackController@index');


$botman->hears('/dev', function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});


$botman->hears('/url', function ($bot)
{
    $bot->reply(
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
    );
});

$botman->hears('/help', function($bot)
{
    $bot->reply('Welcome to the Help Desk') ;
});

