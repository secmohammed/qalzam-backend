<?php

namespace App\Domain\Product\Http\Requests\ProductVariationType;

use App\Domain\Product\Http\Requests\ProductVariationType\ProductVariationTypeStoreFormRequest;

class ProductVariationTypeUpdateFormRequest extends ProductVariationTypeStoreFormRequest
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
     * Determine if the productvariationtype is authorized to make this request.
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
            'name' => ['required', 'unique:product_variation_types,name,' . $this->product_variation_type->id],
        ];

        return array_merge(parent::rules(), $rules);
    }
}
