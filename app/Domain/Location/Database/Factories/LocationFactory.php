<?php

namespace App\Domain\Location\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Location\Entities\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique(true)->text(32),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'type' => $this->faker->randomElement(['city', 'country', 'zone', 'district']),

        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withChildren(int $count = 1, $attributes = [])
    {
        return $this->hasChildren($count, $attributes);
    }

    /**
     * @return mixed
     */
    public function withParent($attributes = [])
    {
        return $this->forParent($attributes);
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
}
