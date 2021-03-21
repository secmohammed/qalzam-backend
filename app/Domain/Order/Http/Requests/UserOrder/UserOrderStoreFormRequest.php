<?php

namespace App\Domain\Order\Http\Requests\UserOrder;

use Illuminate\Validation\Rule;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UserOrderStoreFormRequest extends FormRequest
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
     * Determine if the Order is authorized to make this request.
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
            'discount_id' => 'nullable|exists:discounts,id',
            'branch_id' => 'required|exists:branches,id',
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where(function ($builder) {
                    $builder->where('user_id', $this->user()->id);
                }),
            ],
        ];

        return $rules;
    }

    public function validated()
    {

        return array_merge(parent::validated(), [
            'creator_id' => auth()->id(),
        ]);
    }
}
