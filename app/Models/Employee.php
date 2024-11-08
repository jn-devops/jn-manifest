<?php

namespace App\Models;

use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use libphonenumber\PhoneNumberFormat as libPhoneNumberFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use libphonenumber\PhoneNumberFormat;

/**
 * Class Employee
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property Company $company
 * @property Department $department
 * @property string $mobile_country
 *
 * @method int getKey()
 */
class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;
    use Notifiable;

    const PHONE_SEARCH_FORMAT = PhoneNumberFormat::E164;

    protected $fillable = [
        'name',
        'email',
        'mobile'
    ];

    public static function fromMobile(string $value): ?static
    {
        $employee = null;
        try {
            $mobile = phone($value, 'PH', self::PHONE_SEARCH_FORMAT);
            $employee = static::where('mobile', $mobile)->first();
        }
        catch (NumberParseException $exception) {

        }

        return $employee;
    }

    public function routeNotificationForEngageSpark(): string
    {
        return $this->mobile;
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    protected function mobile(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value, $attributes) => $value
                ? phone($value, $this->mobile_country, PhoneNumberFormat::NATIONAL)
                : null,
            set: fn ($value) => [
                'mobile' => $value ? phone($value, $this->mobile_country, libPhoneNumberFormat::E164): null
            ]
        );
    }

    public function getMobileCountryAttribute(): string
    {
        return 'PH';
    }
}
