<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;

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

        $bot->reply('Sorry, I did not understand these commands. Try: /help');
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