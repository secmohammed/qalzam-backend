<?php

namespace App\Domain\Competition\Http\Requests\Competition;

use App\Domain\Competition\Http\Requests\Competition\CompetitionStoreFormRequest;

class CompetitionUpdateFormRequest extends CompetitionStoreFormRequest
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
     * Determine if the competition is authorized to make this request.
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
            'competition-cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg'],
            'name_ar' => 'nullable|string|max:255',
            'location_id' => 'nullable|exists:locations,id',
            'featured' => 'nullable|in:featured,normal',

        ];

        return array_merge(parent::rules(), $rules);
    }
}
