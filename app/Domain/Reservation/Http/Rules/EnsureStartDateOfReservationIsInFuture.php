<?php

namespace App\Domain\Reservation\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnsureStartDateOfReservationIsInFuture implements Rule
{
    /**
     * @var mixed
     */
    private $reservation;

    /**
     * @param $reservation
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be in the future to be able to modify.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return now()->lt($this->reservation->start_date);
    }
}
