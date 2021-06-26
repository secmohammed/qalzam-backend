<?php

namespace App\Domain\Product\Http\Requests\ProductVariation;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

class ProductVariationStoreFormRequest extends FormRequest
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
     * Determine if the ProductVariation is authorized to make this request.
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
            'status' => 'nullable|in:active,inactive',
            'slug' => ['required', 'string', 'max:255', Rule::unique('product_variations', 'slug')],
            'description' => ['required', 'string', 'max:255'],
            'description_ar' => ['nullable'],
            'slug_ar' => ['nullable'],
  
            'price' => ['nullable', 'numeric', 'min:1', 'max:10000'],
            'product_id' => 'required|exists:products,id',
            'product_variation_type_id' => ['required','exists:product_variation_types,id', Rule::unique('product_variations', 'product_variation_type_id')->where('product_id',$this->product_id)],
            'product_variation-images' => 'required|array',
            'product_variation-images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255'
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
