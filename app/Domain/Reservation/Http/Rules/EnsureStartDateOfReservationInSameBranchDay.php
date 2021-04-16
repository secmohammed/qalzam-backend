<?php

namespace App\Domain\Reservation\Http\Rules;

use App\Domain\Accommodation\Entities\Accommodation;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EnsureStartDateOfReservationInSameBranchDay implements Rule
{
    /**
     * @var mixed
     */
    private $reservation;

    /**
     * @param $reservation
     */
    public function __construct()
    {
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'this accommodation  not available at start date day';
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
        $accommodation = Accommodation::find($value);
        // dd($accommodation->branch->shifts,strtolower(Carbon::parse(request()->start_date)->dayName),$accommodation->branch->shifts->where('day', strtolower(Carbon::parse(request()->start_date)->dayName))->first(),$attribute, $value);
       
        // return now()->lt($this->reservation->start_date);
        return $accommodation->branch->shifts->where('day', strtolower(Carbon::parse(request()->start_date)->dayName))->count()>0;
    }
}
