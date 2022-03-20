<?php

namespace App\Http\Requests\V1;

use App\Enums\VehicleTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'license_plate' => ['required', 'string'],
            'type' => ['required', new EnumRule(VehicleTypeEnum::class)],
        ];
    }
}
