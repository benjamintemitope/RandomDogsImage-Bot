<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DogService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    /**
     * Controller constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->endpoint = new DogService;
    }

    /**
     * Return a random dog image from a given breed.
     *
     * @return void
    */
    public function byBreed($bot, $name)
    {
        // Because we used a wildcard in the command definition, Botman will pass it to our method.
        // Again, we let the service class handle the API call and we reply with the result we get back.
        $breedURL = $this->endpoint->byBreed($name);
        if (preg_match('/https:\/\//', $breedURL)) {
            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);
            $nameBreed = explode('/', $breedURL)[4];
            $nameBreed = str_replace('-', ' ', $nameBreed);
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);
            $bot->reply($message, ['parse_mode' => 'HTML']);
        }else {
            $bot->reply($this->endpoint->byBreed($name), ['parse_mode' => 'HTML']);
        }
    }
}
