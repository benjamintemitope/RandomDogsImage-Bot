<?php

namespace App\Http\Controllers;

use App\Services\DogService;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SearchBreedsController extends Controller
{
    public $searchEntry = [];

    public function searchBreed($bot, $text)
    {
        //Make Search Entries from all Breeds Available
        $allBreeds = (new \App\Services\DogService)->allBreeds();
        foreach ($allBreeds as $breed => $subBreed) {
            if (preg_match("/{$text}/i", $breed)) {
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

                    $selectedValue = $answer->getValue();

                    $breedURL = (new \App\Services\DogService)->byBreed($selectedValue);

                    if (preg_match('/https:\/\//', $breedURL)) {

                        $attachment = new Image($breedURL, ['custom_payload' => true,]);

                        $nameBreed = explode('/', $breedURL)[4];
                        $nameBreed = str_replace('-', ' ', $nameBreed);

                        $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);

                        $this->say($message, ['parse_mode' => 'HTML']);
                    }
                }
            });
        }else {
            $bot->say("No result found for <b>" . ucwords($text) . "</b> Breed", ['parse_mode' => 'HTML']);
        }
    }

    public function searchSubBreed($bot, $text)
    {
        //Make Search Entries from all Breeds Available
        $allBreeds = (new \App\Services\DogService)->allBreeds();
        foreach ($allBreeds as $breed => $subBreed) {
            if (preg_grep("/{$text}/i", $subBreed)) {
                $this->searchEntry[$breed] = preg_grep("/{$text}/i", $subBreed);   
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

                    $selectedValue = explode(':', $answer->getValue());
                    $breedURL = (new \App\Services\DogService)->bySubBreed($selectedValue[0], $selectedValue[1]);

                    if (preg_match('/https:\/\//', $breedURL)) {

                        $attachment = new Image(
                            $breedURL, [
                                'custom_payload' => true,
                            ]
                        );

                        $nameBreed = explode('/', $breedURL)[4];
                        $nameBreed = str_replace('-', ' ', $nameBreed);

                        $message = OutgoingMessage::create("Breed: <b>" . ucwords($nameBreed) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);

                        $this->say($message, ['parse_mode' => 'HTML']);
                    }
                }
            });
        }else {
            $bot->say('No result found for <b>' . ucwords($text) . '</b> SubBreed', ['parse_mode' => 'HTML']);
        }
    }

    public function searchBreedFallback($bot)
    {
        $bot->reply("Invalid Respond! \n\n<b>Usage</b>: /bs {breed} \n\ne.g <code>/bs whippet</code>",
        [
            'parse_mode' => 'HTML'
        ]);
    }

    public function searchSubBreedFallback($bot)
    {
        $bot->reply("Invalid Respond! \n\n<b>Usage</b>: /ss {subBreed} \n\ne.g <code>/ss staffordshire</code>",
        [
            'parse_mode' => 'HTML'
        ]);
    }
}
