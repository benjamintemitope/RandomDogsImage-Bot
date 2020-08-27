<?php

namespace App\Http\Controllers;

use App\Conversations\BreedConversation;
use App\Conversations\DefaultConversation;
use App\Conversations\ReviewConversation;
use App\Conversations\NewConversation;
use App\Conversations\SubBreedConversation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SubscriberController;
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

    public function feedback($bot)
    {
        // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        $bot->startConversation(new ReviewConversation());
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