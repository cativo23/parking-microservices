<?php

namespace App\Data;

use App\Data\Casters\CarbonImmutableCaster;
use Carbon\CarbonImmutable;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class RegistrationDTO extends DataTransferObject
{
    public int $id;
    public string $license_plate;
    #[CastWith(CarbonImmutableCaster::class)]
    public CarbonImmutable|null $exit_date;
    #[CastWith(CarbonImmutableCaster::class)]
    public CarbonImmutable $enter_date;
    public float $total_time;
}
