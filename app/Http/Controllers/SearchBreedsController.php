<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;
use App\Services\DogService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Http\Request;

class SearchBreedsController extends Controller
{
    public $searchEntry = [];

    public function byBreed($bot, $text)
    {
        $text = strval($text);

        //Make Search Entries from all Breeds Available
        $allBreeds = (new \App\Services\DogService)->allBreeds();
        foreach ($allBreeds as $breed => $subBreed) {
            if (preg_match("#{$text}#i", $breed)) {
                $this->searchEntry[] .= $breed;   
            }   
        }

        //Search Results
        if (!empty($this->searchEntry)) {
            $question = Question::create('Search Results for ' . ucwords($text));
            foreach ($this->searchEntry as $entry) {
                $question->addButtons([
                    Button::create(ucwords($entry))->value($entry)
                ]);
            }

            //Returning Search Results
            return $bot->ask($question,function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $selectedBreed = $answer->getValue();
                    $breedURL = (new \App\Services\DogService)->byBreed($selectedBreed);
                    if (preg_match('/https:\/\//', $breedURL)) {
                        $attachment = new Image($breedURL, ['custom_payload' => true,]);
                        $breedName = explode('/', $breedURL)[4];
                        $breedName = str_replace('-', ' ', $breedName);
                        $message = OutgoingMessage::create("Breed: <b>" . ucwords($breedName) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);

                        $this->say($message, ['parse_mode' => 'HTML']);
                    }
                }
            });

            // We create or update record about the subscribers
            $this->storeOrUpdate($bot);
        }else {
            $bot->say("No result found for <b>" . ucwords($text) . "</b> Breed", ['parse_mode' => 'HTML']);
        }

    }

    public function bySubBreed($bot, $text)
    {
        // We create or update record about the subscribers
        //$this->storeOrUpdate($bot);
        
        $text = strval($text);
        //Make Search Entries from all Breeds Available
        $allBreeds = (new \App\Services\DogService)->allBreeds();
        foreach ($allBreeds as $breed => $subBreed) {
            if (preg_grep("#{$text}#i", $subBreed)) {
                $this->searchEntry[$breed] = preg_grep("#{$text}#i", $subBreed);   
            }   
        }
        //Search Results
        if (!empty($this->searchEntry)) {
            $question = Question::create('Search Results for ' . ucwords($text));
            foreach ($this->searchEntry as $entry => $entrySub) {
                $entrySub = implode("|",$entrySub);
                $question->addButtons([
                    Button::create(ucfirst($entry) . " " . ucfirst($entrySub))->value("$entry:$entrySub")
                ]);
            }

             //Returning Search Results
            return $bot->ask($question,function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $selectedBreed = explode(':', $answer->getValue());
                    $breedURL = (new \App\Services\DogService)->bySubBreed($selectedBreed[0], $selectedBreed[1]);
                    if (preg_match('/https:\/\//', $breedURL)) {
                        $attachment = new Image(
                            $breedURL, [
                                'custom_payload' => true,
                            ]
                        );
                        $breedName = explode('/', $breedURL)[4];
                        $breedName = str_replace('-', ' ', $breedName);
                        $message = OutgoingMessage::create("Breed: <b>" . ucwords($breedName) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);
                        $this->say($message, ['parse_mode' => 'HTML']);
                    }
                }
            });

            // We create or update record about the subscribers
            //BUG: If instead in the else statement
            $this->storeOrUpdate($bot);
        }else {
            $bot->say('No result found for <b>' . ucwords($text) . '</b> SubBreed', ['parse_mode' => 'HTML']);
        }

    }

    /**
     * Create or Update record about the subscribers
     * 
     * @return void
     */
    public function storeOrUpdate($bot)
    {
        if (is_callable($bot->getMessage())) {
            $chat_type = $bot->getMessage()
                         ->getPayload()['chat']['type'];

            //check if message was sent privately
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
}
