<?php

namespace App\APIs;

use App\Data\RegistrationDTO;
use App\Exceptions\APIs\RequestError;
use App\Exceptions\APIs\StatusNotExpected;

use Exception;

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
    public function getVehicleByLicencePlate(string $license_plate): RegistrationDTO|null
    {
        try {
            $response = $this->makeRequest("/api/v1/vehicles/$license_plate");
        } catch (Exception $exception) {
            throw new RequestError($exception->getMessage(), previous: $exception);
        }

        if ($response) {
            return new RegistrationDTO($response->json()['data']);
        }

        return null;
    }
}
