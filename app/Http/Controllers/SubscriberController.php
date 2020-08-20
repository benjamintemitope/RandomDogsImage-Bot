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
        $subscribers = Subscriber::all();
        return $subscribers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $info
     * @return void
     */
    public static function store($info)
    {
        $subscriber = new Subscriber();
        $subscriber->subscriber_id = $info['id'];

        if (array_key_exists('first_name', $info)) {
            $subscriber->name = $info['first_name'];
        }

        if (array_key_exists('last_name', $info)) {
            $subscriber->name .= ' ' . $info['last_name'];
        }

        if (array_key_exists('username', $info)) {
            $subscriber->username = $info['username'];    
        }
        
        $subscriber->last_active = NOW();

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
     * @param  $info
     * @return void
     */
    public function update($info)
    {
        $subscriber =  Subscriber::where('subscriber_id', '=', $info['id'])->firstOrFail();

        $subscriber->subscriber_id = $info['id'];

        if (array_key_exists('first_name', $info)) {
            $subscriber->name = $info['first_name'];
        }

        if (array_key_exists('last_name', $info)) {
            $subscriber->name .= ' ' . $info['last_name'];
        }

        if (array_key_exists('username', $info)) {
            $subscriber->username = $info['username'];    
        }
        
        $subscriber->last_active = NOW();

        $subscriber->update();
    }

    /**
     * Check if Subscriber record exist in database
     * Update records if exist
     * Create records if new
     * 
     * @param $info
     * @return void
     */
    public function storeOrUpdate($info)
    {
        $check = Subscriber::where('subscriber_id', '=', $info['id'])->exists();
        if ($check === true) {
            $this->update($info);
        }else {
            $this->store($info);
        }
    }
}
