<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Support\Carbon;

/**
 * Class TripTicket
 *
 * @property int $id
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
}
