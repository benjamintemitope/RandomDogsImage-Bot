<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberGroupController;
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
         // We create or update record about the subscribers
        $this->storeOrUpdate($bot);
        
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

    /**
     * Create or Update record about the subscribers
     * 
     * @return void
     */
    public function storeOrUpdate($bot)
    {
        //Get Chat Information
        $chat_type = $bot->getMessage()
                     ->getPayload()['chat']['type'];

        //If the command is sent privately
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
