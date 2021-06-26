<?php

namespace App\Domain\Accommodation\Http\Requests\Accommodation;

use App\Domain\Accommodation\Entities\Contract;
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
            'name' => 'required|string|min:5|max:255',
            'accommodation-gallery' => 'required|array',
            'type' => 'required|in:table,room,hall',
            'accommodation-gallery.*' => ['required', 'image', 'mimes:png,jpeg,jpg', 'max:2048'],
            'branch_id' => 'required|exists:branches,id',
            'code' => 'required|unique:accommodations,code',
            'categories' => 'required|array',
            'categories.*' => 'required|exists:categories,id',
            'capacity' => 'required|integer|min:1|max:100',
            'contracts' => [
                'nullable','array'
            ],
            'contracts.*' =>'required|exists:contracts,id',

        ];
        // if ($this->request->get('type') === 'room') {
        //     $rules = array_merge($rules, [
        //         'contract_id' => [
        //             'required',
        //             new EnsureContractHasTemplateProducts,
        //         ],

        //     ]);
        // }

        return $rules;
    }

    public function validated()
    {
        // dd(Contract::whereHas('template',function ($query)
        // {
        //     return $query->where('name','free');
        // })->first()->id);
        
        return array_merge(parent::validated(), [
            'user_id' => auth()->id(),
            'contracts'=>  $this->request->get('contracts')?? [ Contract::whereHas('template',function ($query)
            {
                return $query->where('name','free');
            })->first()->id]

        ]);
    }
}
