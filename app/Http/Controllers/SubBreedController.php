<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;
use App\Services\DogService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Http\Request;

class SubBreedController extends Controller
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
    public function random($bot, $breed, $subBreed)
    {
        // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        $userId = $bot->getUser()->getInfo()['user']['id'];

        //Get Message Id
        $payload = (array)$bot->getMessage()->getPayload();
        $prefix = chr(0).'*'.chr(0);
        $message_id = $payload[$prefix.'items']['message_id'];

        $breed = strtolower($breed);
        $subBreed = strtolower($subBreed);
        $breedURL = $this->endpoint->bySubBreed($breed, $subBreed);
        if (preg_match('/https:\/\//', $breedURL)) {
            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);
            $nameBreed = explode('/', $breedURL)[4];
            $nameBreed = str_replace('-', ' ', $nameBreed);
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);

            //sending photo notification
            $bot->sendRequest('sendChatAction', [
                'user_id' => $userId,
                'action' => 'upload_photo'
            ]);

            $bot->reply($message, ['parse_mode' => 'HTML', 'reply_to_message_id' => $message_id]);
        }else {
            $bot->reply($breedURL, ['parse_mode' => 'HTML', 'reply_to_message_id' => $message_id]);
        }
    }

    /**
     * Create or Update record about the subscribers
     * 
     * @return void
     */
    public function storeOrUpdate($bot)
    {
        //Get Chat Information
        $messagePayload = $bot->getMessage()->getPayload();
        (new SubscriberController)->storeOrUpdate($messagePayload);
    }
}