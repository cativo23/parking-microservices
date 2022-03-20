<?php

namespace App\Repositories\V1;

use App\Models\V1\Vehicle;
use Illuminate\Database\Eloquent\Model;

class VehicleRepository extends BaseRepository
{

    protected array $allowedFilters = [
        'license_plate',
    ];

    protected array $allowedFiltersExact = [
        'type'
    ];

    protected function model(): string
    {
        return Vehicle::class;
    }

    public function getByLicensePlate(string $id): ?Model
    {
        return $this->model::where('license_plate', $id)->first();
    }
}
