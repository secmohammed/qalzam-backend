<?php

namespace App\Domain\Branch\Http\Requests\BranchShift;

use App\Domain\Branch\Http\Requests\BranchShift\BranchShiftStoreFormRequest;

class BranchShiftUpdateFormRequest extends BranchShiftStoreFormRequest
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
     * Determine if the branchshift is authorized to make this request.
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
            // 'email'    => ['required','unique:branchshifts,name,'.$this->route()->parameter('branchshift').',id'],
        ];

        return array_merge(parent::rules(), $rules);
    }
}
