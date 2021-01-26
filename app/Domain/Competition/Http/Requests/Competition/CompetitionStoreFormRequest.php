<?php

namespace App\Domain\Competition\Http\Requests\Competition;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CompetitionStoreFormRequest extends FormRequest
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
            'start_date' => __('main.start_date'),
            'end_date' => __('main.end_date'),
            'age' => __('main.age'),
            'type' => __('main.type'),
            'competition-cover' => __('main.competition-cover'),
        ];
    }

    /**
     * Determine if the Competition is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'start_date' => 'required|after_or_equal:' . now()->format('Y-m-d H:i'),
            'end_date' => 'required|after_or_equal:' . $this->request->get('start_date'),
            'min_age' => 'required|integer|min:1|max:' . $this->request->get('max_age'),
            'max_age' => 'required|integer|min:1|max:30',
            'type' => 'required|in:video,image,check-in',
            'featured' => 'required|in:featured,normal',
            'location_id' => 'required|exists:locations,id',
            'competition-cover' => ['required', 'image', 'mimes:jpeg,png,jpg,svg'],
        ];

        return $rules;
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'user_id' => auth()->id(),
        ]);
    }
}
