<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use JWTAuth;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\User\Http\Resources\User\UserResource;

class GetAuthenticatedUserTest extends TestCase
{
    /** @test */
    public function it_gets_user_by_token()
    {
        $user = User::factory()->create();
        $userResource = new UserResource($user);
        $user->roles()->attach(Role::first());
        $token = JWTAuth::fromUser($user);
        $this->get('/api/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ])->assertResource($userResource);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesTableSeeder::class);
    }
}
