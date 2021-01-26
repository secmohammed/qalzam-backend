<?php

namespace App\Domain\Discount\Http\Requests\DiscountUser;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class DiscountUserStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Discount is authorized to make this request.
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
        return [
            'code' => 'required|max:32|exists:discounts,code',
        ];
    }
}
