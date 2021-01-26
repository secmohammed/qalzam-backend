<?php

namespace App\Domain\Discount\Http\Exceptions;

use Exception;

class DiscountIsAlreadyUsedException extends Exception
{
    /**
     * @var int
     */
    protected $code = 422;

    /**
     * @var string
     */
    protected $message = 'Discount is already used.';
}
