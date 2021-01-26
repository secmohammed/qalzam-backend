<?php

namespace App\Domain\Child\Http\Requests\Child;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ChildStoreFormRequest extends FormRequest
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
            'birthdate' => __('main.birthdate'),
            'gender' => __('main.gender'),
            'relation' => __('main.relation'),
            'child-avatar' => __('main.image'),
        ];
    }

    /**
     * Determine if the Child is authorized to make this request.
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
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'national_id' => ['required', 'unique:children,national_id', 'regex:/^(2|3)[0-9][1-9][0-1][0-9][0-3][1-9](01|02|03|04|11|12|13|14|15|16|17|18|19|21|22|23|24|25|26|27|28|29|31|32|33|34|35|88)\d\d\d\d\d$/'],
            'relation' => ['required', 'in:son,daughter,grand-son,grand-daughter,nephew'],
            'child-avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,svg'],
            'child-birthdate-certificate' => ['required', 'image', 'mimes:jpeg,png,jpg'],
            'location_id' => 'required|exists:locations,id',
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
