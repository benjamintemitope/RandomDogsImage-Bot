<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;


class DefaultConversation extends Conversation
{

    /**
     * First question to start the conversation.
     *
     * @return void
     */
    public function defaultQuestion()
    {
        // We first create our question and set the options and their values.
        $question = Question::create('Huh - What do you need?')
            ->addButtons([
                Button::create('🎲 Random Dog photo')->value('random'),
                Button::create('🖼 A photo by breed')->value('breed'),
                Button::create('🖼 A photo by sub-breed')->value('sub-breed'),
            ]);

        // We ask our user the question.
        return $this->ask($question, function (Answer $answer) {
            // Did the user click on an option or entered a text?
            if ($answer->isInteractiveMessageReply()) {
                // We compare the answer to our pre-defined ones and respond accordingly.
                switch ($answer->getValue()) {
                case 'random':
                        $this->random();
                    break;
                    case 'breed':
                        $this->askForBreedName();
                        break;
                    case 'sub-breed':
                        $this->askForSubBreed();
                        break;
                }
            }
        });
    }

    /**
     * Run Random
     *
     * @return void
    */
    public function random()
    {
        //Check if Image Link is avaliable
        if (preg_match('/https:\/\//', (new \App\Services\DogService)->random())) {
            // Create attachment
            $attachment = new Image((new \App\Services\DogService)->random(), [
                'custom_payload' => true,
            ]);
            //Get Breed Name
            $randomBreed = explode('/', (new \App\Services\DogService)->random())[4];
            $randomBreed = str_replace('-', ' ', $randomBreed);
            // Build message object
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($randomBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);
            // Reply message object
            $this->bot->typesAndWaits(1);

            $this->say($message, ['parse_mode' => 'HTML']);
        }else {
            $this->say((new \App\Services\DogService)->random(), ['parse_mode' => 'HTML']);
        }
    }

    /**
     * Ask for the breed name and send the image.
     *
     * @return void
     */
    public function askForBreedName()
    {
        $this->ask('What\'s the breed name? e.g <i>bulldog</i>', function (Answer $answer) {
            $name = $answer->getText();
            //Check if Image Link is avaliable
            if (preg_match('/https:\/\//', (new App\Services\DogService)->byBreed($name))) {
                // Create attachment
                $attachment = new Image((new App\Services\DogService)->byBreed($name), [
                    'custom_payload' => true,
                ]);
                //Get Breed Name
                $randomBreed = explode('/', (new App\Services\DogService)->byBreed($name))[4];
                $randomBreed = str_replace('-', ' ', $randomBreed);
                // Build message object
                $message = OutgoingMessage::create("Breed: <b>" . ucwords($randomBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);
                // Reply message object
               $this->say($message, ['parse_mode' => 'HTML']);
            }else {
                $this->say((new App\Services\DogService)->byBreed($name), ['parse_mode' => 'HTML']);
            }
        }, ['parse_mode' => 'HTML']);
    }

    /**
     * Ask for the breed name and send the image.
     *
     * @return void
     */
    public function askForSubBreed()
    {
        $this->ask('What\'s the breed and sub-breed names? e.g <i>bulldog:english</i>', function (Answer $answer) {
            $answer = explode(':', strtolower($answer->getText()));
            if (preg_match('/https:\/\//', (new App\Services\DogService)->bySubBreed($answer[0], $answer[1]))) {
                // Create attachment
                $attachment = new Image((new App\Services\DogService)->bySubBreed($answer[0], $answer[1]), [
                    'custom_payload' => true,
                ]);
                //Get Breed Name
                $randomBreed = explode('/', (new App\Services\DogService)->bySubBreed($answer[0], $answer[1]))[4];
                $randomBreed = str_replace('-', ' ', $randomBreed);
                // Build message object
                $message = OutgoingMessage::create("Breed: <b>" . ucwords($randomBreed) . "</b>\nSource: https://dog.ceo")->withAttachment($attachment);
                // Reply message object
               $this->say($message, ['parse_mode' => 'HTML']);
            }else {
                $this->say((new App\Services\DogService)->bySubBreed($answer[0], $answer[1]), ['parse_mode' => 'HTML']);
            }
        }, ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     *
     * @return void
     */
    public function run()
    {
        // This is the boot method, it's what will be excuted first.
        $this->defaultQuestion();
    }
}