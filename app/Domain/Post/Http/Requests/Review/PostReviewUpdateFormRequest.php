<?php

namespace App\Domain\Post\Http\Requests\Review;

use App\Domain\Post\Http\Requests\Review\PostReviewStoreFormRequest;

class PostReviewUpdateFormRequest extends PostReviewStoreFormRequest
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
        return parent::rules();
    }
}
