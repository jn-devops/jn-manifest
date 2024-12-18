<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;

class User extends Authenticatable implements FilamentUser, Wallet
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasPanelShield;
    use HasWallet;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function booted(): void
    {
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

                    $data->updateLog()->create([
                        'field' => Str::endsWith($attr, '_id') ? str_replace('_id', '', $attr) : $attr,
                        'from' => $from??'',
                        'to' => $to??'',
                        'user_id'=> \auth()->user()->id??0
                    ]);
                }
            }
        });
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function updateLog()
    {
        return $this->morphMany(UpdateLog::class, 'loggable');
    }

    public function userUpdates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UpdateLog::class, 'user_id');
    }
}
