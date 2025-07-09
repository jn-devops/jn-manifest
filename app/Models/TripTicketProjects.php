<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripTicketProjects extends Model
{
    protected $fillable=[
      'trip_ticket_number',
      'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class,  'project_id');
    }

}
