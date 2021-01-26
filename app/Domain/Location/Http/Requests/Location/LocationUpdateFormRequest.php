<?php

namespace App\Domain\Location\Http\Requests\Location;

use App\Domain\Location\Http\Requests\Location\LocationStoreFormRequest;

class LocationUpdateFormRequest extends LocationStoreFormRequest
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

     * Determine if the location is authorized to make this request.
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
            'name' => ['required', 'unique:locations,name,' . $this->route('location')->id],

        ];

        return array_merge(parent::rules(), $rules);
    }
}
