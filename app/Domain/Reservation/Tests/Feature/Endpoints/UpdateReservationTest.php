<?php

namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Reservation\Entities\Reservation;

class UpdateReservationTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_reservation_without_updating_start_date_and_end_date()
    {
        $reservation = $this->reservationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.reservations.update', $reservation->id), [
                'order_id' => $reservation->order_id,
                'price' => $reservation->price,
                'user_id' => $user->id,
                'accommodation_id' => $reservation->accommodation_id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseHas('reservations', [
            'start_date' => $reservation->start_date->format('Y-m-d H:i:s'),
            'end_date' => $reservation->end_date->format('Y-m-d H:i:s'),
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_reservation_if_doesnt_exist()
    {
        $this->put(
            route('api.reservations.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_reservation_if_doesnt_have_permission()
    {
        $reservation = $this->reservationFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.reservations.update', $reservation->id), $this->reservation
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_reservation_end_date_if_its_in_the_past()
    {
        $reservation = $this->reservationFactory->create([
            'end_date' => now()->subMinutes(30)->format('Y-m-d H:i:s'),
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.reservations.update', $reservation->id), [
                'order_id' => $reservation->order_id,
                'price' => $reservation->price,
                'user_id' => $user->id,
                'start_date' => $reservation->start_date,
                'end_date' => $reservation->end_date->format('Y-m-d H:i:s'),
                'accommodation_id' => $reservation->accommodation_id,
            ]
        )->assertStatus(422)->assertJsonValidationErrors([
            'end_date',
        ]);

    }

    /** @test */
    public function it_shouldnt_update_reservation_if_unauthenticated()
    {
        $reservation = $this->reservationFactory->create();
        $this->put(
            route('api.reservations.update', $reservation->id), []
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_update_reservation_start_date_if_its_in_the_past()
    {
        $reservation = $this->reservationFactory->create([
            'start_date' => now()->subMinutes(30)->format('Y-m-d H:i:s'),
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.reservations.update', $reservation->id), [
                'order_id' => $reservation->order_id,
                'price' => $reservation->price,
                'user_id' => $user->id,
                'start_date' => $reservation->start_date,
                'accommodation_id' => $reservation->accommodation_id,
            ]
        )->assertStatus(422)->assertJsonValidationErrors([
            'start_date',
        ]);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->reservationFactory = Reservation::factory();
    }
}
