<?php

namespace App\Domain\User\Events\Http;

use App\Domain\User\Entities\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserWasRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User Instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
