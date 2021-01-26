<?php

namespace App\Domain\Discount\Http\Requests\Discount;

use App\Domain\Discount\Http\Requests\Discount\DiscountStoreFormRequest;

class DiscountUpdateFormRequest extends DiscountStoreFormRequest
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

     * Determine if the discount is authorized to make this request.
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
            'code' => ['required', 'unique:discounts,code,' . $this->route('discount')],

        ];

        return array_merge(parent::rules(), $rules);
    }
}
