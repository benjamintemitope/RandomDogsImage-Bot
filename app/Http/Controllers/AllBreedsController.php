<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DogService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\TelegramDriver;
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

        //Check if Image Link is avaliable
        if (preg_match('/https:\/\//', $this->photos->random())) {
            // Create attachment
            $attachment = new Image($this->photos->random(), [
                'custom_payload' => true,
            ]);
            //Get Breed Name
            $randomBreed = explode('/', $this->photos->random())[4];
            $randomBreed = str_replace('-', ' ', $randomBreed);
            // Build message object
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($randomBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);
            // Reply message object
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
        //Check if Image Link is avaliable
        if (preg_match('/https:\/\//', $this->photos->byBreed($name))) {
            // Create attachment
            $attachment = new Image($this->photos->byBreed($name), [
                'custom_payload' => true,
            ]);
            //Get Breed Name
            $randomBreed = explode('/', $this->photos->byBreed($name))[4];
            $randomBreed = str_replace('-', ' ', $randomBreed);
            // Build message object
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($randomBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);
            // Reply message object
            $bot->reply($message, ['parse_mode' => 'HTML']);
        }else {
            $bot->reply($this->photos->byBreed($name), ['parse_mode' => 'HTML']);
        }
    }

}
