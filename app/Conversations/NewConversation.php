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


class NewConversation extends Conversation
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
        return $this->ask('Huh - What do you need?', function (Answer $answer) {
            \Log::info(print_r($answer->getMessage()->getPayload()['chat']['id'],true));
            /*$this->say($answer->getValue());*/
            // Did the user click on an option or entered a text?
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

    public function keyboard()
    {
            return Keyboard::create()
                ->type(Keyboard::TYPE_KEYBOARD)
                ->resizeKeyboard()
                ->addRow(KeyboardButton::create('🎲 Random Dog Image')->callbackData('random'))
                ->addRow(
                    KeyboardButton::create('🖼 A Image by breed')->callbackData('breed'),
                    KeyboardButton::create('🖼 A Image by Sub-Breed')->callbackData('sub-breed'))
                ->addRow(
                    KeyboardButton::create('❓ Help Center')->callbackData('help'))
                ->toArray();
    }
}