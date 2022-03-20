<?php

namespace App\Http\Controllers\API\V1;

use App\APIs\Vehicles;
use App\Exceptions\APIs\RequestError;
use App\Http\Controllers\API\V1\Contracts\CrudBaseController;
use App\Http\Requests\V1\RegistrationRequest;
use App\Http\Resources\V1\RegistrationResource;
use App\Models\V1\Registration;
use Illuminate\Http\JsonResponse;
use Date;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends CrudBaseController
{
    protected function resource(): string
    {
        return RegistrationResource::class;
    }

    public function store(RegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['enter_date'] = Date::now();

        /* @var Registration $registration */
        $registration = $this->repository->getLastByLicensePlate($data['license_plate']);

        if ($registration && $registration->exit_date === null) {
            return $this->errorWrongData('Registration already created');
        }

        $registration = $this->repository->create($data);

        return $this->successCreatedWithResource(
            new $this->resource($registration),
            'Registration Created Successfully'
        );
    }

    public function show(int $id): JsonResponse
    {
        $registration = $this->repository->getById($id);

        if ($registration) {
            return $this->setStatusCode(Response::HTTP_FOUND)->success(
                data: (new $this->resource($registration))->resolve()
            );
        }

        return $this->errorNotFound('Registration Not Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id): JsonResponse
    {
        $payment = 0.00;

        /* @var Registration $registration */
        $registration = $this->repository->getLastByLicensePlate($id);

        if ($registration->exit_date !== null) {
            return $this->errorWrongData('Vehicle Is not in Parking Lot');
        }

        $result = $this->repository->update($registration, ['exit_date'=>Date::now()]);

        try {
            $vehicle = (new Vehicles())->getVehicleByLicencePlate($registration->license_plate);
        } catch (UnknownProperties|RequestError $e) {
            return $this->errorInternalError($e->getMessage());
        }

        if (!$vehicle) {
            $payment = round($registration->refresh()->total_time * 0.05, 2);
            //TODO: SEND PAYMENT TO SERVICE
        }

        if ($result) {
            return $this->successAccepted(
                'Register Updated Successfully',
                [
                    'register' => new $this->resource($registration),
                    'payment' => $payment
                ]
            );
        }


        return $this->errorInternalError();
    }


    public function destroy(int $id): JsonResponse
    {
        //TODO: Implement soft deletes
        throw new RuntimeException();
    }
}
