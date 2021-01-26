<?php

namespace App\Domain\Feed\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'child_id' => function () {
                return Child::factory()->withStatus('active')->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'description' => $this->faker->sentence(12),
            'competition_id' => function () {
                return Competition::factory()->withStatus('active')->create()->id;
            },
            'status' => $this->faker->randomElement(['pending', 'winner', 'disqualified']),
        ];
    }
}
