<?php

namespace App\Domain\Reservation\Http\Events;

use App\Domain\Reservation\Entities\Reservation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GenerateReservationPdfInvoice
{
    use Dispatchable, SerializesModels;

    /**
     * @var mixed
     */
    public $reservation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
}
