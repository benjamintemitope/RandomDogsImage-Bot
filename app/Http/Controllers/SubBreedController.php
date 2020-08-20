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

            $bot->reply($message, ['parse_mode' => 'HTML']);
        }else {
            $bot->reply($breedURL, ['parse_mode' => 'HTML']);
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
        $chat_type = $bot->getMessage()
                     ->getPayload()['chat']['type'];

        //If the command is sent privately
        if ($chat_type === 'private') {
            //Get Subscriber Information
            $user = $bot->getUser();
            $info_user = $user->getInfo()['user'];

            //Interact with Controller
            (new SubscriberController)->storeOrUpdate($info_user);
        }else {
            //Get Group Info
            $info_group = $bot->getMessage()->getPayload()['chat'];
            //Interact with Controller
            (new SubscriberGroupController)->storeOrUpdate($info_group);

            //Get Subscriber Info
            $info_user = $bot->getMessage()->getPayload()['from'];
            //Interact with Controller
            (new SubscriberController)->storeOrUpdate($info_user);
        }
    }
}