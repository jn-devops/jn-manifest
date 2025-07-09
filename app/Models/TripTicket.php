<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bavix\Wallet\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Model;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\Customer;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
 * @property string $location
 * @property float $amount
 *
 * @method int getKey()
 * @method void setStatus(string $name, string $reason)
 */
class TripTicket extends Model implements ProductInterface
{
    /** @use HasFactory<\Database\Factories\TripTicketFactory> */
    use HasWalletFloat;
    use HasStatuses;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'group_code',
        'fromDateTime',
        'toDateTime',
        'status',
        'location',
        'ticket_number',
        'attachments'
    ];

    protected $casts = [
        'fromDateTime' => 'datetime',
        'toDateTime' => 'datetime',
        'attachments' => 'array',
    ];

    public static function booted(): void
    {
        static::creating(function (TripTicket $tripTicket) {
//            $tripTicket->code = substr(Str::uuid()->toString(), -8);
            $tripTicket->user_id = auth()->id();
            $yearMonth = now()->format('ym'); // YYMM format
            $lastTicket = static::where('ticket_number', 'like', "$yearMonth-%")
                ->orderBy('ticket_number', 'desc')
                ->first();

            // Extract the last sequence and increment it
            $lastSequence = $lastTicket
                ? (int) substr($lastTicket->ticket_number, -4)
                : 0;

            $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
            $tripTicket->ticket_number = "{$yearMonth}-{$newSequence}";
        });
        static::updating(function ($data) {
            foreach (array_keys($data->getAttributes()) as $attr) {
                if ($data->isDirty($attr)) {
                    $from = $data->getOriginal($attr);
                    $to = $data->getAttribute($attr);

                    if (Str::endsWith($attr, '_id') && method_exists($data, Str::camel(str_replace('_id', '', $attr)))) {
                        $relationshipName = Str::camel(str_replace('_id', '', $attr));
                        $relatedModel = $data->$relationshipName()->getRelated();

                        // Retrieve the name or another identifier instead of the ID
                        $from = $data->getOriginal($attr) ? optional($relatedModel->find($data->getOriginal($attr)))->name : null;
                        $to = $data->getAttribute($attr) ? optional($relatedModel->find($data->getAttribute($attr)))->name : null;
                    }

//                    $data->updateLog()->create([
//                        'field' => Str::endsWith($attr, '_id') ? str_replace('_id', '', $attr) : $attr,
//                        'from' => $from??'',
//                        'to' => $to??'',
//                        'user_id'=> \auth()->user()->id
//                    ]);
                    $data->updateLog()->create([
                        'field' => Str::endsWith($attr, '_id') ? str_replace('_id', '', $attr) : $attr,
                        'from' => is_array($from) ? json_encode($from) : ($from ?? ''),
                        'to' => is_array($to) ? json_encode($to) : ($to ?? ''),
                        'user_id' => auth()->id()
                    ]);
                }
            }
        });
    }

    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            'trip_ticket_projects',
            'trip_ticket_number', // foreign key on the pivot table for TripTicket
            'project_id',        // foreign key on the pivot table for Project
            'ticket_number',       // local key on TripTicket model
            'id'                 // local key on Project model
        );
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EmployeeGroup::class, 'group_code');
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function manifests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Manifest::class);
    }

    public function locations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TripTicketLocations::class, 'trip_ticket_number', 'ticket_number');
    }

    public function updateLog()
    {
        return $this->morphMany(UpdateLog::class, 'loggable');
    }

    public function canBuy(Customer $customer, int $quantity = 1, bool $force = false): bool
    {
        /**
         * This is where you implement the constraint logic.
         *
         * If the service can be purchased once, then
         *  return !$customer->paid($this);
         */
        return true;
    }

    public function getAmountProduct(Customer $customer): int|string
    {
        return 100;
    }

    public function getMetaProduct(): ?array
    {
        return [
            'title' => 'Title',
            'description' => 'Purchase of Product #' . $this->id,
        ];
    }
}
