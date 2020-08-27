<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SubscriberController;
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
        //Get Chat Information
        $messagePayload = $bot->getMessage()->getPayload();
        (new SubscriberController)->storeOrUpdate($messagePayload);
        
        $bot->reply("
            <b>❓ Help Desk</b> \n <i>Commands Available </i>
\n/start - ▶ Start ,
\n/random - 🎲 Random Dog Breed Image, 
\n/b {breed} - 🖼 Get Breed Image , 
\n/bs {breed} - 🔎 Search Breed,  
\n/s {breed}:{subBreed} - 🖼 Get SubBreed Image , 
\n/ss {subBreed} - 🔎 Search SubBreed, 
\n/dev - 👨🏻‍💻 Developer , 
\n/feedback - 📄 Feedback,
\n/help - ❓ Help
        ", ['parse_mode' => 'HTML']);
    }
}
