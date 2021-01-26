<?php

namespace App\Domain\Product\Http\Requests\ProductVariation;

use App\Domain\Product\Http\Requests\ProductVariation\ProductVariationStoreFormRequest;

class ProductVariationUpdateFormRequest extends ProductVariationStoreFormRequest
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
     * Determine if the productvariation is authorized to make this request.
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
            'product-variation-images' => 'nullable|array',
            'product-variation-images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        return array_merge(parent::rules(), $rules);
    }
}
