<?php

namespace App\Domain\Competition\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use App\Domain\Location\Entities\Location;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Competition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(230),
            'start_date' => now()->format('Y-m-d H:i'),
            'end_date' => now()->addDays(25)->format('Y-m-d H:i'),
            'min_age' => $this->faker->numberBetween(5, 8),
            'max_age' => $this->faker->numberBetween(9, 15),
            'featured' => $this->faker->randomElement(['featured', 'normal']),
            'location_id' => function () {
                return Location::factory()->create()->id;
            },
            'gender' => $this->faker->randomElement(['male', 'female', 'both']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'type' => $this->faker->randomElement(['video', 'image', 'check-in']),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withChildren(int $count = 1, array $attributes = [])
    {
        return $this->hasAttached(Child::factory($attributes)->count($count));
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withFeeds(int $count = 1, array $attributes = [])
    {
        return $this->has(Feed::factory($attributes)->count($count));
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
