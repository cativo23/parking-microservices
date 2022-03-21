<?php

namespace App\APIs;

use App\Data\PaymentDTO;
use App\Exceptions\APIs\RequestError;
use App\Exceptions\APIs\StatusNotExpected;

use Exception;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;

use function config;

class Payments extends BaseAPI
{
    public function setConfigs(): void
    {
        $this->baseUrl = config('services.payments_manager.url');
        $this->token = config('services.payments_manager.token');
    }

    /**
     * @throws RequestError
     * @throws UnknownProperties
     */
    public function savePayment(
        string $licensePlate,
        int $totalInCents,
        string $type = 'other',
        bool $paid = true
    ): PaymentDTO|null {
        try {
            $body = [
                'license_plate' => $licensePlate,
                'total_in_cents' => $totalInCents,
                'type' => $type
            ];

            if ($paid) {
                $body['paid_at'] = now()->format('Y-m-d H:i:s');
            }

            $response = $this->makeRequest("/api/v1/payments", $body, 'post');
        } catch (Exception $exception) {
            throw new RequestError($exception->getMessage(), previous: $exception);
        }

        if ($response) {
            return new PaymentDTO($response->json()['data']);
        }

        return null;
    }
}
