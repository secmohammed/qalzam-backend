<?php

namespace App\Domain\Branch\Http\Requests\Album;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class AlbumStoreFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('main.name'),
        ];
    }

    /**
     * Determine if the Album is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255', 'unique:albums,name'],
            'branch_id' => 'required|exists:branches,id',
            'album-gallery' => ['required', 'array'],
            'album-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],
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
