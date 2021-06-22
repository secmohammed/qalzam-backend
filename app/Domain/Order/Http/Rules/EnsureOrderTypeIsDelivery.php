<?php

namespace App\Domain\Order\Http\Rules;

use App\Domain\Order\Entities\Order;
use Illuminate\Contracts\Validation\Rule;

class EnsureOrderTypeIsDelivery implements Rule
{
    /**
     * @var mixed
     */

    /**
     * @param $type
     */
  
  

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' orders  type is pickup';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Order::whereId($value)->where('type','delivery')->exists();
    }
}
