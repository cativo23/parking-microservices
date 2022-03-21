<?php

namespace App\APIs;

use App\Data\RegistrationDTO;
use App\Exceptions\APIs\RequestError;
use App\Exceptions\APIs\StatusNotExpected;

use Exception;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

use function config;

class Registrations extends BaseAPI
{
    public function setConfigs(): void
    {
        $this->baseUrl = config('services.registrations_manager.url');
        $this->token = config('services.registrations_manager.token');
    }

    /**
     * @throws RequestError
     */
    public function getRegistrationsByType(string $type): Collection|null
    {
        try {
            $response = $this->makeRequest("/api/v1/registrations/by-type", [
                'type' => $type
            ]);
        } catch (Exception $exception) {
            throw new RequestError($exception->getMessage(), previous: $exception);
        }

        if ($response) {
            return collect($response->json()['data'])->map(function (array $item) {
                return new RegistrationDTO($item);
            });
        }

        return null;
    }
}
