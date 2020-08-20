<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
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
        // We ask our user the question.
        $name = $this->bot->getUser()
                ->getInfo()['user']['first_name'];
        return $this->ask('Hey! ' . $name .', What do you need?', function (Answer $answer) {
        }, $this->keyboard());
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

    /**
     * Inline Keyboard
     * 
     * @return void
     */
    public function keyboard()
    {
            return Keyboard::create()
                ->type(Keyboard::TYPE_KEYBOARD)
                ->resizeKeyboard()
                ->addRow(KeyboardButton::create('🎲 Random Dog Image')->callbackData('random'))
                ->addRow(
                    KeyboardButton::create('🖼 A Image by Breed')->callbackData('breed'),
                    KeyboardButton::create('🖼 A Image by Sub-Breed')->callbackData('sub-breed'))
                ->addRow(
                    KeyboardButton::create('❓ Help Center')->callbackData('help'))
                ->toArray();
    }
}