<?php

namespace App\Models\V1;

use App\Enums\VehicleTypeEnum;
use Database\Factories\V1\VehicleFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\V1\Vehicle
 *
 * @property int $id
 * @property string $license_plate
 * @property VehicleTypeEnum|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static VehicleFactory factory(...$parameters)
 * @method static Builder|Vehicle newModelQuery()
 * @method static Builder|Vehicle newQuery()
 * @method static Builder|Vehicle query()
 * @method static Builder|Vehicle whereCreatedAt($value)
 * @method static Builder|Vehicle whereId($value)
 * @method static Builder|Vehicle whereLicensePlate($value)
 * @method static Builder|Vehicle whereType($value)
 * @method static Builder|Vehicle whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => VehicleTypeEnum::class
    ];
}
