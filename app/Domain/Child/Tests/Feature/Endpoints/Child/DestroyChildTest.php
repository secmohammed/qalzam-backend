<?php

namespace App\Domain\Child\Tests\Feature\Endpoints\Child;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class DestroyChildTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_children_exist()
    {
        $user = $this->userFactory->create();
        $children = $this->childFactory->count(2)->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $children->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.children.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_child_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.children.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_child_if_unauthenticated()
    {
        $this->delete(
            route('api.children.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_user_if_not_having_permission_of_deleting_user()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.children.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->childFactory = Child::factory();
    }
}
