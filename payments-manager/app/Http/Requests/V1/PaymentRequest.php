<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'total_in_cents' => ['required', 'numeric'],
            'paid_at' => ['date_format:Y-m-d H:i:s'],
            'type' => 'required|string',
        ];
    }
}
