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

class AllBreedsController extends Controller
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
     * Return a random dog image from all breeds.
     *
     * @return void
     */
    public function random($bot)
    {
        // $this->endpoint->random() is basically the photo URL returned from the service.
        // $bot->reply is what we will use to send a message back to the user.
        $breedURL = $this->endpoint->random();
        if (preg_match('/https:\/\//', $breedURL)) {
            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);
            $nameBreed = explode('/', $breedURL)[4];
            $nameBreed = str_replace('-', ' ', $nameBreed);
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);
            $bot->reply($message, ['parse_mode' => 'HTML']);
        }else {
            $bot->reply($this->endpoint->random(), ['parse_mode' => 'HTML']);
        }
    }
}
