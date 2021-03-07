<?php

namespace App\Domain\Reservation\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;

class CalculateReservationPrice implements Pipeline
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
        $accommodation = $this->accommodationRepository->with(['template', 'template.products'])->findOrFail($request->accommodation_id);
        if ($accommodation->type === 'room') {
            $price = $accommodation->template->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            });
            $request->merge(compact('price'));
        }

        return $next($request);
    }
}
