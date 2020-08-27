<?php

namespace App\Conversations;

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ReviewController;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;


class ReviewConversation extends Conversation
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
            
            //Get Chat Information
            $payload = $answer->getMessage()->getPayload();
            (new ReviewController)->store($payload);
            //create or update record about the subscribers
            (new SubscriberController)->storeOrUpdate($payload);

            //Get Message Id
            //Convert Protected Object to Array
            $payload = (array)$payload;
            $prefix = chr(0).'*'.chr(0);

            $message_id = $payload[$prefix.'items']['message_id'];
            
            $this->say('Nice to meet you.', ['reply_to_message_id' => $message_id]);
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
    
    
}
