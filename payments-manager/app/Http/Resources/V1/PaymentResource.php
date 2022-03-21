<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Payment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Payment
 */
class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'license_plate' => $this->license_plate,
            'paid' => $this->paid,
            'paid_at' => $this->paid_at?->format('Y-m-d H:i:s'),
            'total_in_cents' => $this->total_in_cents,
            'total_in_usd' => (float)$this->total_in_usd->formatByDecimal(),
            'type' => $this->type
        ];
    }
}
