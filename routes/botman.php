<?php
use App\Http\Controllers\BotManController;
use App\Conversations\StartConversation;

$botman = resolve('botman');

//Start Bot
$botman->hears('/start', function ($bot) {
    $user = $bot->getUser();
    $username = $user->getUsername();
    $bot->reply('Hello! ' . $username);
    $bot->typesAndWaits(1);
});
$botman->hears('/start', 'App\Http\Controllers\ConversationController@index');

//Random Image
$botman->hears('/random', 'App\Http\Controllers\AllBreedsController@random');

//Breed Commands
$botman->hears('/b {breed}', 'App\Http\Controllers\AllBreedsController@byBreed');
$botman->hears('/b', 'App\Http\Controllers\AllBreedsController@fallback');
$botman->hears('/bs {breed}', 'App\Http\Controllers\SearchBreedsController@searchBreed');
$botman->hears('/bs', 'App\Http\Controllers\SearchBreedsController@searchBreedFallback');

//SubBreed Commands
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
$botman->hears('/s', 'App\Http\Controllers\SubBreedController@fallback');
$botman->hears('/ss {breed}', 'App\Http\Controllers\SearchBreedsController@searchSubBreed');
$botman->hears('/ss', 'App\Http\Controllers\SearchBreedsController@searchSubBreedFallback');

//Developer
$botman->hears('/dev', function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});

//Help Desk
$botman->hears('/help', 'App\Http\Controllers\HelpDeskController@index');

//Command Error
$botman->fallback('App\Http\Controllers\FallbackController@index');

$botman->hears('heeelo', function($bot){
    $bot->sendRequest('sendSticker', [
        'sticker' => 'CAACAgIAAxkBAAEBBGhfBOSYqHcypPTn9rBRDDu5h3IZ4AACYm4AAp7OCwABPf4vNIQDD-0aBA'
    ]);
});