<?php

namespace App\Domain\Feed\Http\Requests\Review;

use App\Domain\Feed\Http\Requests\Review\FeedReviewStoreFormRequest;

class FeedReviewUpdateFormRequest extends FeedReviewStoreFormRequest
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
