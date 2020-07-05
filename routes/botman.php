<?php
use App\Http\Controllers\BotManController;
use App\Conversations\StartConversation;

$botman = resolve('botman');
// Access user
$botman->hears('/start', function ($bot) {
    $user = $bot->getUser();
    $firstname = $user->getFirstName();
    $bot->reply('Hello! ' . $firstname  . ' 😄');
});
//$botman->hears('Start conversation', BotManController::class.'@startConversation');
//$botman->hears('/start', BotManController::class.'@startConversation');

$botman = resolve('botman');
$botman->hears('/random', 'App\Http\Controllers\AllBreedsController@random');
$botman->hears('/b {breed}', 'App\Http\Controllers\AllBreedsController@byBreed');
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
$botman->hears('/start', 'App\Http\Controllers\ConversationController@index');
$botman->fallback('App\Http\Controllers\FallbackController@index');
$botman->hears('/dev', function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});
$botman->hears('/url', function ($bot)
{
    $bot->reply('http://f67614bd6425.ngrok.io');
});

