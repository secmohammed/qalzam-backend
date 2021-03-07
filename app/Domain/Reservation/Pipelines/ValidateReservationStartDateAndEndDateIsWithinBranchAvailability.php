<?php

namespace App\Domain\Reservation\Pipelines;

use Carbon\Carbon;
use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Reservation\Http\Exceptions\ReservationTimeIsntWithinBranchShiftDurationException;

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
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {

        $reservationStartDate = Carbon::parse($request->start_date);
        $reservationEndDate = Carbon::parse($request->end_date);
        $accommodation = $this->accommodationRepository->find($request->accommodation_id);
        $shift = $accommodation->branch->shifts()->where('day', strtolower(Carbon::parse($request->start_date)->dayName))->firstOrFail();
        $shiftStartDate = Carbon::parse($shift->start_time);
        $shiftEndDate = Carbon::parse($shift->end_time);
        throw_if($shiftStartDate->gt($reservationStartDate) || $reservationStartDate->gt($shiftEndDate) || $reservationEndDate->gt($shiftEndDate) || $reservationEndDate->lt($shiftStartDate), ReservationTimeIsntWithinBranchShiftDurationException::class);

        return $next($request);
    }
}
