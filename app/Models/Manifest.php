<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Manifest
 *
 * @property int $id
 * @property string $name
 * @property string $passenger_type
 * @property string $email
 * @property boolean $attended
 * @property boolean $confirmed
 * @property TripTicket $trip_ticket
 * @method int getKey()
 */
class Manifest extends Model
{
    /** @use HasFactory<\Database\Factories\ManifestFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'passenger_type',
        'mobile',
        'email',
        'attended',
        'confirmed',
    ];

    public function trip_ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TripTicket::class);
    }
}
