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
        $question = Question::create("Write Us A Review")
            ->addButtons([
                Button::create('Cancel ❌')->value('no')
            ]);

        $this->ask($question, function (Answer $answer) {
            //Get Chat Information
            $payload = $answer->getMessage()->getPayload();

            // Detect if button was clicked
            if (!$answer->isInteractiveMessageReply()) {
                $ignoreKeywords = [
                    '/start', '/start@'.env('TELEGRAM_USERNAME'),
                    '/random', '🎲 Random Dog Image', '/random@'.env('TELEGRAM_USERNAME'),
                    '/b', '/bs', '🖼 A Image by Breed', '/b@'.env('TELEGRAM_USERNAME'), '/bs@'.env('TELEGRAM_USERNAME'),
                    '/s', '/ss', '🖼 A Image by Sub-Breed', '/s@'.env('TELEGRAM_USERNAME'), '/ss@'.env('TELEGRAM_USERNAME'),
                    '/dev', '/dev@'.env('TELEGRAM_USERNAME'),
                    '/help', '❓ Help Center', '/help@'.env('TELEGRAM_USERNAME'),
                    '/feedback', '📄 Review', '/feedback@'.env('TELEGRAM_USERNAME'),
                ];

                if (in_array($answer->getText(), $ignoreKeywords)) {
                    //Ask Question again
                    return $this->say($this->defaultQuestion());
                }else {
                    //Store Review
                    (new ReviewController)->store($payload);

                    //Get Message Id
                    $message_id = accessProtected($payload, 'items')['message_id'];
                    
                    //create or update record about the subscribers
                    (new SubscriberController)->storeOrUpdate($payload);

                    return $this->say('Thanks so much for your feedback.', ['reply_to_message_id' => $message_id]);
                }
            }

            //create or update record about the subscribers
            (new SubscriberController)->storeOrUpdate($payload);

            return $this->say('Canceled.', ['allow_sending_without_reply' => true]);
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
