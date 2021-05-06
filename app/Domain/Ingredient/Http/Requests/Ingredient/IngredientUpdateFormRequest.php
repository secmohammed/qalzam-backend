<?php

namespace App\Domain\Ingredient\Http\Requests\Ingredient;

use App\Common\Http\Rules\UniqueValidationArNameRule;
use App\Domain\Ingredient\Http\Requests\Ingredient\IngredientStoreFormRequest;
use Illuminate\Validation\Rule;

class IngredientUpdateFormRequest extends IngredientStoreFormRequest
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
     * Determine if the ingredient is authorized to make this request.
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
            'name' => ['required', Rule::unique('ingredients', 'name')->ignore($this->ingredient)],
            'name_ar' => ['required', new UniqueValidationArNameRule('App\Domain\Ingredient\Entities\Ingredient')],
            'ingredient-icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];

        return array_merge(parent::rules(), $rules);
    }
}
