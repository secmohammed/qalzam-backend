<?php

namespace App\Domain\Reservation\Http\Exceptions;

use Exception;

class ReservationTimeIsntWithinBranchShiftDurationException extends Exception
{
    /**
     * @var int
     */
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = "Reservation time isn't within the branch shift duration to reserve";
}
