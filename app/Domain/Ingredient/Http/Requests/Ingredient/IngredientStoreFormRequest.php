<?php

namespace App\Domain\Ingredient\Http\Requests\Ingredient;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class IngredientStoreFormRequest extends FormRequest
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
     * Determine if the Ingredient is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255', 'unique:ingredients,name'],
            'ingredient-icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:255|min:32',
            'status' => 'nullable|in:active,inactive',

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
