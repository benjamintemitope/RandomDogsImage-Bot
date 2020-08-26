<?php

namespace App\Conversations;

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;


class FeedbackConversation extends Conversation
{
    /**
       * Question to receive user's feedback
       * 
       * @return void 
    */  

    public function defaultQuestion()
    {
        $question = Question::create('Write Us A Review');
        $this->ask($question, function (Answer $answer) {
            // We fetch the user entry from the endpoint
            $review = $answer->getText();
            \Log::channel('chat')->info(print_r($answer->getMessage()->getPayload(),true));
            // We create or update record about the subscribers
            $this->storeOrUpdate($answer);

            $this->say('Nice to meet you ');
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->defaultQuestion();
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
