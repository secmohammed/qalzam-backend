<?php

namespace App\Domain\Child\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use App\Domain\Location\Entities\Location;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'birthdate' => $this->faker->dateTimeBetween('now', '+30 years')->format('Y-m-d'),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'location_id' => function () {
                return Location::factory()->create()->id;
            },
            'national_id' => $this->faker->regexify('(2|3)[0-9][1-9][0-1][1-9][0-3][1-9](01|02|03|04|11|12|13|14|15|16|17|18|19|21|22|23|24|25|26|27|28|29|31|32|33|34|35|88)\d\d\d\d\d'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'relation' => $this->faker->randomElement(['son', 'daughter', 'grand-son', 'grand-daughter', 'nephew']),

        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withCompetitions(int $count = 1, array $attributes = [])
    {
        return $this->hasAttached(Competition::factory($attributes)->count($count));
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
