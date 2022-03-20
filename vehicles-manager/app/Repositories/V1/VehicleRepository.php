<?php

namespace App\Repositories\V1;

use App\Models\V1\Vehicle;

class VehicleRepository extends BaseRepository
{

    protected function model(): string
    {
        return Vehicle::class;
    }
}
