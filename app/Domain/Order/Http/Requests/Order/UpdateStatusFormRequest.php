<?php

namespace App\Domain\Order\Http\Requests\Order;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusFormRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
        ];
    }

    /**
     * Determine if the Order is authorized to make this request.
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
            'status' => 'required|in:pending,delivered,picked,processing',
           

        ];

        return $rules;
    }

 
}
