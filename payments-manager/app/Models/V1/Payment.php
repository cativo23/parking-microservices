<?php

namespace App\Models\V1;

use App\Traits\HasUuid;
use Cknow\Money\Money;
use Database\Factories\V1\PaymentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\V1\Payment
 *
 * @property string $id
 * @property string $license_plate
 * @property Carbon|null $paid_at
 * @property int $total_in_cents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $type
 * @property-read bool $paid
 * @property-read Money $total_in_usd
 * @method static PaymentFactory factory(...$parameters)
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereLicensePlate($value)
 * @method static Builder|Payment wherePaidAt($value)
 * @method static Builder|Payment whereTotalInCents($value)
 * @method static Builder|Payment whereType($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Payment extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = ['id'];

    protected $dates = [
        'paid_at',
    ];

    protected $appends = [
        'total_in_usd',
        'paid'
    ];

    public function getTotalInUsdAttribute(): Money
    {
        return Money::USD($this->total_in_cents);
    }

    public function getPaidAttribute(): bool
    {
        return $this->paid_at !== null;
    }
}
