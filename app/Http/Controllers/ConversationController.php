<?php

namespace App\Http\Controllers;

use App\Conversations\BreedConversation;
use App\Conversations\DefaultConversation;
use App\Conversations\NewConversation;
use App\Conversations\SubBreedConversation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Create a new conversation.
     *
     * @return void
     */
    public function index($bot)
    {
        // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        // We use the startConversation method provided by botman to start a new conversation and pass
        // our conversation class as a param to it.
        $bot->startConversation(new DefaultConversation());
    }

    /**
     * Breed Conversation.
     *
     * @return void
    */
    public function byBreed($bot)
    {
        // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        // We use the startConversation method provided by botman to start a new conversation and pass
        // our conversation class as a param to it.
        $bot->startConversation(new BreedConversation());
    }

    /**
     * Breed Conversation.
     *
     * @return void
    */
    public function bySubBreed($bot)
    {
        // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        // We use the startConversation method provided by botman to start a new conversation and pass
        // our conversation class as a param to it.
        $bot->startConversation(new SubBreedConversation());
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