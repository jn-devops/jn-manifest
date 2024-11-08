<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Support\Carbon;

/**
 * Class TripTicket
 *
 * @property int $id
 * @property string $code
 * @property User $user
 * @property Employee $employee
 * @property CarType $carType
 * @property Project $project
 * @property Account $account
 * @property Carbon $fromDateTime
 * @property Carbon $toDateTime
 * @property string $status
 * @property string $remarks
 *
 * @method int getKey()
 * @method void setStatus(string $name, string $reason)
 */
class TripTicket extends Model
{
    /** @use HasFactory<\Database\Factories\TripTicketFactory> */
    use HasStatuses;
    use HasFactory;

    protected $fillable = [
        'remarks'
    ];

    protected $casts = [
        'fromDateTime' => 'datetime',
        'toDateTime' => 'datetime',
    ];

    public static function booted(): void
    {
        static::creating(function (TripTicket $tripTicket) {
            $tripTicket->code = substr(Str::uuid()->toString(), -8);
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function carType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function manifests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Manifest::class);
    }
}
