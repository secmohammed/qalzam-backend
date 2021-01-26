<?php

namespace App\Domain\Order\Http\Requests\Order;

use Illuminate\Validation\Rule;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class OrderStoreFormRequest extends FormRequest
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
     * Determine if the Order is authorized to make this request.
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
            'discount_id' => 'nullable|exists:discounts,id',
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where(function ($builder) {
                    $builder->where('user_id', $this->user()->id);
                }),
            ],
        ];
        if (request()->is('api/orders')) {
            $rules = [
                'products' => 'required|array',
                'products.*' => 'required|exists:product_variations,id',
                'address_id' => [
                    'required',
                    Rule::exists('addresses', 'id')->where(function ($builder) {
                        $builder->where('user_id', $this->request->get('user_id'));
                    }),
                ],
            ] + $rules + [
                'user_id' => 'required|exists:users,id',
            ];
        }

        return $rules;
    }

    public function validated()
    {

        return array_merge(parent::validated(), [
            'creator_id' => auth()->id(),
        ]);
    }
}
