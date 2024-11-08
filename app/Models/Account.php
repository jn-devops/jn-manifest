<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $description
 *
 * @method int getKey()
 */
class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description'
    ];
}
