<?php

namespace App\Domain\Feed\Http\Requests\Review;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class FeedReviewStoreFormRequest extends FormRequest
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
            'score' => 'nullable|integer|min:1|max:5',
        ];
    }
}
