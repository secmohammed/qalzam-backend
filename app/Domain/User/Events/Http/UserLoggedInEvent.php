<?php

namespace App\Domain\User\Events\Http;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedInEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User Instance.
     *
     * @var User
     */
    public $user;

    /**
     * Additional Data.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $data = [])
    {
        $this->user = $user;
        $this->data = $data;
    }
}
