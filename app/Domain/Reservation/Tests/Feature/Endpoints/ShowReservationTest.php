<?php

namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Reservation\Entities\Reservation;

class ShowReservationTest extends TestCase
{
    /** @test */
    public function it_should_fetch_reservation_by_id()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.reservations.show', $reservation->id) . '?include=user'
        )->assertJsonStructure([
            'data' => [
                'id',
                'price',
                'status',
                'start_date',
                'end_date',
                'created_at_human',
                'user',
            ],
            'meta' => ['total_price'],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_reservation_by_id_if_not_currently_active()
    {
        $reservation = $this->reservationFactory->create();
        $this->get(
            route('api.reservations.show', $reservation->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_reservation_by_id_if_not_found()
    {
        $this->get(
            route('api.reservations.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->reservationFactory = Reservation::factory();
    }
}
