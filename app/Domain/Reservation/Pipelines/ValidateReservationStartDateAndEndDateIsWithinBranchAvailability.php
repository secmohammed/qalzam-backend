<?php

namespace App\Domain\Reservation\Pipelines;

use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Reservation\Http\Exceptions\ReservationTimeIsntWithinBranchShiftDurationException;
use App\Infrastructure\Pipelines\Pipeline;
use Carbon\Carbon;

class ValidateReservationStartDateAndEndDateIsWithinBranchAvailability implements Pipeline
{
    /**
     * @var mixed
     */
    private $accommodationRepository;

    /**
     * @param AccommodationRepository $accommodationRepository
     */
    public function __construct(AccommodationRepository $accommodationRepository)
    {
        $this->accommodationRepository = $accommodationRepository;
    }

    /**
     * @param $request
     * @param \Closure   $next
     */
    public function handle($request, \Closure $next)
    {
        
        $reservationStartDate = Carbon::parse($request->start_date)->locale('en');
        $reservationEndDate = Carbon::parse($request->validated()['end_date'])->locale('en');
        $accommodation = $this->accommodationRepository->find($request->accommodation_id);
        $shift = $accommodation->branch->shifts()->where('day', strtolower(Carbon::parse($request->start_date)->locale('en')->dayName))->first();
        $shiftStartDate = Carbon::parse($shift->start_time)->locale('en');

        $shiftEndDate = Carbon::parse($shift->end_time)->locale('en');
        $parseReservationStartDateToToday = Carbon::parse(
            Carbon::parse($reservationStartDate)->locale('en')->format('H:i:s')
        );
        $parseReservationEndDateToToday = Carbon::parse(
            Carbon::parse($reservationEndDate)->locale('en')->format('H:i:s')
        );

        // dd( $shiftStartDate->gt($parseReservationStartDateToToday) ,
        // $shiftEndDate->lt($parseReservationEndDateToToday) ,
        // $parseReservationStartDateToToday->gt($shiftEndDate) ,
        // $parseReservationEndDateToToday->lt($shiftStartDate));
        throw_if(
            $shiftStartDate->gt($parseReservationStartDateToToday) ||
            $shiftEndDate->lt($parseReservationEndDateToToday) ||
            $parseReservationStartDateToToday->gt($shiftEndDate) ||
            $parseReservationEndDateToToday->lt($shiftStartDate), ReservationTimeIsntWithinBranchShiftDurationException::class);
        return $next($request);
    }
}
