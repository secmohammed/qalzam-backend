<?php

namespace App\Domain\User\Http\Requests\Wishlist;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class WishlistStoreFormRequest extends FormRequest
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
     * Determine if the Address is authorized to make this request.
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
            'products' => 'required|array',
            'products.*' => 'required|exists:product_variations,id',
        ];

        return $rules;
    }
}
