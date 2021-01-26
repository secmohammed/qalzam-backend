<?php

namespace App\Domain\User\Http\Requests\Cart;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CartUpdateFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }

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
        return [
            'quantity' => 'required|min:1|numeric',

        ];
    }
}
