<?php

namespace App\Domain\Accommodation\Http\Requests\Contract;

use App\Domain\Accommodation\Http\Rules\EnsureTemplateHasProducts;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ContractStoreFormRequest extends FormRequest
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
     * Determine if the Contract is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255', 'unique:contracts,name'],
            'template_id' => ['required', new EnsureTemplateHasProducts],
            'status' => 'nullable|in:active,inactive',
            'days' => 'required|array',
            'days.*' => 'required|in:saturday,sunday,monday,tuesday,thursday,wednesday,friday',
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
