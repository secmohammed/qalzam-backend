<?php

namespace App\Domain\Reservation\Pipelines;

use App\Infrastructure\Pipelines\Pipeline;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use Carbon\Carbon;
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
        $accommodation = $this->accommodationRepository->findOrFail($request->accommodation_id);
        // in case of room, but free.
        if ($accommodation->type === 'room' && !$accommodation->contract()->whereJsonContains('days', strtolower(Carbon::parse($request->start_date)->dayName))->exists()) {
            return $next($request);
        }
        if ($accommodation->type === 'room') {
            $accommodation->load(['template', 'template.products']);
            $price = $accommodation->template->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            });
            $request->merge(compact('price'));
        }

        return $next($request);
    }
}
