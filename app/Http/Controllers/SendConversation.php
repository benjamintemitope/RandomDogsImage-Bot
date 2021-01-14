<?php

namespace App\Http\Controllers;

use App\Conversations\BreedConversation;
use App\Conversations\ReviewConversation;
use App\Conversations\SubBreedConversation;
use App\Services\DogService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Http\Request;

class SendConversation extends Controller
{
    public function sendConversation(Request $request)
    {
        $id = $request->id;
        $conversation = $request->conversation;
        $message = $request->message;

        $botman = app('botman');

        switch ($conversation) {
             case 'random':
                $botman->say($this->random(), $id, TelegramDriver::class, ['parse_mode' => 'HTML']);
            break;

            case 'breed':
                $botman->startConversation(new BreedConversation(), $id, TelegramDriver::class, ['parse_mode' => 'HTML']);
            break;

            case 'sub-breed':
                $botman->startConversation(new SubBreedConversation(), $id, TelegramDriver::class, ['parse_mode' => 'HTML']);
            break;

            case 'review':
                $botman->startConversation(new ReviewConversation(), $id, TelegramDriver::class, ['parse_mode' => 'HTML']);
                break;
        }

        if ($request->imageURL) {
            // Create attachment
            $attachment = new Image($request->imageURL, [
                'custom_payload' => true,
            ]);

            // Build message object
            $message = OutgoingMessage::create($request->message)
                        ->withAttachment($attachment);

            // Reply message object
            $botman->say($message, $id, TelegramDriver::class, ['parse_mode' => 'HTML']);
        }elseif (!empty($request->message)) {
            $botman->say($request->message, $id, TelegramDriver::class, ['parse_mode' => 'HTML']);
        }

        


        return redirect()->route('dashboard')->with('status', 'Message sent successfully.');
        
    }

    public function customSend()
    {
        return view('custom-send');
    }

    public function send(Request $request)
    {
        $botman = app('botman');
        if ($request->imageURL) {
            // Create attachment
            $attachment = new Image($request->imageURL, [
                'custom_payload' => true,
            ]);

            // Build message object
            $message = OutgoingMessage::create($request->message)
                    ->withAttachment($attachment);

            // Reply message object
            $botman->say($message, (int) $request->userId, TelegramDriver::class, ['parse_mode' => 'HTML']);
        }elseif (!empty($message)) {
            $botman->say($message, (int) $request->userId, TelegramDriver::class, ['parse_mode' => 'HTML']);
        }

        return redirect()->route('dashboard')->with('status', 'Message sent successfully.');
    }

    public function random()
    {
        $breedURL = (new DogService)->random();
        if (preg_match('/https:\/\//', $breedURL)) {
            $attachment = new Image($breedURL, [
                'custom_payload' => true,
            ]);
            $breedName = explode('/', $breedURL)[4];
            $breedName = str_replace('-', ' ', $breedName);
            $message = OutgoingMessage::create("Breed: <b>" . ucwords($breedName) . "</b>\n\nSource: https://dog.ceo")->withAttachment($attachment);
            return $message;
        }else {
            return (new DogService)->random();
        }
    }
}
