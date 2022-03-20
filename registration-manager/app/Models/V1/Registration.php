<?php

namespace App\Models\V1;

use Database\Factories\V1\RegistrationFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\V1\Registration
 *
 * @property int $id
 * @property string $license_plate
 * @property Carbon $enter_date
 * @property Carbon|null $exit_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read float $total_time
 * @method static RegistrationFactory factory(...$parameters)
 * @method static Builder|Registration newModelQuery()
 * @method static Builder|Registration newQuery()
 * @method static Builder|Registration query()
 * @method static Builder|Registration whereCreatedAt($value)
 * @method static Builder|Registration whereEnterDate($value)
 * @method static Builder|Registration whereExitDate($value)
 * @method static Builder|Registration whereId($value)
 * @method static Builder|Registration whereLicensePlate($value)
 * @method static Builder|Registration whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Registration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'enter_date',
        'exit_date'
    ];

    protected $appends = [
        'total_time'
    ];

    /**
     * Get the total parking time.
     */
    public function getTotalTimeAttribute(): float
    {
        return $this->exit_date ? $this->exit_date->diffInMinutes($this->enter_date) : 0;
    }
}
