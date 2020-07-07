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
        //Check if Image Link is avaliable
        if (preg_match('/https:\/\//',$this->photos->bySubBreed($breed, $subBreed))) {
            // Create attachment
            $attachment = new Image($this->photos->bySubBreed($breed, $subBreed), [
                'custom_payload' => true,
            ]);
            //Get Breed Name
            $randomBreed = explode('/', $this->photos->bySubBreed($breed, $subBreed))[4];
            // Build message object
            $message = OutgoingMessage::create('Breed: ' . ucfirst($randomBreed) . '
Source: https://dog.ceo')->withAttachment($attachment);
            // Reply message object
            $bot->reply($message);
        }else {
            $bot->reply($this->photos->bySubBreed($breed, $subBreed));
        }
    }
}