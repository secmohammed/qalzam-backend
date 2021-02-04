<?php

namespace App\Domain\Reservation\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;

class CreateReservation implements Pipeline
{
    /**
     * @var mixed
     */
    private $reservationRepository, $accommodationRepository;

    /**
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(ReservationRepository $reservationRepository, AccommodationRepository $accommodationRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->accommodationRepository = $accommodationRepository;
    }

    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($request, \Closure $next)
    {

        return $next(
            $this->reservationRepository->create($request->validated() + [
                'price' => $this->accommodationRepository->find($request->accommodation_id)->price,
            ])
        );
    }
}
