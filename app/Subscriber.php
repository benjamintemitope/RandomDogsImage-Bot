<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $dates = [
        'last_active',
        'created_at',
        'updated_at',
    ];
}
