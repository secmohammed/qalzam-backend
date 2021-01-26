<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use App\Domain\User\Entities\User;

class LogoutUserTest extends TestCase
{
    /** @test */
    public function it_logsout_user_successfully()
    {
        $user = User::factory()->create();
        $this->jsonAs($user, 'POST', '/api/auth/logout')->assertStatus(200);
    }
}
