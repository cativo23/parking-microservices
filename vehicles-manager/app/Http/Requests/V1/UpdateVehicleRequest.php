<?php

namespace App\Http\Requests\V1;

use App\Enums\VehicleTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Http\Requests\TransformsEnums;
use Spatie\Enum\Laravel\Rules\EnumRule;

class UpdateVehicleRequest extends FormRequest
{
    use TransformsEnums;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'license_plate' => ['required', 'string', 'unique:vehicles,license_plate,' . $this->route('vehicle')],
            'type' => ['required', new EnumRule(VehicleTypeEnum::class)],
        ];
    }

    public function enums(): array
    {
        return [
            'type' => VehicleTypeEnum::class,
        ];
    }
}
