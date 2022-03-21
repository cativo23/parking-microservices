<?php

namespace App\Http\Controllers\API\V1;

use App\APIs\Payments;
use App\APIs\Vehicles;
use App\Exceptions\APIs\RequestError;
use App\Http\Controllers\API\V1\Contracts\CrudBaseController;
use App\Http\Requests\V1\RegistrationRequest;
use App\Http\Resources\V1\RegistrationResource;
use App\Models\V1\Registration;
use Illuminate\Http\JsonResponse;
use Date;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $payment = null;

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
            $totalPayment = round($registration->refresh()->total_time * 50, 2);

            try {
                $payment = (new Payments())->savePayment(
                    $registration->license_plate,
                    $totalPayment
                );
            } catch (RequestError|UnknownProperties $e) {
                return $this->errorInternalError($e->getMessage());
            }
        } else {
            switch ($vehicle->type) {
                case 'resident':
                    $totalPayment = round($registration->refresh()->total_time * 5, 2);
                    try {
                        $payment = (new Payments())->savePayment(
                            $registration->license_plate,
                            $totalPayment,
                            $vehicle->type,
                            false
                        );
                    } catch (RequestError|UnknownProperties $e) {
                        return $this->errorInternalError($e->getMessage());
                    }
                    break;
                case 'official':
                default:
                    break;
            }
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
        $registration = $this->repository->getById($id);

        if ($registration) {
            $result = $this->repository->delete($registration);

            if ($result) {
                return $this->setStatusCode(Response::HTTP_OK)->success(
                    'Registration deleted',
                    data: (new $this->resource($registration))->resolve()
                );
            }
        }

        return $this->errorNotFound('Registration Not Found');
    }

    public function restore(int $id): JsonResponse
    {
        /* @var Registration $registration */
        $registration = $this->repository->getByIdTrashed($id);

        if ($registration) {
            $result = $this->repository->restore($registration);

            if ($result) {
                return $this->setStatusCode(Response::HTTP_OK)->success(
                    'Registration Restored',
                    data: (new $this->resource($registration))->resolve()
                );
            }
        }

        return $this->errorNotFound('Registration Not Found');
    }

    public function getResidentRegistrations(Request $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $vehicles = (new Vehicles())->getVehicleByType($request->input('type', 'resident'));

            $licensePlates = $vehicles?->pluck('license_plate');

            $registrations = $this->repository->getByLicensePlates($licensePlates->toArray());
        } catch (RequestError $e) {
            return $this->errorInternalError($e->getMessage());
        }

        /* @var AnonymousResourceCollection $result*/
        $result = $this->resource::collection($registrations);

        return $this->respondWithSuccess('Registrations returned correctly!', $result->resolve());
    }

    /**
     * @throws RequestError
     */
    public function monthStart(): JsonResponse
    {
        $residentVehicles = (new Vehicles())->getVehicleByType('resident');
        $officialVehicles = (new Vehicles())->getVehicleByType('official');

        $result = $this->repository->deleteAll($residentVehicles?->pluck('license_plate')->toArray());

        $result2 = $this->repository->forceDeleteAll($officialVehicles?->pluck('license_plate')->toArray());

        if ($result) {
            return $this->setStatusCode(Response::HTTP_OK)->success(
                'Month Started successfully!',
            );
        }


        return $this->errorNotFound('Registration Not Found');
    }
}
