<?php

namespace App\Domain\Category\Http\Requests\Category;

use App\Common\Http\Rules\UniqueValidationArNameRule;
use App\Domain\Category\Entities\Category;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CategoryStoreFormRequest extends FormRequest
{
    /**

     * Determine if the Category is authorized to make this request.
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
            'name' => 'required|unique:categories,name',
            'name_ar' => ['required', new UniqueValidationArNameRule(Category::class)],
            'type' => 'required|in:posts,products,accommodations',
            'categorizable_type' => 'required|in:posts,products,accommodations',
            'categorizable_id' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];

        return $rules;
    }
}
