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
use ReflectionClass;

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
        // We create or update record about the subscribers
        $this->storeOrUpdate($bot);

        $userId = $bot->getUser()->getInfo()['user']['id'];

        //Get Message Id
        $payload = $bot->getMessage()->getPayload();
        $message_id = accessProtected($payload, 'items')['message_id'];

        //Send Dice Sticker
        $bot->sendRequest('sendDice', [
            'emoji' => '🎲',
            'disable_notification' => false,
            'reply_to_message_id' => $message_id
        ]);

        // $this->endpoint->random() is basically the photo URL returned from the service.
        // $bot->reply is what we will use to send a message back to the user.
        $breedURL = $this->endpoint->random();
        if (preg_match('/https:\/\//', $breedURL)) {
            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);

            //Fetch breed name from the URL
            $nameBreed = explode('/', $breedURL)[4];
            $nameBreed = str_replace('-', ' ', $nameBreed);

            //Send Image
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);

            //Sending Notification
            $bot->sendRequest('sendChatAction', [
                'user_id' => $userId,
                'action' => 'upload_photo'
            ]);

            $bot->reply($message, [
                'parse_mode' => 'HTML', 
                'reply_to_message_id' => $message_id
            ]);
        }else {
            $bot->reply($this->endpoint->random(), ['parse_mode' => 'HTML']);
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
