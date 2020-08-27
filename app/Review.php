<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function subscriber()
    {
        return $this->belongsTo('App\Subscriber');
    }
}
