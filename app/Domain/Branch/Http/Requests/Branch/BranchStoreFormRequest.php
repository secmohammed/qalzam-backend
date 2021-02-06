<?php

namespace App\Domain\Branch\Http\Requests\Branch;

use App\Domain\Branch\Entities\Branch;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class BranchStoreFormRequest extends FormRequest
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
     * Determine if the Branch is authorized to make this request.
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
            'name' => 'required|unique:branches,name|min:8|max:255',
            'location_id' => 'required|exists:locations,id',
            'latitude' => ['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'unique:branches,latitude'],
            'longitude' => ['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'unique:branches,longitude'],
            'branch-gallery' => ['required', 'array'],
            'branch-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],
            'users' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'users.*' => 'required|exists:users,id',
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
