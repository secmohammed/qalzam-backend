<?php

namespace App\Domain\Reservation\Http\Requests\Reservation;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ReservationStoreFormRequest extends FormRequest
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
     * Determine if the Reservation is authorized to make this request.
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
            'start_date' => 'required|after_or_equal:' . now()->format('Y-m-d H:i:s'),
            'end_date' => 'required|after_or_equal:' . $this->request->get('start_date'),
            'accommodation_id' => 'required|exists:accommodations,id',
            'user_id' => 'required|exists:users,id',

        ];

        return $rules;
    }

    public function validated()
    {
        return array_merge(parent::validated(), [
            'creator_id' => auth()->id(),
        ]);
    }
}
