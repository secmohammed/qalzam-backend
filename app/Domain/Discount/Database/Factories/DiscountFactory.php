<?php

namespace App\Domain\Discount\Database\Factories;

use App\Domain\Discount\Entities\Discount;
use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = Discount::class;

    /**
     * @return mixed
     */
    public function alreadyExpired()
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => now()->subWeeks(1)->format('Y-m-d H:m'),
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique(true)->text(32),
            'number_of_usage' => $this->faker->numberBetween(1, 200),
            'type' => $this->faker->randomElement(['percentage', "amount"]),
            'expires_at' => $this->faker->randomElement([now()->format('Y-m-d H:m'), now()->addMinutes(10)->format('Y-m-d H:i')]),
            'user_id' => function () {
                return User::factory()->create()->id;
            },

            'status' => $this->faker->randomElement(['active', 'inactive']),

        ];
    }

    /**
     * @return mixed
     */
    public function doesntExpire()
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => null,
            ];
        });

    }

    /**
     * @param string $status
     * @return mixed
     */
    public function withStatus(string $status)
    {
        return $this->state(function (array $attributes) use ($status) {
            return compact('status');
        });

    }

    /**
     * @param User $user
     * @param int $count
     * @return mixed
     */
    public function withUsersUsing(int $count = 1)
    {
        return $this->hasAttached(User::factory()->count($count), [
            'used_at' => now()->format('Y-m-d H:m'),
        ]);
    }
}
