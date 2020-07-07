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
            Commands Avaliable %0A
            \'/start\' - Start %0A,
            \'/random\' - Random Dog Breed Image %0A,
            \'/dev\' - The Developer %0A,
        ');
    }
}
