<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bavix\Wallet\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Model;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\Customer;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
 * @property string $location
 * @property float $amount //TODO: create this attribute
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
        'code',
        'user_id',
        'employee_id',
        'car_type_id',
        'car_type_id',
        'project_id',
        'account_id',
        'fromDateTime',
        'toDateTime',
        'status',
        'location',
        'ticket_number',
        'request_for_payment_number',
        'invoice_number',
        'drop_off_point',
        'pick_up_point',
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
            $tripTicket->code = substr(Str::uuid()->toString(), -8);
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

    public function updateLog()
    {
        return $this->morphMany(UpdateLog::class, 'loggable');
    }

    public function charging(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Approver::class,'charge_to','budget_line_charging_2');
    }

    public function provider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Provider::class,'provider_code','code');
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
