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
        $this->photos = new DogService;
    }

    /**
     * Return a random dog image from all breeds.
     *
     * @return void
     */
    public function random($bot)
    {
        // $this->photos->random() is basically the photo URL returned from the service.
        // $bot->reply is what we will use to send a message back to the user.
        
        $breedURL = $this->photos->random();

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
            $bot->reply($this->photos->random(), ['parse_mode' => 'HTML']);
        }
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
        $breedURL = $this->photos->byBreed($name);
        if (preg_match('/https:\/\//', $breedURL)) {

            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);

            $nameBreed = explode('/', $breedURL)[4];
            $nameBreed = str_replace('-', ' ', $nameBreed);

            $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);

            $bot->typesAndWaits(1);
            $bot->reply($message, ['parse_mode' => 'HTML']);
        }else {
            $bot->reply($this->photos->byBreed($name), ['parse_mode' => 'HTML']);
        }
    }

    public function fallback($bot)
    {
        $bot->reply("Invalid Respond! \n\n<b>Usage</b>: /b {breed} \n\ne.g <code>/b hound</code>",
        [
            'parse_mode' => 'HTML'
        ]);
    }
}
