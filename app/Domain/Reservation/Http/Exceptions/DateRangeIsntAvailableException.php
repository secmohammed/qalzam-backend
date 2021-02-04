<?php

namespace App\Domain\Reservation\Http\Exceptions;

use Exception;

class DateRangeIsntAvailableException extends Exception
{
    /**
     * @var int
     */
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = "Reservation time isn't available for table/room, please pickup another date";
}
