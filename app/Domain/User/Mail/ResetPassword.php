<?php

namespace App\Domain\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Domain\User\Entities\User;
use Illuminate\Queue\SerializesModels;
use App\Domain\User\Entities\Remindable;
use Illuminate\Queue\InteractsWithQueue;
use App\Domain\User\Entities\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * @var mixed
     */
    public $token;

    /**
     * @var mixed
     */
    public $user;

    /**
     * @param User $user
     * @param PasswordReset $passwordReset
     */
    public function __construct(User $user, Remindable $passwordReset)
    {
        $this->user = $user;
        $this->token = $passwordReset->token;
    }

    /**
     * @return mixed
     */
    public function build()
    {
        return $this->markdown('users::mails.resetPassword');
    }
}
