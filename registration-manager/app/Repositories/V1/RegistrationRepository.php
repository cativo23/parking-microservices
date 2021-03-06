<?php

namespace App\Repositories\V1;

use App\Models\V1\Registration;
use Illuminate\Database\Eloquent\Collection;
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

    public function getByLicensePlates(array $ids): Collection
    {
        return $this->model::whereIn('license_plate', $ids)->get();
    }

    public function getByIdTrashed(int $id): ?Model
    {
        return  $this->model::withTrashed()->find($id);
    }

    public function restore(Registration $registration): ?bool
    {
        return $registration->restore();
    }

    public function deleteAll(array $licensePlates): bool|int|null
    {
        return $this->model::whereIn('license_plate', $licensePlates)->delete();
    }

    public function forceDeleteAll(array $licensePlates): bool|int|null
    {
        return $this->model::whereIn('license_plate', $licensePlates)->forceDelete();
    }
}
