<?php

namespace App\Domain\Product\Http\Requests\Product;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreFormRequest extends FormRequest
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
     * Determine if the Product is authorized to make this request.
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
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:10000'],
            'product-images' => 'required|array',
            'product-images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'slug_ar' => 'required|string|max:255',
            'description_ar' => 'required|string|max:255',

            'categories.*' => 'required|exists:categories,id'
        ];

        return $rules;
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'user_id' => auth()->id(),
        ]);
    }
}
