<?php

namespace App\Repositories\V1;

use App\Models\V1\Registration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class RegistrationRepository extends BaseRepository
{

    protected array $allowedFilters = [
        'license_plate',
    ];

    protected array $allowedFiltersExact = [
    ];

    protected function model(): string
    {
        return Registration::class;
    }

    public function getByLicensePlate(string $id): ?Model
    {
        return $this->model::where('license_plate', $id)->first();
    }

    public function getLastByLicensePlate(string $id): ?Model
    {
        return $this->model::where('license_plate', $id)->latest()->first();
    }
}
