<?php

namespace App\Domain\Location\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;

class DestroyLocationTest extends TestCase
{
    /** @test */
    public function it_should_delete_children_of_locations_when_parent_is_deleted()
    {
        $user = $this->userFactory->create();
        $location = $this->locationFactory->withParent([
            'status' => 'active',
        ])->withStatus('active')->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.locations.destroy', $location->parent->id)
        )->assertStatus(200);
        $this->assertDatabaseMissing('locations', [
            'id' => $location->id,
        ]);
    }

    /** @test */
    public function it_should_delete_location_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $location = $this->locationFactory->count(2)->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $location->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.locations.destroy', $ids)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_location_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.locations.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_location_if_not_having_permission_of_deleting_location()
    {
        $location = $this->locationFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.locations.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_location_if_unauthenticated()
    {
        $this->delete(
            route('api.locations.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->locationFactory = Location::factory();
    }
}
