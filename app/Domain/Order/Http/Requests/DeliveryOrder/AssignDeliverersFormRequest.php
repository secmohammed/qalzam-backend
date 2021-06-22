<?php

namespace App\Domain\Order\Http\Requests\DeliveryOrder;

use App\Domain\Order\Http\Rules\EnsureBranchHasDeliveryGuy;
use App\Domain\Order\Http\Rules\EnsureOrderTypeIsDelivery;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class AssignDeliverersFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'delivery_id' => __('main.deliverers'),
            'orders' => __('main.orders'),
        ];
    }

    /**
     * Determine if the Deliveryorder is authorized to make this request.
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
        // dd($this->request);
        $rules = [
            'delivery_id' => ['required', 'exists:users,id'],
            'orders' => ['required', 'array'],
            'orders.*' => ['required', 'exists:orders,id',new EnsureOrderTypeIsDelivery()],
        ];

        return $rules;
    }
 
}
