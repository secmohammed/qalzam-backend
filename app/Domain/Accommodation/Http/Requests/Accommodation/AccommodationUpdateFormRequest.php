<?php

namespace App\Domain\Accommodation\Http\Requests\Accommodation;

use App\Domain\Accommodation\Http\Requests\Accommodation\AccommodationStoreFormRequest;

class AccommodationUpdateFormRequest extends AccommodationStoreFormRequest
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
     * Determine if the accommodation is authorized to make this request.
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
            'name' => 'required|string|max:255',
            'categories' => 'nullable|array',
            'code' => 'required|unique:accommodations,code,' . $this->accommodation->id,
            'accommodation-gallery' => 'nullable|array',

            'accommodation-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],

        ];

        return array_merge(parent::rules(), $rules);
    }
}
