<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Mail;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\User\Mail\ResetPassword;

class ForgotUserPasswordTest extends TestCase
{
    /** @test */
    public function it_should_send_user_reminder_token_when_user_is_activated()
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->post('/api/auth/forgot-password', [
            'email' => $user->email,
        ])->assertStatus(200);

        Mail::assertQueued(ResetPassword::class, function ($mail) use ($user) {

            return $mail->user->id === $user->id;
        });

        $this->assertDatabaseHas('remindables', [
            'user_id' => $user->id,
            'type' => 'reminder',
        ]);
    }

    /** @test */
    public function it_should_throw_an_exception_if_user_couldnt_be_found()
    {
        $this->post('/api/auth/forgot-password', [
            'email' => 'someone@gmail.com',
        ])->assertStatus(422);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
    }
}
