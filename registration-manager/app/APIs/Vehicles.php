<?php

namespace App\APIs;

use App\Data\VehicleDTO;
use App\Exceptions\APIs\RequestError;
use App\Exceptions\APIs\StatusNotExpected;

use Exception;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

use function config;

class Vehicles extends BaseAPI
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setConfigs(): void
    {
        $this->baseUrl = config('services.vehicle_manager.url');
        $this->token = config('services.vehicle_manager.token');
    }

    /**
     * @throws RequestError
     * @throws UnknownProperties
     */
    public function getVehicleByLicencePlate(string $license_plate): VehicleDTO|null
    {
        try {
            $response = $this->makeRequest("/api/v1/vehicles/$license_plate");
        } catch (Exception $exception) {
            throw new RequestError($exception->getMessage(), previous: $exception);
        }

        if ($response) {
            return new VehicleDTO($response->json()['data']);
        }

        return null;
    }
}
