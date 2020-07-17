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
        $bot->reply("
            <b>❓ Help Desk</b> \n <i>Commands Available </i>
\n/start - ▶ Start ,
\n/random - 🎲 Random Dog Breed Image, 
\n/b {breed} - 🖼 Get Breed Image , 
\n/bs {breed} - 🔎 Search Breed,  
\n/s {breed}:{subBreed} - 🖼 Get SubBreed Image , 
\n/ss {subBreed} - 🔎 Search SubBreed, 
\n/dev - 👨🏻‍💻 Developer , 
\n/help - ❓ Help
        ", ['parse_mode' => 'HTML']);
    }
}
