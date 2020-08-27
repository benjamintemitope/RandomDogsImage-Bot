<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
