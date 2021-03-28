<?php

namespace App\Domain\Order\Http\Requests\Order;

use Illuminate\Validation\Rule;
use App\Domain\Order\Http\Requests\Order\OrderStoreFormRequest;

class OrderUpdateFormRequest extends OrderStoreFormRequest
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
            'products' => 'nullable|array',
            'products.*.id' => 'required|exists:product_variations,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'address_id' => [
                'nullable',
                Rule::exists('addresses', 'id')->where(function ($builder) {
                    $builder->where('user_id', $this->request->get('user_id'));
                }),
            ],
            'user_id' => 'required|exists:users,id',

        ];

        return array_merge(parent::rules(), $rules);
    }
}
