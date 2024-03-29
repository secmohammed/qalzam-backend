<?php

namespace App\Domain\Product\Http\Requests\Product;

use App\Domain\Product\Http\Requests\Product\ProductStoreFormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateFormRequest extends ProductStoreFormRequest
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
     * Determine if the product is authorized to make this request.
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
            'slug' => ['required', Rule::unique('products', 'slug')->ignore($this->product->id)],
            'product-images' => 'nullable|array',
            'product-images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'nullable|array',
        ];

        return array_merge(parent::rules(), $rules);
    }
}
