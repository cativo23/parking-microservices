<?php

namespace App\APIs;

use App\Data\PaymentDTO;
use App\Data\VehicleDTO;
use App\Exceptions\APIs\RequestError;
use App\Exceptions\APIs\StatusNotExpected;

use Exception;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

use function config;

class Vehicles extends BaseAPI
{
    public function setConfigs(): void
    {
        $this->baseUrl = config('services.vehicle_manager.url');
        $this->token = config('services.vehicle_manager.token');
    }

    /**
     * @throws RequestError
     * @throws UnknownProperties
     */
    public function getVehicleByLicencePlate(string $license_plate): VehicleDto|null
    {
        try {
            $response = $this->makeRequest("/api/v1/vehicles/$license_plate");
        } catch (Exception $exception) {
            throw new RequestError($exception->getMessage(), previous: $exception);
        }

        if ($response) {
            return new VehicleDto($response->json()['data']);
        }

        return null;
    }

    /**
     * @throws RequestError
     */
    public function getVehicleByType(string $type): Collection|null
    {
        try {
            $response = $this->makeRequest("api/v1/vehicles/all", [
                'filter[type]' => $type
            ]);
        } catch (Exception $exception) {
            throw new RequestError($exception->getMessage(), previous: $exception);
        }

        if ($response) {
            return collect($response->json()['data'])->map(function (array $item) {
                return new VehicleDTO($item);
            });
        }

        return null;
    }
}
