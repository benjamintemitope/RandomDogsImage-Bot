<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Conversations\DefaultConversation;
use App\Conversations\NewConversation;
use App\Conversations\BreedConversation;
use App\Conversations\SubBreedConversation;

class ConversationController extends Controller
{
    /**
     * Create a new conversation.
     *
     * @return void
     */
    public function index($bot)
    {
        // We use the startConversation method provided by botman to start a new conversation and pass
        // our conversation class as a param to it.
        $bot->startConversation(new DefaultConversation());
    }

    public function new($bot)
    {
        // We use the startConversation method provided by botman to start a new conversation and pass
        // our conversation class as a param to it.
        $bot->startConversation(new NewConversation());
    }

    /**
     * Breed Conversation.
     *
     * @return void
    */
    public function byBreed($bot)
    {
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
        // We use the startConversation method provided by botman to start a new conversation and pass
        // our conversation class as a param to it.
        $bot->startConversation(new SubBreedConversation());
    }
}