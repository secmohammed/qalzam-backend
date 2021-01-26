<?php

namespace App\Domain\Ingredient\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;
use App\Domain\Ingredient\Entities\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'description' => $this->faker->text(40),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'user_id' => function () {
                return User::factory()->create()->id;
            },

        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withProducts(int $count = 1, $attributes = [])
    {
        return $this->hasAttached(Product::factory($attributes + ['status' => 'active'])->count($count), [], 'products');
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
