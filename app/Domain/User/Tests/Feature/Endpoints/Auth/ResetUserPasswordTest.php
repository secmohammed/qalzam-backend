<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use App\Domain\User\Entities\User;

class ResetUserPasswordTest extends TestCase
{
    /** @test */
    public function it_should_let_user_reset_their_password_if_reminder_can_be_completed()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'active',
        ])->create();

        $this->put(vsprintf('/api/auth/reset-password/%s', [
            $user->remindables->first()->token,
        ]), [
            'password' => 'hellothere',
            'password_confirmation' => 'hellothere',
        ])->assertStatus(200);
        $this->assertDatabaseHas('remindables', [
            'user_id' => $user->id,
            'token' => null,
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_reser_their_password_if_reminder_is_already_expired()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'active',
            'expires_at' => now()->subDays(3),
        ])->create();
        $this->put(vsprintf('/api/auth/reset-password/%s', [
            $user->remindables()->where('type', 'reminder')->first()->token,

        ]), [
            'password' => 'hellothere',
            'password_confirmation' => 'hellothere',
        ])->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_reset_their_password_if_passed_remindable_is_invalid()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'inactive',
        ])->create();
        $this->put(vsprintf('/api/auth/reset-password/%s', [
            'invalidToken',
        ]), [
            'password' => 'hellothere',
            'password_confirmation' => 'hellothere',
        ])->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_reset_their_password_if_remindable_is_inactive()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'inactive',
        ])->create();
        $this->put(vsprintf('/api/auth/reset-password/%s', [
            $user->remindables->first()->token,
        ]), [
            'password' => 'hellothere',
            'password_confirmation' => 'hellothere',
        ])->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_reset_their_password_if_reminder_is_already_completed()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => now()->addHours(1),
            'status' => 'active',
        ])->create();
        $this->put(vsprintf('/api/auth/reset-password/%s', [
            $user->remindables()->where('type', 'reminder')->first()->token,
        ]), [
            'password' => 'hellothere',
            'password_confirmation' => 'hellothere',
        ])->assertStatus(404);
    }
}
