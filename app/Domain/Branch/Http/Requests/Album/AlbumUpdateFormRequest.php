<?php

namespace App\Domain\Branch\Http\Requests\Album;

use App\Domain\Branch\Http\Requests\Album\AlbumStoreFormRequest;

class AlbumUpdateFormRequest extends AlbumStoreFormRequest
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
     * Determine if the album is authorized to make this request.
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
            'name' => ['required', 'unique:albums,name,' . $this->album->id],
            'album-gallery' => ['nullable', 'array'],
            'album-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],

        ];

        return array_merge(parent::rules(), $rules);
    }
}
