<?php

namespace App\Domain\User\Http\Requests\Address;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class AddressFastStoreFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('main.name'),
        ];
    }

    /**
     * Determine if the Address is authorized to make this request.
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
        $rules = [
            'address_1' => 'required|unique:addresses,address_1',
            'location_id' => 'required|exists:locations,id',

        ];

        return $rules;
    }
}
