<?php

namespace App\Domain\Location\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;

class UpdateLocationTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_location_with_existing_parent()
    {
        $location = $this->locationFactory->withStatus('active')->create();
        $parentLocation = $this->locationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        config(['app.locale' => 'ar']);

        $response = $this->jsonAs($user, 'PUT',
            route('api.locations.update', $location->id) . '?include=parent', [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'zone',
                'parent_id' => $parentLocation->id,
            ]
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at_human',
            ],
        ]);

        $this->assertDatabaseHas('locations', [
            'parent_id' => $parentLocation->id,
            'id' => $location->id,
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_update_location_if_doesnt_exist()
    {
        $this->put(
            route('api.locations.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_location_if_doesnt_have_permission()
    {
        $location = $this->locationFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.locations.update', $location->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_update_location_with_parent_if_parent_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $location = $this->locationFactory->withStatus('active')->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.locations.update', $location->id), [
                'name' => 'hello',
                'type' => 'speciality',
                'parent_id' => 100,
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_update_location_if_name_of_location_already_existing()
    {
        $location = $this->locationFactory->withStatus('active')->create();
        $anotherLocation = $this->locationFactory->withStatus('active')->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.locations.update', $location), [
                'name' => $anotherLocation->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_update_location_if_unauthenticated()
    {
        $location = $this->locationFactory->withStatus('active')->create();
        $this->put(
            route('api.locations.update', $location->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->locationFactory = Location::factory();
    }
}
