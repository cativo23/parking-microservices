<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Contracts\CrudBaseController;
use App\Http\Requests\V1\PaymentRequest;
use App\Http\Resources\V1\PaymentResource;
use App\Models\V1\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Cknow\Money\Money;
use Illuminate\Http\JsonResponse;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends CrudBaseController
{
    protected function resource(): string
    {
        return PaymentResource::class;
    }

    public function store(PaymentRequest $request): JsonResponse
    {
        $data = $request->validated();

        /* @var Payment $payment */
        $payment = $this->repository->create($data);

        return $this->successCreatedWithResource(
            new $this->resource($payment),
            'Payment Created Successfully'
        );
    }

    public function show(string|int $id): JsonResponse
    {
        $registration = $this->repository->getById($id);

        if ($registration) {
            return $this->setStatusCode(Response::HTTP_FOUND)->success(
                data: (new $this->resource($registration))->resolve()
            );
        }

        return $this->errorNotFound('Payment Not Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id): JsonResponse
    {
        /* @var Payment $payment */
        $payment = $this->repository->getById($id);

        if ($payment->paid) {
            return $this->errorWrongData('Payment Is Paid');
        }

        $result = $this->repository->update($payment, ['paid_at' => Date::now()]);

        if ($result) {
            return $this->successAccepted(
                'Register Paid Successfully',
                [
                    'payment' => new $this->resource($payment),
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

    public function getPaymentReport(Request $request): \Illuminate\Http\Response
    {
        $notPaid = $this->repository->getNotPaid($request->input('type', 'resident'));

        $result = [];

        $groupedByLicencePlates = $notPaid->groupBy('license_plate');


        $groupedByLicencePlates->each(function (
            Collection $paymentsByLicensePlate,
            string $licensePlate
        ) use (
            &$result
        ) {
            $total = $paymentsByLicensePlate->sum('total_in_cents') / 5;

            $totalPrice = $paymentsByLicensePlate->sum('total_in_cents');

            $result[] = [
                'license_plate' => $licensePlate,
                'parking_time' => $total,
                'total' => Money::USD($totalPrice)->formatByDecimal()
            ];
        });

        $name = 'Residents Pending Payments - ' . now()->format('Y-m-d');

        return PDF::loadView('pdf.payments', [
            'registrations' => $result
        ])->setPaper('letter')->download($name . '.pdf');
    }
}
