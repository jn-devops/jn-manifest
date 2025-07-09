<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripTicketLocations extends Model
{
    protected $fillable=[
        'trip_ticket_number',
        'location',
        'reason_code',
    ];
}
