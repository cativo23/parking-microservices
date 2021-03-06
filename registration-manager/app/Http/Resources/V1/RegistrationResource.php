<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Registration;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Registration
 */
class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'license_plate' => $this->license_plate,
            'enter_date' => $this->enter_date->format('Y-m-d H:i:s'),
            'exit_date' => $this->exit_date?->format('Y-m-d H:i:s'),
            'total_time' => $this->total_time,
        ];
    }
}
