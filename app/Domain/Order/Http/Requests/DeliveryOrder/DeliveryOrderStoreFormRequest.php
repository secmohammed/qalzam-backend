<?php

namespace App\Domain\Order\Http\Requests\DeliveryOrder;

use App\Domain\Order\Http\Rules\EnsureBranchHasDeliveryGuy;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class DeliveryOrderStoreFormRequest extends FormRequest
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
        $rules = [
            'branch_id' => ['required', 'exists:branches,id'],
            'user_id' => ['required', 'exists:users,id', new EnsureBranchHasDeliveryGuy($this->request->get('branch_id'))],
        ];

        return $rules;
    }
}
