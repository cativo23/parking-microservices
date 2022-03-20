<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Contracts\CrudBaseController;
use App\Http\Requests\V1\StoreVehicleRequest;
use App\Http\Requests\V1\UpdateVehicleRequest;
use App\Http\Resources\V1\VehicleResource;
use App\Models\V1\Vehicle;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends CrudBaseController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $data = $request->validated();

        $vehicle = $this->repository->getByLicensePlate($data['license_plate']);

        if ($vehicle) {
            $updated = $this->repository->update($vehicle, $data);

            if ($updated) {
                return $this->successAccepted(
                    'Vehicle Registered as ' . $data['type'],
                    (new $this->resource($vehicle))->resolve()
                );
            }
            return $this->errorInternalError();
        }

        $vehicle = $this->repository->create($data);

        return $this->successCreatedWithResource(new $this->resource($vehicle), 'Vehicle Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $vehicle = $this->repository->getById($id);

        if ($vehicle) {
            return $this->setStatusCode(Response::HTTP_FOUND)->success(
                data: (new $this->resource($vehicle))->resolve()
            );
        }

        return $this->errorNotFound('Vehicle Not Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $vehicle = $this->repository->getById($id);
        $result = $this->repository->update($vehicle, $data);
        if ($result) {
            return $this->successAccepted(
                'Vehicle Updated Successfully',
                (new $this->resource($vehicle))->resolve()
            );
        }

        return $this->errorInternalError();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);

        return $this->success('Vehicle Deleted Successfully');
    }

    protected function model(): string
    {
        return Vehicle::class;
    }

    protected function resource(): string
    {
        return VehicleResource::class;
    }
}
