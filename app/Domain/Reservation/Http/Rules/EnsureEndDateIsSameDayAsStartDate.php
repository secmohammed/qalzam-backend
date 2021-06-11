<?php

namespace App\Domain\Reservation\Http\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class EnsureEndDateIsSameDayAsStartDate implements Rule
{
    /**
     * @var mixed
     */
    private $start_date;

    /**
     * @param $reservation
     */
    public function __construct($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be in the same day as start date.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        return   Str::lower( Carbon::parse($value)->dayName) === Str::lower( Carbon::parse($this->start_date)->dayName);
    }
}
