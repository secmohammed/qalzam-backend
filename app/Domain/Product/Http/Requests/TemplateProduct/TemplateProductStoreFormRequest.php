<?php

namespace App\Domain\Product\Http\Requests\TemplateProduct;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class TemplateProductStoreFormRequest extends FormRequest
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
        // dd($this->request);
        $rules = [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:product_variations,id',
            'products.*.price' => ['required', 'numeric', 'min:10', 'max:10000'],
            'products.*.quantity' => ['required', 'numeric', 'min:1', 'max:100'],

        ];

        return $rules;
    }

    public function validated()
    {

        return collect($this->request->get('products'))->keyBy('id')->map(function ($product) {
            return [
                'price' => $product['price'],
                'quantity' => $product['quantity'],
            ];
        })->toArray();
    }
}
