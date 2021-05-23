<?php

namespace App\Domain\Branch\Http\Requests\BranchProduct;

use App\Domain\Product\Entities\ProductVariation;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class BranchProductStoreFormRequest extends FormRequest
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
     * Determine if the Meeting is authorized to make this request.
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
            'products.*.id' => 'required|exists:product_variations,id',
            'products.*.price' => ['nullable', 'numeric', 'min:10', 'max:10000'],

        ];

        return $rules;
    }

    public function validated()
    {

        return collect($this->request->get('products'))->keyBy('id')->map(function ($product) {
            return [
                'price' => $product['price'],
                'product_id' => ProductVariation::find($product['id'])->product_id, // todo change that in future
            ];
        })->toArray();
    }
}
