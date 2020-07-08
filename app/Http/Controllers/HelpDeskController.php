<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpDeskController extends Controller
{
    /**
     * Respond with a generic message.
     *
     * @param Botman $bot
     * @return void
     */
    public function index($bot)
    {
        $bot->reply('
            Commands Avaliable <br>
            /start - ▶ Start ,<br> 
            /random - 🎲 Random Dog Breed Image, <br>
            /b {breed} - 🖼 Get Breed Image , <br>
            /s {breed}:{subBreed} - 🖼 Get SubBreed Image , <br>
            /dev - 👨🏻‍💻 Developer , <br>
            /help - ❔ Help
        ', ['parse_mode' => 'HTML']);
    }
}
