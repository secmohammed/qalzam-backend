<?php

namespace App\Domain\Accommodation\Http\Requests\Contract;

use App\Domain\Accommodation\Http\Requests\Contract\ContractStoreFormRequest;

class ContractUpdateFormRequest extends ContractStoreFormRequest
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
     * Determine if the contract is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255', 'unique:contracts,name,' . $this->contract->id],
        ];

        return array_merge(parent::rules(), $rules);
    }
}
