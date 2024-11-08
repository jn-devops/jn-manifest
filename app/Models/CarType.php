<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $capacity
 *
 * @method int getKey()
 */
class CarType extends Model
{
    /** @use HasFactory<\Database\Factories\CarTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity'
    ];
}
