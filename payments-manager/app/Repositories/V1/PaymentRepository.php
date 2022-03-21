<?php

namespace App\Repositories\V1;

use App\Models\V1\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class PaymentRepository extends BaseRepository
{

    protected array $allowedFilters = [
        'license_plate',
    ];

    protected array $allowedFiltersExact = [
    ];

    protected function model(): string
    {
        return Payment::class;
    }

    public function getNotPaid(string $type): Collection
    {
        return $this->model::where('paid_at', null)
            ->where('type', $type)
            ->get();
    }
}
