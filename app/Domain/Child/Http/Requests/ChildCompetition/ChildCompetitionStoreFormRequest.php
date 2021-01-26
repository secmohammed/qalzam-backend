<?php

namespace App\Domain\Child\Http\Requests\ChildCompetition;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ChildCompetitionStoreFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'children' => __('main.children'),
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
            'children' => ['required', 'array'],
            'children.*' => ['required', 'exists:children,id'],
        ];

        return $rules;
    }
}
