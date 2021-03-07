<?php

namespace App\Domain\Order\Http\Requests\DeliveryOrder;

use App\Domain\Order\Http\Requests\Deliveryorder\DeliveryorderStoreFormRequest;

class DeliveryOrderUpdateFormRequest extends DeliveryorderStoreFormRequest
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
     * Determine if the deliveryorder is authorized to make this request.
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
            // 'email'    => ['required','unique:deliveryorders,name,'.$this->route()->parameter('deliveryorder').',id'],
        ];

        return array_merge(parent::rules(), $rules);
    }
}
