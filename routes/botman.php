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
//Breed Command
$botman->hears('/b',function ($bot) {
    $bot->reply("Invalid Respond!\n<b>Usage</b>: /b {breed} \ne.g /b hound", ['parse_mode' => 'HTML']);
});
//SubBreed Image
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
//Breed Command
$botman->hears('/s',function ($bot) {
    $bot->reply("Invalid Respond!\n<b>Usage</b>: /s {breed}:{subBreed} \ne.g /s hound:afghan", ['parse_mode' => 'HTML']);
});
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