<?php

namespace App\Domain\Location\Http\Requests\Location;

use App\Domain\Location\Entities\Location;
use App\Common\Http\Rules\UniqueValidationArNameRule;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class LocationStoreFormRequest extends FormRequest
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
            'name_ar' => __('main.name_ar'),
            'parent_id' => __('main.parent'),
            'type' => __('main.type'),
        ];
    }

    /**
     * Determine if the Location is authorized to make this request.
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
            'name' => 'required|unique:locations,name',
            'name_ar' => ['required', new UniqueValidationArNameRule(Location::class)],
            'parent_id' => 'nullable|exists:locations,id',
            'type' => 'required|in:city,zone,district,country',
        ];

        return $rules;
    }
}
