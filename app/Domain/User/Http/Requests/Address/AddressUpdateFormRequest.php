<?php

namespace App\Domain\User\Http\Requests\Address;
use App\Domain\User\Http\Requests\Address\AddressStoreFormRequest;

class AddressUpdateFormRequest extends AddressStoreFormRequest
{
    /**
     * Determine if the address is authorized to make this request.
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
        'address_1'    => ['required','unique:addresses,address_1,'. $this->address->id],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }
}
