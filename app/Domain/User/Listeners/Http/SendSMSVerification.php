<?php

namespace App\Domain\User\Listeners\Http;

use Sms;
use App\Domain\User\Entities\Remindable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User\Events\Common\Http\UserWasRegistered;
use App\Domain\User\Repositories\Contracts\RemindableRepository;

class SendSMSVerification implements ShouldQueue
{
    /**
     * @param RemindableRepository $remindable
     */
    public function __construct(RemindableRepository $remindable)
    {
        $this->remindable = $remindable;
    }

    /**
     * Handle the event.
     *
     * @param  UserWasRegistered $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        $phones = [$event->user->mobile];
        $remindable = $this->remindable->hasOrCreateToken($event->user, 'activation');
        Sms::message("Your Verification Code is : " . $remindable->token)->to($phones)->send();
    }
}
