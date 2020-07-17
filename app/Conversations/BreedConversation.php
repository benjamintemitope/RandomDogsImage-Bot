<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;

class BreedConversation extends Conversation
{
    /**
     * Question to start the conversation.
     *
     * @return void
    */
    public function defaultQuestion()
    {
        $question = Question::create('Huh - What breed are you looking for? e.g whippet');
        // We ask our user the question.
        $this->ask($question, function (Answer $answer) {
            // We fetch the user entry from the endpoint
            if ($answer->getText()) {
                (new \App\Http\Controllers\SearchBreedsController)->byBreed($this, strval(strtolower($answer->getText())));
            }
        });
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        // This is the boot method, it's what will be excuted first.
        $this->defaultQuestion();
    }
}
