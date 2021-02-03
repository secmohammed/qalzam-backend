<?php

namespace App\Domain\Accommodation\Http\Requests\Accommodation;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class AccommodationStoreFormRequest extends FormRequest
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
     * Determine if the Accommodation is authorized to make this request.
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
            'name' => 'required|string|max:255|unique:accommodations,name',
            'accommodation-gallery' => 'required|array',
            'type' => 'required|in:table,room',
            'accommodation-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],
            'branch_id' => 'required|exists:branches,id',
            'price' => 'required|numeric|min:1|max:999',
            'code' => 'required|unique:accommodations,code',
            'capacity' => 'required|integer|min:1|max:100',

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
