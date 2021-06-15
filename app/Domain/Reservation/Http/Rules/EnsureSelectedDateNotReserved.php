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
        // dd(request('reservation'));
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
        if($reservation = request('reservation') && request('reservation')->accommodation_id ===$value )
        {
    
            $reservation=    Reservation::where('accommodation_id',request()->accommodation_id)
            ->where('status' , 'upcoming')
               ->where(function ($query)
               {
                return   $query-> whereBetween('start_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')])
                   ->orWhereBetween('end_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')]);
   
               })->first();
                    if($reservation && $reservation->id === request('reservation')->id)
                    {
                        return true;
                    }
                    return false;


        }
     
return  Reservation::where('accommodation_id',request()->accommodation_id)
->where('status' , 'upcoming')
   ->where(function ($query)
   {
    return   $query-> whereBetween('start_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')])
       ->orWhereBetween('end_date', [Carbon::parse(request()->start_date)->locale('en')->format('Y-m-d H:i:s'),Carbon::parse(request()->start_date)->addHours(4)->locale('en')->format('Y-m-d H:i:s')]);

   })->count() === 0;
      }
}
