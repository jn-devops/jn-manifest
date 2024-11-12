<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;

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
class Project extends Model implements Wallet
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    use HasWallet;

    protected $fillable = [
        'code',
        'name',
        'description'
    ];
}
