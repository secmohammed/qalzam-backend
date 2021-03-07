<?php

namespace App\Domain\User\Http\Requests\Cart;

use Illuminate\Validation\Rule;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CartStoreFormRequest extends FormRequest
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
     * Determine if the Address is authorized to make this request.
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
            'products' => 'required|array',
            'products.*.id' => ['required', 'exists:product_variations,id',
                Rule::exists('branch_product', 'product_variation_id')->where(function ($builder) {
                    $builder->where('branch_id', $this->branch->id);
                }),
            ],
            'products.*.quantity' => 'numeric|min:1',
        ];

        return $rules;
    }
}
