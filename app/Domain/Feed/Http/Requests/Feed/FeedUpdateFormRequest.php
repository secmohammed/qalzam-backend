<?php

namespace App\Domain\Feed\Http\Requests\Feed;

use App\Domain\Feed\Http\Requests\Feed\FeedStoreFormRequest;

class FeedUpdateFormRequest extends FeedStoreFormRequest
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
     * Determine if the feed is authorized to make this request.
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
            'feed-isomorphic' => ['nullable', 'array'],
            'deleted-feeds' => ['nullable', 'array'],
            'deleted-feeds.*' => 'required|exists:media,id',
        ];

        return array_merge(parent::rules(), $rules);
    }
}
