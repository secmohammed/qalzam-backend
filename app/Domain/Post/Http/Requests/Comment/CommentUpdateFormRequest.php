<?php

namespace App\Domain\Post\Http\Requests\Comment;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CommentUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the post is authorized to make this request.
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

        return [
            'body' => 'required|min:32',
        ];
    }
}
