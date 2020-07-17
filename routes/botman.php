<?php
use App\Http\Controllers\BotManController;
use App\Conversations\StartConversation;

$botman = resolve('botman');

//Start Bot
$botman->hears('/start', function ($bot) {
    $user = $bot->getUser();
    $username = $user->getUsername();
    $bot->reply('Hello! ' . $username);
});
$botman->hears('/start', 'App\Http\Controllers\ConversationController@index');

//Random Image
$botman->hears('/random', 'App\Http\Controllers\AllBreedsController@random');

//Breed Commands
$botman->hears('/b {breed}', 'App\Http\Controllers\BreedsController@byBreed');
$botman->hears(['/b', '/bs'], 'App\Http\Controllers\ConversationController@byBreed');
$botman->hears('/bs {breed}', 'App\Http\Controllers\SearchBreedsController@byBreed');

//SubBreed Commands
$botman->hears('/s {breed}:{subBreed}', 'App\Http\Controllers\SubBreedController@random');
$botman->hears(['/s', '/ss'], 'App\Http\Controllers\ConversationController@bySubBreed');
$botman->hears('/ss {breed}', 'App\Http\Controllers\SearchBreedsController@bySubBreed');

//Developer
$botman->hears('/dev', function ($bot) {
    $bot->reply('The Developer 🌐: @LookBig');
});

//Help Desk
$botman->hears('/help', 'App\Http\Controllers\HelpDeskController@index');

//Command Error
$botman->fallback('App\Http\Controllers\FallbackController@index');

$botman->hears('dice', function($bot){
    $bot->sendRequest('sendSticker', [
        'sticker' => 'CAACAgIAAxkBAAEBBGhfBOSYqHcypPTn9rBRDDu5h3IZ4AACYm4AAp7OCwABPf4vNIQDD-0aBA'
    ]);
});