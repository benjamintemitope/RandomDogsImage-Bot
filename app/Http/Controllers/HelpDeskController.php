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
            /start - Start,
            /random - Random Dog Breed Image,
            /dev - The Developer,
        ');
    }
}
