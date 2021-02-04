<?php

namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Notification;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use Database\Seeders\RolesTableSeeder;
use NotificationChannels\Fcm\FcmChannel;
use App\Domain\Reservation\Entities\Reservation;
use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Reservation\Notifications\ReservationCreated;

class StoreReservationTest extends TestCase
{
    /** @test */
    public function it_should_let_user_store_reservation_if_start_date_and_end_date_are_available_and_have_sufficient_permissions()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $this->reservationFactory->create([
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $this->reservationFactory->make([
            'start_date' => now()->addMinutes(35)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(60)->format('Y-m-d H:i:s'),

        ])->toArray())->assertStatus(201);

    }

    /** @test */
    public function it_should_return_reservation_with_total_price_as_meta_which_is_sum_of_order_and_reservation_price()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => $this->accommodationFactory->create([
                'price' => 100,
            ])->id,
            'order_id' => $this->orderFactory->create([
                'subtotal' => 170,
            ])->id,
        ])->toArray();
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation);
        $this->assertEquals("٢٫٧٠ ج.م.‏", $response->getData(true)['meta']['total_price']);

    }

    /** @test */
    public function it_should_save_a_notification_when_reservation_is_stored_successfully()
    {
        Notification::fake();
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => ($accommodation = $this->accommodationFactory->create([
                'price' => 100,
            ]))->id,
            'user_id' => ($assigned = $this->userFactory->create())->id,
        ])->toArray();
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation);

        Notification::assertSentTo(
            $assigned,
            function (ReservationCreated $notification, $channels) use ($response) {

                return $notification->reservation->id === $response->getData(true)['data']['id'] && in_array('database', $channels) && in_array(FcmChannel::class, $channels);
            });
    }

    /** @test */
    public function it_should_take_the_accommodation_price_while_reserving_and_put_it_as_reservation_price()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => ($accommodation = $this->accommodationFactory->create([
                'price' => 100,
            ]))->id,
        ])->toArray();
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(201);
        $this->assertEquals($accommodation->price, $response->getData(true)['data']['price']);
    }

    /** @test */
    public function it_shouldnt_store_reservation_if_accommodation_id_isnt_supplied()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'POST', route('api.reservations.store'), [])->assertStatus(422)->assertJsonValidationErrors(['accommodation_id']);

    }

    /** @test */
    public function it_shouldnt_store_reservation_if_end_date_is_less_than_start_date()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->make([
            'start_date' => now()->addMinutes(10)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(5)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJsonValidationErrors(['end_date']);

    }

    /** @test */
    public function it_shouldnt_store_reservation_if_end_date_is_within_antoher_reservation_date()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $this->reservationFactory->create([
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i:s'),
        ]);
        $reservation = $this->reservationFactory->make([
            'start_date' => now()->addMinutes(10)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(60)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJson([
            'message' => 'Reservation time isn\'t available for table/room, please pickup another date',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_reservation_if_end_date_isnt_in_future()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->make([
            'end_date' => now()->subMinutes(30)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJsonValidationErrors(['end_date']);

    }

    /** @test */
    public function it_shouldnt_store_reservation_if_not_having_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), [])->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_reservation_if_start_date_and_end_date_includes_another_reservation_start_date_and_end_date_range()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $this->reservationFactory->create([
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i:s'),
        ]);
        $reservation = $this->reservationFactory->make([
            'start_date' => now()->addMinutes(10)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(200)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJson([
            'message' => 'Reservation time isn\'t available for table/room, please pickup another date',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_reservation_if_start_date_is_within_antoher_reservation_date()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $this->reservationFactory->create([
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i:s'),
        ]);
        $reservation = $this->reservationFactory->make([
            'start_date' => now()->addMinutes(60)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(200)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJson([
            'message' => "Reservation time isn't available for table/room, please pickup another date",
        ]);
    }

    /** @test */
    public function it_shouldnt_store_reservation_if_start_date_isnt_in_future()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $reservation = $this->reservationFactory->make([
            'start_date' => now()->subMinutes(30)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJsonValidationErrors(['start_date']);
    }

    /** @test */
    public function it_shouldnt_store_reservation_if_unauthenticated()
    {
        $this->post(
            route('api.reservations.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();
        $this->reservationFactory = Reservation::factory();
        $this->accommodationFactory = Accommodation::factory();
    }
}
