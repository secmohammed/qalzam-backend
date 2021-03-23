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
        $reservationStartDate = Carbon::parse($request->start_date);
        $reservationEndDate = Carbon::parse($request->end_date);
        $accommodation = $this->accommodationRepository->find($request->accommodation_id);
        $shift = $accommodation->branch->shifts()->where('day', strtolower(Carbon::parse($request->start_date)->dayName))->firstOrFail();
        // dd($shift, Carbon::parse($request->start_date)->dayName, $accommodation->branch->shifts, $accommodation, $accommodation->branch);
        $shiftStartDate = Carbon::parse($shift->start_time);
        $shiftEndDate = Carbon::parse($shift->end_time);
        $parseReservationStartDateToToday = Carbon::parse(
            Carbon::parse($reservationStartDate)->format('H:i:s')
        );
        $parseReservationEndDateToToday = Carbon::parse(
            Carbon::parse($reservationEndDate)->format('H:i:s')
        );

        throw_if($shiftStartDate->gt(
            $parseReservationStartDateToToday
        ) ||
            $shiftEndDate->lt(
                $parseReservationEndDateToToday

            ) ||
            !$shift
            ||
            $parseReservationStartDateToToday->gt($shiftEndDate) ||
            $parseReservationEndDateToToday->lt($shiftStartDate), ReservationTimeIsntWithinBranchShiftDurationException::class);
        return $next($request);
    }
}
