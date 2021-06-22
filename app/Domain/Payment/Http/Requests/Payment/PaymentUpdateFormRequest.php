<?php

namespace App\Domain\Payment\Http\Requests\Payment;
use App\Domain\Payment\Http\Requests\Payment\PaymentStoreFormRequest;

class PaymentUpdateFormRequest extends PaymentStoreFormRequest
{
    /**
     * Determine if the payment is authorized to make this request.
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
        // 'email'    => ['required','unique:payments,name,'.$this->route()->parameter('payment').',id'],
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
