<?php

namespace App\Domain\Child\Tests\Feature\Endpoints\Child;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class ShowChildTest extends TestCase
{
    /** @test */
    public function it_should_see_child_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $child = $this->childFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.children.show', $child)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'id',
                'name',
                'birthdate',
                'relation',
                'status',
                'avatar',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_child_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $child = $this->childFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.children.show', $child) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_child_if_currently_inactive()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $child = $this->childFactory->create([
            'status' => 'inactive',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.children.show', $child)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_see_child_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $child = $this->childFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.children.show', $child)
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_see_child_if_not_authenticated()
    {
        $child = $this->childFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.children.show', $child)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->childFactory = Child::factory();

    }
}
