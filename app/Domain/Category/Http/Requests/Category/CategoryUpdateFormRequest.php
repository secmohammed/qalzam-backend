<?php

namespace App\Domain\Category\Http\Requests\Category;

use App\Domain\Category\Http\Requests\Category\CategoryStoreFormRequest;

class CategoryUpdateFormRequest extends CategoryStoreFormRequest
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

     * Determine if the category is authorized to make this request.
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
            'name' => ['required', 'unique:categories,name,' . $this->category->id],
        ];

        return array_merge(parent::rules(), $rules);
    }
}
