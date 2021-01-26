<?php

namespace App\Domain\Product\Http\Requests\Stock;

use App\Domain\Product\Http\Requests\Stock\StockStoreFormRequest;

class StockUpdateFormRequest extends StockStoreFormRequest
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
     * Determine if the stock is authorized to make this request.
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
        ];

        return array_merge(parent::rules(), $rules);
    }
}
