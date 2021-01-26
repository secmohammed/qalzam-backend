<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use JWTAuth;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\User\Http\Resources\User\UserResource;

class GetAuthenticatedUserTest extends TestCase
{
    /** @test */
    public function it_gets_user_by_token()
    {
        $user = User::factory()->create();
        Child::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
        $user->load('children');
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
