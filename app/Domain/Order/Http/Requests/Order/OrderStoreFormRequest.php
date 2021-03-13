<?php

namespace App\Domain\Order\Http\Requests\Order;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

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
            'branch_id' => 'required|exists:branches,id',
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where(function ($builder) {
                    $builder->where('user_id', $this->user()->id);
                }),
            ],
        ];
        if (request()->routeIs('api.orders.store', 'api.orders.update')) {
            $rules = [
                'products' => 'required|array',
                'products.*.id' => 'required|exists:product_variations,id',
                'products.*.quantity' => 'required|numeric|min:1',
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
        if (request()->routeIs('api.orders.store', 'api.orders.update')) {
            return array_merge(parent::validated(), [
                'creator_id' => auth()->id(),
                'products' => collect($this->request->get('products'))->keyBy('id')->map(function ($product) {
                    return [
                        'quantity' => $product['quantity'],
                    ];
                })->toArray(),
            ]);
        }

        return array_merge(parent::validated(), [
            'creator_id' => auth()->id(),
        ]);
    }
}
