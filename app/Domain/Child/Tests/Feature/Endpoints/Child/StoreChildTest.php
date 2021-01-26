<?php

namespace App\Domain\Child\Tests\Feature\Endpoints\Child;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class StoreChildTest extends TestCase
{
    /** @test */
    public function it_should_create_child()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $child = $this->childFactory->make([
            'child-avatar' => UploadedFile::fake()->image('image.jpg'),
            'child-birthdate-certificate' => UploadedFile::fake()->image('image.jpg'),
            'national_id' => '29310011300292',
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.children.store'), $child->toArray()
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'birthdate',
                'birthdate-certificate',
                'relation',
                'status',
                'avatar',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_child_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.children.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_child_if_unauthenticated()
    {
        $this->post(
            route('api.children.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->childFactory = Child::factory();
    }
}
