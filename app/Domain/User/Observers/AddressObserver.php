<?php

namespace App\Domain\User\Observers;

use App\Domain\User\Entities\Address;

class AddressObserver
{
    /**
     * @param Address $address
     */
    public function creating(Address $address)
    {
        if ($address->default) {
            $address->user->addresses()->update([
                'default' => false,
            ]);
        }
    }
}
