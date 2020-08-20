<?php

namespace App\Http\Controllers;

use App\SubscriberGroup;
use Illuminate\Http\Request;

class SubscriberGroupController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriberGroups = SubscriberGroup::all();
        return $subscriberGroups;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $info
     * @return void
     */
    public function store($info)
    {
        $subscriberGroup = new SubscriberGroup();
        $subscriberGroup->group_id = $info['id'];
        $subscriberGroup->title = $info['title'];
        $subscriberGroup->type = $info['type'];
        $subscriberGroup->last_active = NOW();

        $subscriberGroup->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $info
     * @return void
     */
    public function update($info)
    {
        $subscriberGroup = SubscriberGroup::where('group_id', '=', $info['id'])->firstOrFail();
        $subscriberGroup->group_id = $info['id'];
        $subscriberGroup->title = $info['title'];
        $subscriberGroup->type = $info['type'];
        $subscriberGroup->last_active = NOW();

        $subscriberGroup->update();
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
        $check = SubscriberGroup::where('group_id', '=', $info['id'])->exists();
        if ($check === true) {
            $this->update($info);
        }else {
            $this->store($info);
        }
    }
}
