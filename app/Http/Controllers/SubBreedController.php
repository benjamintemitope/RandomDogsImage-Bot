<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\DogService;
use App\Http\Controllers\Controller;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class SubBreedController extends Controller
{
    /**
     * Controller constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->photos = new DogService;
    }

    /**
     * Return a random dog image from all breeds.
     *
     * @return void
     */
    public function random($bot, $breed, $subBreed)
    {
        $breedURL = $this->photos->bySubBreed($breed, $subBreed);

        if (preg_match('/https:\/\//', $breedURL)) {

            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);

            $nameBreed = explode('/', $breedURL)[4];
            $nameBreed = str_replace('-', ' ', $nameBreed);

            $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);

            $bot->typesAndWaits(1);
            $bot->reply($message, ['parse_mode' => 'HTML']);
        }else {

            $bot->reply($breedURL, ['parse_mode' => 'HTML']);
        }
    }

    public function fallback($bot)
    {
        $bot->reply("Invalid Respond! \n\n<b>Usage</b>:  /s {breed}:{subBreed} \n\ne.g <code>/s hound:afghan</code>",
        [
            'parse_mode' => 'HTML'
        ]
);
    }
}