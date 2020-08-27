<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\BotManController;
use BotMan\Drivers\Telegram\TelegramDriver;

class SubscriberController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Subscriber::where('chat_type', 'private')->get();
        $subscriberGroups = Subscriber::where('chat_type', 'private')->get();
        return view('dashboard', compact('subscribers', 'subscriberGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $data
     * @return void
     */
    public static function store($data)
    {
        $subscriber = new Subscriber();
        $subscriber->id = $data['id'];

        if (array_key_exists('first_name', $data)) {
            $subscriber->name = $data['first_name'];
        }

        if (array_key_exists('last_name', $data)) {
            $subscriber->name .= ' ' . $data['last_name'];
        }

        if (array_key_exists('username', $data)) {
            $subscriber->username = $data['username'];    
        }

        if (array_key_exists('title', $data)) {
            $subscriber->name = $data['title'];
        }

        if (array_key_exists('type', $data)) {
            $subscriber->chat_type = $data['type'];
        }

        

        $subscriber->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $subscriber
     * @return void
     */
    public function update($data)
    {
        $subscriber =  Subscriber::where('id', '=', $data['id'])->firstOrFail();

        $subscriber->id = $data['id'];

        if (array_key_exists('first_name', $data)) {
            $subscriber->name = $data['first_name'];
        }

        if (array_key_exists('last_name', $data)) {
            $subscriber->name .= ' ' . $data['last_name'];
        }

        if (array_key_exists('username', $data)) {
            $subscriber->username = $data['username'];    
        }

        if (array_key_exists('title', $data)) {
            $subscriber->name = $data['title'];
        }

        if (array_key_exists('type', $data)) {
            $subscriber->chat_type = $data['type'];
        }

        $subscriber->updated_at = NOW();
        $subscriber->update();
    }

    /**
     * Check if Subscriber record exist in database
     * Update records if exist
     * Create records if new
     * 
     * @param $chat
     * @return void
     */
    public function storeOrUpdate($messagePayload)
    {
        //Convert Protected Object to Array
        $messagePayload = (array)$messagePayload;
        $prefix = chr(0).'*'.chr(0);

        $userInfo = $messagePayload[$prefix.'items']['from'];
        //To distinguish subscriber
        //user type is set to private
        $userInfo['type'] = 'private';
        $chatInfo = $messagePayload[$prefix.'items']['chat'];

        //Check if record exists in database
        //if true, update the record
        //else, create a record
        if ($chatInfo === 'private') {
            $check_chat = Subscriber::where('id', '=', $chatInfo['id'])->exists();
            ($check_chat) ? $this->update($chatInfo) : $this->store($chatInfo);
        }else {
            $check_user = Subscriber::where('id', '=', $userInfo['id'])->exists();
            ($check_user) ? $this->update($userInfo) : $this->store($userInfo);

            $check_group = Subscriber::where('id', '=', $chatInfo['id'])->exists();
            ($check_group) ? $this->update($chatInfo) : $this->store($chatInfo);
        }
    }
}
