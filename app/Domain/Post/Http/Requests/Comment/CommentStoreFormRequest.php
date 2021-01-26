<?php

namespace App\Domain\Post\Http\Requests\Comment;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CommentStoreFormRequest extends FormRequest
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
            'body' => 'required|min:3',
            'parent_id' => 'nullable|exists:comments,id',
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
