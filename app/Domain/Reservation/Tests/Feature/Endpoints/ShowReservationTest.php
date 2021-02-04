<?php

namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Reservation\Entities\Reservation;

class ShowReservationTest extends TestCase
{
    /** @test */
    public function it_should_fetch_reservation_by_id()
    {
        $reservation = $this->reservationFactory->withStatus('approved')->create();
        $this->get(
            route('api.reservations.show', $reservation->slug)
        )->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'type',
                'image',
                'title',
                'description',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_reservation_by_id_if_not_currently_active()
    {
        $reservation = $this->reservationFactory->withStatus('disapproved')->create();
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
        $this->reservationFactory = Reservation::factory();
    }
}
