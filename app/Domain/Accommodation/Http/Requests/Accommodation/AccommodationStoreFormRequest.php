<?php

namespace App\Domain\Accommodation\Http\Requests\Accommodation;

use App\Domain\Accommodation\Http\Rules\EnsureContractHasTemplateProducts;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|min:5|max:255|unique:accommodations,name',
            'accommodation-gallery' => 'required|array',
            'type' => 'required|in:table,room',
            'accommodation-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],
            'branch_id' => 'required|exists:branches,id',
            'code' => 'required|unique:accommodations,code',
            'capacity' => 'required|integer|min:1|max:100',
        ];
        if ($this->request->get('type') === 'room') {
            $rules = array_merge($rules, [
                'contract_id' => [
                    'required',
                    new EnsureContractHasTemplateProducts,
                ],

            ]);
        }

        return $rules;
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'user_id' => auth()->id(),
        ]);
    }
}
