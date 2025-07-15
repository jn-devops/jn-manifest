<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'mobile',
    ];
}
