<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 *
 * @method int getKey()
 */
class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description'
    ];
}
