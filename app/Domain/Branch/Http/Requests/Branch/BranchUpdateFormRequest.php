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
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'unique:branches,latitude,' . $this->branch->id],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'unique:branches,longitude,' . $this->branch->id],

        ];

        return array_merge(parent::rules(), $rules);
    }
}
