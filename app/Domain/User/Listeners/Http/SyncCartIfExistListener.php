<?php

namespace App\Domain\User\Listeners\Http;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domain\User\Events\Http\UserLoggedInEvent ;
use App\Common\Facades\Cart;

class SyncCartIfExistListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedInEvent $event
     * @return void
     */
    public function handle(UserLoggedInEvent $event)
    {
        Cart::syncAfterLogin();
    }
}
