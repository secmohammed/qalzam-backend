<?php

namespace App\Common\Commands;

use Illuminate\Console\Command;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;

class UpdateReservationStatus extends Command
{
    /**
     * @var string
     */
    protected $signature = 'reservation:update-statuses';

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
        $this->reservationRepository->whereDate(yesterday()->format('Y-m-d'))->update([
            'status' => 'done',
        ]);
    }
}
