<?php

namespace App\Domain\User\Tests\Feature\Endpoints\User;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class DestroyUserTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_user_exists()
    {
        $authUser = $this->userFactory->create();
        $user = $this->userFactory->count(2)->create();
        $this->seed(RolesTableSeeder::class);
        $authUser->roles()->attach(Role::first());

        $ids = implode(',', $user->pluck('id')->toArray());

        $this->jsonAs($authUser, 'DELETE',
            route('api.users.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_user_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.users.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_user_if_not_having_permission_of_deleting_user()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.users.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_user_if_unauthenticated()
    {
        $this->delete(
            route('api.users.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
    }
}
