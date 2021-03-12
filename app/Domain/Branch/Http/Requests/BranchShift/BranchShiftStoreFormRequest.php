<?php

namespace App\Domain\Branch\Http\Requests\BranchShift;

use App\Domain\Branch\Http\Requests\Rules\EnsureBranchHasUniqueShiftPerDay;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class BranchShiftStoreFormRequest extends FormRequest
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
     * Determine if the BranchShift is authorized to make this request.
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
            'day' => [
                'required',
                'in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            ],
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i',
            'status' => 'nullable|in:active,inactive',
            'branch_id' => [
                'required',
                'exists:branches,id',
                app(EnsureBranchHasUniqueShiftPerDay::class, [
                    'day' => $this->request->get('day'),
                ]),
            ],
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
