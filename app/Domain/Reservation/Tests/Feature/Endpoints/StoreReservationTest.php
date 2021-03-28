<?php

namespace App\Domain\Reservation\Tests\Feature\Endpoints;

use Notification;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use NotificationChannels\Fcm\FcmChannel;
use App\Domain\Branch\Entities\BranchShift;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Reservation\Entities\Reservation;
use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Reservation\Notifications\ReservationCreated;

class StoreReservationTest extends TestCase
{
    /** @test */
    public function it_should_save_a_reservation_if_contract_days_arent_within_accommodation_and_the_price_calculcation_of_reservation_is_free_as_its_not_within_contract_days()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'thursday'
        ]);
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $this->reservationFactory->make([
            'start_date' => $start_date = now()->addMinutes(35),
            'accommodation_id' => $accommodation->id,
            'end_date' => null,

        ])->toArray());
        $this->assertDatabaseHas('reservations', [
            'id' => $response->getData(true)['data']['id'],
            'start_date' => $start_date->format('Y-m-d H:i:s'),
            'end_Date' => $start_date->addHour(4)->format('Y-m-d H:i:s'),
        ]);

    }
    /** @test */
    public function it_should_auto_fill_the_end_date_if_not_supplied_and_create_a_reservation()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday'
        ]);
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $this->reservationFactory->make([
            'start_date' => $start_date = now()->addMinutes(35),
            'accommodation_id' => $accommodation->id,
            'end_date' => null,

        ])->toArray());
        $this->assertDatabaseHas('reservations', [
            'id' => $response->getData(true)['data']['id'],
            'start_date' => $start_date->format('Y-m-d H:i:s'),
            'end_Date' => $start_date->addHour(4)->format('Y-m-d H:i:s'),
        ]);

    }

    /** @test */
    public function it_should_let_user_store_reservation_if_start_date_and_end_date_are_available_and_have_sufficient_permissions_and_store_price_with_submission_of_contract_if_accommodation_type_is_room()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday',
        ]);
        $this->reservationFactory->create([
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'accommodation_id' => $accommodation->id,
        ]);
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $this->reservationFactory->make([
            'start_date' => now()->addMinutes(35),
            'end_date' => now()->addMinutes(60),
            'accommodation_id' => $accommodation->id,

        ])->toArray())->assertStatus(201);

    }

    /** @test */
    public function it_should_let_user_store_reservation_if_start_date_and_end_date_are_available_and_have_sufficient_permissions_and_within_shift_working_hours()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'table',
        ], [
        ]);
        $this->reservationFactory->create([
            'start_date' => now()->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'accommodation_id' => $accommodation->id,
        ]);
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $this->reservationFactory->make([
            'start_date' => now()->addMinutes(35),
            'end_date' => now()->addMinutes(60),
            'accommodation_id' => $accommodation->id,

        ])->toArray())->assertStatus(201);

    }

    /** @test */
    public function it_should_save_a_notification_when_reservation_is_stored_successfully()
    {
        Notification::fake();
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday',
        ]);

        $reservation = $this->reservationFactory->make([
            'accommodation_id' => $accommodation->id,
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
    public function it_should_take_the_accommodation_price_while_reserving_and_put_it_as_reservation_price_in_case_of_room_type()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday', 'tuesday', 'thursday', 'wednesday'
        ]);
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => $accommodation->id,
        ])->toArray();
        $response = $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(201);
        $price = $accommodation->template->products->sum(function ($product) {
            return $product->pivot->price * $product->pivot->quantity;
        });
        $this->assertDatabaseHas('reservations', [
            'id' => $response->getData(true)['data']['id'],
            'price' => $price,
        ]);
    }
    /** @test */
    public function it_shouldnt_let_user_store_reservation_if_start_date_and_date_isnt_within_the_branch_shift_working_hours()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([], [
            'sunday', 'monday', 'tuesday', 'thursday', 'wednesday'
        ]);
        $reservation = $this->reservationFactory->make([
            'start_date' => now()->addMinutes(60 * 8)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(60 * 8.5)->format('Y-m-d H:i:s'),
            'accommodation_id' => $accommodation->id,
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJson([
            "message" => "Reservation time isn't within the branch shift duration to reserve",
        ]);

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
    public function it_shouldnt_store_reservation_if_end_date_is_within_another_reservation_date()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday', 'tuesday', 'thursday', 'wednesday'
        ]);

        $this->reservationFactory->create([
            'accommodation_id' => $accommodation->id,
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i:s'),
        ]);
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => $accommodation->id,
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
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday', 'tuesday', 'thursday', 'wednesday'
        ]);

        $this->reservationFactory->create([
            'accommodation_id' => $accommodation->id,
            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i:s'),
        ]);
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => $accommodation->id,

            'start_date' => now()->addMinutes(10)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(200)->format('Y-m-d H:i:s'),
        ])->toArray();
        $this->jsonAs($user, 'POST', route('api.reservations.store'), $reservation)->assertStatus(422)->assertJson([
            'message' => 'Reservation time isn\'t available for table/room, please pickup another date',
        ]);
    }

    /** @test */
    public function it_shouldnt_store_reservation_if_start_date_is_within_another_reservation_date()
    {
        $this->seed(RolesTableSeeder::class);
        $user = $this->userFactory->create();
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationWithBranchAndFullWeekShift([
            'type' => 'room',
        ], [
            'sunday', 'monday', 'tuesday', 'thursday', 'wednesday'
        ]);

        $this->reservationFactory->create([
            'accommodation_id' => $accommodation->id,

            'start_date' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i:s'),
        ]);
        $reservation = $this->reservationFactory->make([
            'accommodation_id' => $accommodation->id,

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
        $this->branchShiftFactory = BranchShift::factory();
        $this->reservationFactory = Reservation::factory();
        $this->accommodationFactory = Accommodation::factory();
        $this->contractFactory = Contract::factory();
    }

    /**
     * @param array $attributes
     */
    private function accommodationWithBranchAndFullWeekShift($attributes = [], $days = [])
    {
        $accommodation = $this->accommodationFactory->create($attributes);
        $this->branchShiftFactory->withFullWeekShift($accommodation->branch);
        if ($accommodation->type === 'room') {
            $accommodation->contract()->associate(
                $this->contractFactory->create(count($days) ? [
                    'days' => $days,
                ] : [])
            )->save();
        }

        return $accommodation;
    }
}
