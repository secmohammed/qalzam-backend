<?php

namespace App\Domain\User\Http\Requests\Address;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class AddressStoreFormRequest extends FormRequest
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
            'name' => 'required',
            'address_1' => 'required|unique:addresses,address_1',
            'landmark' => 'required',
            'location_id' => 'required|exists:locations,id',
            'postal_code' => 'required',
            'default' => 'nullable|boolean',
        ];

        return $rules;
    }
}
