<?php

namespace App\Domain\Reservation\Http\Rules;

use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Reservation\Entities\Reservation;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EnsureSelectedDateNotReserved implements Rule
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
        return 'this accommodation  has been reserved ';
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
        
        // dd(Reservation::whereBetween('start_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')])->orWhereBetween('end_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')])->first());
             return Reservation::whereBetween('start_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')])->orWhereBetween('end_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')])->where('accommodation_id',request()->accommodation_id)->count()===0;
    }
}
