<?php

namespace App\Domain\Post\Http\Requests\Post;

use App\Domain\Post\Http\Rules\EnsureCategoryCanBeAttachedToPost;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class PostStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Post is authorized to make this request.
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
            'title' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'description' => 'required|string|min:32',
            'description_ar' => 'required|string|min:32',
            'status' => 'required|in:approved,disapproved',
            'type' => 'nullable|in:normal,featured',
            'categories' => 'nullable|array',
            'categories.*' => ['required', new EnsureCategoryCanBeAttachedToPost],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => __('main.title'),
            'title_ar' => __('main.title_ar'),
            'description' => __('main.description'),
            'description_ar' => __('main.description_ar'),
            'status' => __('main.status'),
            'type' => __('main.type'),
            'categories' => __('main.categories'),
            'image' => __('main.image'),
        ];
    }
}
