<?php

namespace App\Domain\Child\Tests\Feature\Endpoints\Child;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class UpdateChildTest extends TestCase
{
    /** @test */
    public function it_should_update_child()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $child = $this->childFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.children.update', $child), $child->toArray() + [

            ]
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'id',
                'name',
                'birthdate',
                'relation',
                'birthdate-certificate',
                'status',
                'avatar',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_child_if_doesnt_exist()
    {
        $this->put(
            route('api.children.update', 1), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_child_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $child = $this->childFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.children.update', $child->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_child_if_unauthenticated()
    {
        $child = $this->childFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.children.update', $child->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->childFactory = Child::factory();
    }
}
