<?php

namespace App\Domain\User\Entities\Traits\CustomAttributes;

trait UserAttributes
{
    public function getFullAddressAttribute()
    {
        $address = $this->addresses->where('default', true)->first();
        if (!$address) {
            return;
        }
        return $address->address_1 . ' ' . $address->location->prevNodes()->get()->push($address->location)->reverse()->implode('name', ',');
    }
}
