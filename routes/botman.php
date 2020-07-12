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
    $bot->reply("Invalid Respond!\n<b>Usage</b>: /b {breed} \n<code>e.g /b hound</code>", ['parse_mode' => 'HTML']);
});
//SubBreed Image
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
//Breed Command
$botman->hears('/s',function ($bot) {
    $bot->reply("Invalid Respond!\n<b>Usage</b>: /s {breed}:{subBreed} \n<code>e.g /s hound:afghan</code>", ['parse_mode' => 'HTML']);
});
//Developer
$botman->hears('/dev', function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});
//Help Desk
$botman->hears('/help', 'App\Http\Controllers\HelpDeskController@index');
//Command Error
$botman->fallback('App\Http\Controllers\FallbackController@index');