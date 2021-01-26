<?php

namespace App\Domain\Category\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use App\Domain\Category\Entities\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'type' => $this->faker->randomElement(['product', 'post']),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['active', 'inactive']),

        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withChildren(int $count = 1)
    {
        return $this->hasChildren($count);
    }

  

    /**
     * @return mixed
     */
    public function withParent()
    {
        return $this->forParent();
    }

    /**
     * @param int $count
     * @param $status
     * @return mixed
     */
    public function withPost(int $count = 2, $status = 'approved')
    {
        return $this->has(Post::factory()->count($count)->withStatus($status));

    }

    /**
     * @return mixed
     */
    public function withPostType()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'post',
            ];
        });
    }/**
     * @return mixed
     */
    public function withProductType()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'product',
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
}
