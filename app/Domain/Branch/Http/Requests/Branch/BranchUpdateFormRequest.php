<?php

namespace App\Domain\Branch\Http\Requests\Branch;

use App\Domain\Branch\Http\Requests\Branch\BranchStoreFormRequest;

class BranchUpdateFormRequest extends BranchStoreFormRequest
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
     * Determine if the branch is authorized to make this request.
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
            'name' => ['required', 'unique:branches,name,' . $this->branch->id, 'min:8', 'max:255'],
            'branch-gallery' => ['required', 'array'],
            'branch-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],

        ];

        return array_merge(parent::rules(), $rules);
    }
}
