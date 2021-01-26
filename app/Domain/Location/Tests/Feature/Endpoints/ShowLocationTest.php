<?php

namespace App\Domain\Location\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;

class ShowLocationTest extends TestCase
{
    /** @test */
    public function it_should_fetch_location_by_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $location = $this->locationFactory->withStatus('active')->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.locations.show', $location->id)
        )->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_location_by_id_if_not_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $location = $this->locationFactory->withStatus('inactive')->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.locations.show', $location->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_location_by_id_if_not_found()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'GET',
            route('api.locations.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->locationFactory = Location::factory();
    }
}
