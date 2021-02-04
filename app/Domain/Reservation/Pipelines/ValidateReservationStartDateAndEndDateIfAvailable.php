<?php

namespace App\Domain\Reservation\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Reservation\Http\Exceptions\DateRangeIsntAvailableException;

class ValidateReservationStartDateAndEndDateIfAvailable implements Pipeline
{
    /**
     * @var mixed
     */
    private $reservationRepository;

    /**
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {
        throw_if(
            $this->reservationRepository->whereBetween('start_date', [$request->start_date, $request->end_date])->orWhereBetween('end_date', [$request->start_date, $request->end_date])->exists(),
            DateRangeIsntAvailableException::class
        );

        return $next($request);
    }
}
