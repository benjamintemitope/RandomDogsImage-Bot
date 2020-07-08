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
            Commands Avaliable 
            /start - Start <br>, 
            /random - Random Dog Breed Image <br>, 
            /b {breed} - Get Breed Image <br>, 
            /s {breed}:{subBreed} - Get SubBreed Image <br>,
            /dev - Developer
        ', ['parse_mode' => 'HTML']);
    }
}
