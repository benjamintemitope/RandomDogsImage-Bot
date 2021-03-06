<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\SubscriberGroup;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $subscribers = Subscriber::where('chat_type', 'private')->get();
        $subscriberGroups = Subscriber::get()->whereNotIn('chat_type', 'private');
        return view('dashboard', compact('subscribers', 'subscriberGroups'));
    }
}
