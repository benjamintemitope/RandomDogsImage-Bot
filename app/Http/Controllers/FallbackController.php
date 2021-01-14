<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriberController;

class FallbackController extends Controller
{
    /**
     * Respond with a generic message.
     *
     * @param Botman $bot
     * @return void
     */
    public function index($bot)
    {
         // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        

        \Log::channel('chat')->info(print_r($bot->getMessage()->getPayload(),true));

        if (is_object($bot->getMessage()->getPayload())) {
            //Get Message Id
            $payload = $bot->getMessage()->getPayload();
            $message_id = accessProtected($payload, 'items')['message_id'];
            $bot->reply('Sorry, I did not understand these commands. Try: /help',[
                'reply_to_message_id' => $message_id
            ]);
        }else {
            $bot->reply('Sorry, I did not understand these commands. Try: /help');
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