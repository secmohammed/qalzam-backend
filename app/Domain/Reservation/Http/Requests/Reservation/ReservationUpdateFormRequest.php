<?php

namespace App\Domain\Reservation\Http\Requests\Reservation;
use App\Domain\Reservation\Http\Requests\Reservation\ReservationStoreFormRequest;

class ReservationUpdateFormRequest extends ReservationStoreFormRequest
{
    /**
     * Determine if the reservation is authorized to make this request.
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
        // 'email'    => ['required','unique:reservations,name,'.$this->route()->parameter('reservation').',id'],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }
}
