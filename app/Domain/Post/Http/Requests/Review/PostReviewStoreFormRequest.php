<?php

namespace App\Domain\Post\Http\Requests\Review;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class PostReviewStoreFormRequest extends FormRequest
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
            'body' => 'nullable|min:8',
            'score' => 'required|integer|min:1|max:5',
        ];
    }
}
