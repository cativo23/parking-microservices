<?php

namespace App\Data\Casters;

use Carbon\CarbonImmutable;
use Spatie\DataTransferObject\Caster;

class CarbonImmutableCaster implements Caster
{

    public function cast(mixed $value): CarbonImmutable|bool
    {
        return CarbonImmutable::createFromFormat('Y-m-d H:i:s', $value);
    }
}
