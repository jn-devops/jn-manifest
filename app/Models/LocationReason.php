<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationReason extends Model
{
    protected $fillable=[
        'code',
        'description',
    ];
}
