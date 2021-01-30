<?php

namespace App\Domain\Accommodation\Http\Requests\Accommodation;
use App\Domain\Accommodation\Http\Requests\Accommodation\AccommodationStoreFormRequest;

class AccommodationUpdateFormRequest extends AccommodationStoreFormRequest
{
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
        // 'email'    => ['required','unique:accommodations,name,'.$this->route()->parameter('accommodation').',id'],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }
}
