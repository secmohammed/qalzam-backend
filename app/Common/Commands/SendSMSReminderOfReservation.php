<?php

namespace App\Common\Commands;

use Illuminate\Console\Command;
use App\Domain\Reservation\Notifications\ReservationReminder;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;

class SendSMSReminderOfReservation extends Command
{
    /**
     * @var string
     */
    protected $signature = 'reservation:reminder';

    /**
     * @var mixed
     */
    private $reservationRepository;

    /**
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(ReservationRepository $reservationRepository)
    {
        parent::__construct();
        $this->reservationRepository = $reservationRepository;
    }

    public function handle()
    {
        $this->reservationRepository->whereDate(now()->format('Y-m-d'))->get()->each(function ($reservation) {
            $reservation->user->notify(new ReservationReminder($reservation));
        });
    }
}
