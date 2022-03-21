<?php

namespace App\Data;

use App\Data\Casters\CarbonImmutableCaster;
use Carbon\CarbonImmutable;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class PaymentDTO extends DataTransferObject
{
    public string $id;
    public string $license_plate;
    #[CastWith(CarbonImmutableCaster::class)]
    public ?CarbonImmutable $paid_at;
    public bool $paid;
    public int $total_in_cents;
    public float $total_in_usd;
}
