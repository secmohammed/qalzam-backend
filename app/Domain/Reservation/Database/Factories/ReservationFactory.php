<?php

namespace App\Domain\Reservation\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Reservation\Entities\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Accommodation\Entities\Accommodation;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->numberBetween(100, 2000),
            'start_date' => now()->addMinutes(60)->format('Y-m-d H:i'),
            'end_date' => now()->addMinutes(120)->format('Y-m-d H:i'),
            'accommodation_id' => function () {
                return Accommodation::factory()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'creator_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
