<?php
namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Reservation\Entities\Reservation;

class IndexReservationsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_reservations_filtered_by_date_between()
    {
        $this->reservationFactory->create([
            'start_date' => '2020-10-10 10:45',
            'end_date' => '2020-10-10 12:00',
        ]);
        $this->reservationFactory->create([
            'start_date' => '2020-10-13 10:45',
            'end_date' => '2020-10-13 12:00',
        ]);
        $this->reservationFactory->create([
            'start_date' => '2020-10-15 10:45',
            'end_date' => '2020-10-15 12:00',
        ]);
        $this->reservationFactory->create([
            'start_date' => '2020-10-11 10:45',
            'end_date' => '2020-10-11 12:00',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?filter[date_between]=2020-10-10,2020-10-13'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_fetch_reservations_with_accommodation()
    {
        $this->reservationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?include=accommodation'
        );
        $this->assertTrue(array_key_exists('accommodation', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_reservations_with_branch()
    {
        $this->reservationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?include=branch'
        );
        $this->assertTrue(array_key_exists('branch', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_reservations_with_creator()
    {
        $this->reservationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?include=creator'
        );
        $this->assertTrue(array_key_exists('creator', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_reservations_with_user()
    {
        $this->reservationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_reservations_by_branch_id()
    {
        $this->reservationFactory->count(5)->create([
            'status' => 'upcoming',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->create([
            'status' => 'done',
            'user_id' => $user->id,
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            sprintf('%s?%s=%s', route('api.reservations.index'), 'filter[branch.id]', $reservation->branch->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_reservations_by_creator_id()
    {
        $this->reservationFactory->count(5)->create([
            'status' => 'upcoming',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $reservation = $this->reservationFactory->count(3)->create([
            'status' => 'done',
            'creator_id' => $user->id,
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            sprintf('%s?%s=%s', route('api.reservations.index'), 'filter[creator.id]', $user->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(3, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_reservations_by_status()
    {
        $this->reservationFactory->count(5)->create([
            'status' => 'upcoming',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $reservation = $this->reservationFactory->create([
            'status' => 'done',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            sprintf('%s?%s=%s', route('api.reservations.index'), 'filter[status]', $reservation->status)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($reservation->status, $response->getData(true)['data'][0]['status']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_reservations_by_user_id()
    {
        $this->reservationFactory->count(5)->create([
            'status' => 'upcoming',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $reservation = $this->reservationFactory->create([
            'status' => 'done',
            'user_id' => $user->id,
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            sprintf('%s?%s=%s', route('api.reservations.index'), 'filter[user.id]', $user->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /**  @test */
    public function it_should_list_all_of_approved_reservations_paginated_by_default()
    {
        $this->reservationFactory->count(5)->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->reservationFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->reservationFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->reservationFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?sort=created_at'
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
        $this->reservationFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->reservationFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->reservationFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.index') . '?sort=-created_at'
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
        $this->reservationFactory = Reservation::factory();
        $this->userFactory = User::factory();
    }
}
