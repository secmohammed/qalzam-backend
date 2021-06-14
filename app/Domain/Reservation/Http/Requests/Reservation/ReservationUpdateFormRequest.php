<?php

namespace App\Domain\Reservation\Http\Requests\Reservation;

use App\Domain\Reservation\Http\Rules\EnsureEndDateOfReservationIsInFuture;
use App\Domain\Reservation\Http\Rules\EnsureStartDateOfReservationIsInFuture;
use App\Domain\Reservation\Http\Requests\Reservation\ReservationStoreFormRequest;

class ReservationUpdateFormRequest extends ReservationStoreFormRequest
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
            'start_date' => ['required_with:end_date', new EnsureStartDateOfReservationIsInFuture($this->reservation), 'after_or_equal:' . now()->format('Y-m-d H:i:s')],
            // 'end_date' => ['required_with:start_date', 'after_or_equal:' . $this->request->get('start_date'), new EnsureEndDateOfReservationIsInFuture($this->reservation)],
        ];

        return array_merge(parent::rules(), $rules);
    }
}
