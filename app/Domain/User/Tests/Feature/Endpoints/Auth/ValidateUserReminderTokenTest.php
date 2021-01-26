<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use App\Domain\User\Entities\User;

class ValidateUserReminderTokenTest extends TestCase
{
    /** @test */
    public function it_should_return_404_if_passed_token_is_invalid()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'active',

        ])->create();
        $anotherUser = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'active',

        ])->create();
        $this->get(vsprintf('/api/auth/verify/%s/%s', [
            $user->id,
            $anotherUser->remindables->first()->token,
        ]))->assertStatus(404);
    }

    /** @test */
    public function it_should_return_token_if_token_is_correct()
    {
        $user = User::factory()->withRemindables([
            'type' => 'reminder',
            'completed_at' => null,
            'status' => 'active',
        ])->create();
        $this->get(vsprintf('/api/auth/verify/%s/%s', [
            $user->id,
            $user->remindables->first()->token,
        ]))->assertJsonStructure([
            'token',
        ]);
    }
}
