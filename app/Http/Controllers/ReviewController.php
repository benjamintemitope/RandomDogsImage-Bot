<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data)
    {
        //Convert Protected Object to Array
        $data = (array)$data;
        $prefix = chr(0).'*'.chr(0);

        $subscriber = $data[$prefix.'items']['from'];

        $review = new Review();
        $review->subscriber_id = $subscriber['id'];

        if (array_key_exists('text', $data[$prefix.'items'])) {
            $review->body = $data[$prefix.'items']['text'];
            $review->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReviewController  $ReviewController
     * @return \Illuminate\Http\Response
     */
    public function show(ReviewController $ReviewController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReviewController  $ReviewController
     * @return \Illuminate\Http\Response
     */
    public function edit(ReviewController $ReviewController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReviewController  $ReviewController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReviewController $ReviewController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReviewController  $ReviewController
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReviewController $ReviewController)
    {
        //
    }
}
