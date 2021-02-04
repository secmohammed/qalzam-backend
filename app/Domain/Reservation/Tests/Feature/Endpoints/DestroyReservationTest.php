<?php

namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Reservation\Entities\Reservation;

class DestroyReservationTest extends TestCase
{
    /** @test */
    public function it_should_delete_reservation_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $reservation = $this->reservationFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.reservations.destroy', $reservation->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_reservation_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.reservations.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_reservation_if_not_having_permission_of_deleting_reservation()
    {
        $reservation = $this->reservationFactory->create([
        ]);
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.reservations.destroy', $reservation->id)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_reservation_if_unauthenticated()
    {
        $this->delete(
            route('api.reservations.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->reservationFactory = Reservation::factory();
    }
}
