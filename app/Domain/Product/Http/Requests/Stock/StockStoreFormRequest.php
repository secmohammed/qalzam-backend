<?php

namespace App\Domain\Product\Http\Requests\Stock;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class StockStoreFormRequest extends FormRequest
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
     * Determine if the Stock is authorized to make this request.
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
            'product_variation_id' => 'required|exists:product_variations,id',
            'quantity' => 'required|numeric|min:1',
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
