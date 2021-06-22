<?php

namespace App\Domain\Payment\Http\Requests\Payment;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class PaymentStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Payment is authorized to make this request.
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
            'order_id'        => 'required',
        ];
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
 
}
