<?php

namespace App\Domain\User\Observers;

use App\Domain\User\Entities\User;

class UserObserver
{
    /**
     * @param User $user
     */
    public function creating(User $user)
    {
        // $user->password = bcrypt($user->password);
    }

    /**
     * @param User $user
     */
    public function updating(User $user)
    {

        if ($user->isDirty('password') && $user->getAttributeValue('password')) {
            $user->password = bcrypt($user->password);
        }
    }
}
