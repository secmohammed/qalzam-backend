<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use App\Domain\User\Entities\User;

class ChangeUserPasswordTest extends TestCase
{
    /** @test */
    public function it_should_let_user_change_password_if_current_password_passed_correctly()
    {
        $user = User::factory()->create([
            'password' => '$2y$10$oIXdLBWy4sUtetlXmb1D7eDaZHI23z21f2wLGHyRgTJ4CW/6fAu16',
        ]);
        $this->jsonAs($user, 'PUT', '/api/auth/change-password', [
            'old_password' => 'secret123!@#',
            'password' => 'another-secret',
            'password_confirmation' => 'another-secret',
        ])->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_let_user_change_password_if_current_password_passed_incorrectly()
    {
        $user = User::factory()->create([
            'password' => '$2y$10$oIXdLBWy4sUtetlXmb1D7eDaZHI23z21f2wLGHyRgTJ4CW/6fAu16',
        ]);
        $this->jsonAs($user, 'PUT', '/api/auth/change-password', [
            'old_password' => 'secret123!@#!',
            'password' => 'another-secret',
            'password_confirmation' => 'another-secret',
        ])->assertStatus(406);
    }
}
