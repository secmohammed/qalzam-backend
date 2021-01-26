<?php
namespace App\Domain\Location\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;

class IndexLocationsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_locations_with_children_when_available()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->locationFactory->withChildren()->withStatus('active')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.locations.index') . '?include=children'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('children', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_locations_with_parent_when_available()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->locationFactory->withParent()->withStatus('active')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.locations.index') . '?include=parent'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('parent', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_locations_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->locationFactory->count(5)->create();
        $this->locationFactory->create([
            'name' => $name = 'hello',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            sprintf('%s?%s=%s', route('api.locations.index'), 'filter[name]', $name)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($name, $response->getData(true)['data'][0]['name']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /**  @test */
    public function it_should_list_all_of_active_locations_paginated_by_default()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->locationFactory->count(5)->withStatus('active')->create();
        $this->locationFactory->withStatus('inactive')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.locations.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_return_locations_with_user_included()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $locations = $this->locationFactory->withStatus('active')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.locations.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->locationFactory->withStatus('active')->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->locationFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->locationFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.locations.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->locationFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->locationFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->locationFactory->withStatus('active')->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.locations.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->locationFactory = Location::factory();
    }
}
