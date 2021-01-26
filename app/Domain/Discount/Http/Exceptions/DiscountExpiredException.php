<?php

namespace App\Domain\Discount\Http\Exceptions;

use Exception;

class DiscountExpiredException extends Exception
{
    /**
     * @var int
     */
    protected $code = 400;

    /**
     * @var string
     */
    protected $message = 'Discount is already expired';
}
