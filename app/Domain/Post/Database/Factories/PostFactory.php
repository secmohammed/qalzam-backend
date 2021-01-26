<?php

namespace App\Domain\Post\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->sentence(1),
            'title' => $this->faker->sentence(1),
            'description' => $this->faker->sentence(30),
            'type' => $this->faker->randomElement(['normal', 'featured']),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['approved', 'disapproved']),

        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withCategory(int $count = 1, array $attributes = [])
    {
        return $this->hasCategories($count, $attributes);
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
     * @param string $type
     * @return mixed
     */
    public function withType(string $type)
    {
        return $this->state(function (array $attributes) use ($type) {
            return compact('type');
        });

    }
}
