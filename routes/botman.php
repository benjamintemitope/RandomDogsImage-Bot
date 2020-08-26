<?php
use App\Conversations\DefaultConversation;
use App\Conversations\StartConversation;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');

//Start command
$botman->hears(['/start', '/start@{username}'], 'App\Http\Controllers\ConversationController@index');

//Random Breed Command
$botman->hears(['/random', '🎲 Random Dog Image', '/random@{username}'], 'App\Http\Controllers\AllBreedsController@random');

//Breed Query Command
$botman->hears('/b {breed}', 'App\Http\Controllers\BreedController@byBreed');

//Search Breed
$botman->hears(['/b', '/bs', '/b@{username}', '/bs@{username}', '🖼 A Image by Breed'], 'App\Http\Controllers\ConversationController@byBreed');

//Search Breed Query Command
$botman->hears('/bs {breed}', 'App\Http\Controllers\SearchBreedsController@byBreed');

//SubBreed Query Command
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');

//Search Sub-Breed Command
$botman->hears(['/s', '/ss', '/s@{username}', '/ss@{username}', '🖼 A Image by Sub-Breed'], 'App\Http\Controllers\ConversationController@bySubBreed');

//Search Sub-Breed Query Command
$botman->hears('/ss {subBreed}', 'App\Http\Controllers\SearchBreedsController@bySubBreed');

//Developer Command
$botman->hears(['/dev', '/dev@{username}'], function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});

//Help Desk
$botman->hears(['/help', '/help@{username}', '❓ Help Center'], 'App\Http\Controllers\HelpDeskController@index');

//Command Error
$botman->fallback('App\Http\Controllers\FallbackController@index');

//Stickers Commads
$botman->hears(['dog', 'dog@{username}', '/dog', '/dog@{username}'], function($bot){
    $bot->sendRequest('sendSticker', [
        'sticker' => 'CAACAgIAAxkBAAEBMphfNcnSmApYpPM-LkCwmAeLHwABufgAAg8CAAI2diAOgId0VJ7dIYIaBA'
    ]);
});

$botman->hears(['stop', 'stop@{username}', '/stop', '/stop@{username}'], function($bot){
    $bot->sendRequest('sendSticker', [
        'sticker' => 'CAACAgIAAxkBAAEBMppfNconW5ME4nCTVZXChCCOAeYVrwACFAIAAjZ2IA6_Kxh24r9gPRoE'
    ]);
});

$botman->hears(['dice', 'dice@{username}', '/dice', '/dice@{username}'], function($bot){
    $bot->sendRequest('sendDice', [
        'emoji' => '🎲'
    ]);
});

$botman->hears(['/feedback', '/feedback@{username}'], 'App\Http\Controllers\ConversationController@feedback');

