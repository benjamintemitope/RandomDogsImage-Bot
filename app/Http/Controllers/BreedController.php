<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriberController;
use App\Services\DogService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Telegram\TelegramDriver;
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
         // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        $userId = $bot->getUser()->getInfo()['user']['id'];
        
        //Get Message Id
        $payload = (array)$bot->getMessage()->getPayload();
        $prefix = chr(0).'*'.chr(0);
        $message_id = $payload[$prefix.'items']['message_id'];

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

            //sending photo status
            $bot->sendRequest('sendChatAction', [
                'user_id' => $userId,
                'action' => 'upload_photo'
            ]);

            $bot->reply($message, ['parse_mode' => 'HTML', 'reply_to_message_id' => $message_id]);
        }else {
            $bot->reply($this->endpoint->byBreed($name), ['parse_mode' => 'HTML', 'reply_to_message_id' => $message_id]);
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
