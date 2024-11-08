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
 * @property TripTicket $tripTicket
 * @method int getKey()
 */
class Manifest extends Model
{
    /** @use HasFactory<\Database\Factories\ManifestFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'passenger_type',
    ];

    public function tripTicket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TripTicket::class);
    }
}
