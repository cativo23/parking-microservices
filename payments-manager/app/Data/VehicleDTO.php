<?php

namespace App\Data;

use Spatie\DataTransferObject\DataTransferObject;

class VehicleDTO extends DataTransferObject
{
    public int $id;
    public string $license_plate;
    public string $type;
}
