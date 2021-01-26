<?php

namespace App\Domain\Order\Http\Requests\Order;
use App\Domain\Order\Http\Requests\Order\OrderStoreFormRequest;

class OrderUpdateFormRequest extends OrderStoreFormRequest
{
    /**
     * Determine if the order is authorized to make this request.
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
        // 'email'    => ['required','unique:orders,name,'.$this->route()->parameter('order').',id'],
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
