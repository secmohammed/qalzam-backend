<?php

namespace App\Domain\Branch\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Location\Entities\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'location_id' => function () {
                return Location::factory()->create()->id;
            },
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'creator_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
