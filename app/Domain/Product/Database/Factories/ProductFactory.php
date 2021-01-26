<?php

namespace App\Domain\Product\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->name,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 2000),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function withCategory(int $count = 1, array $attributes = [])
    {
        return $this->hasCategories($count, $attributes + [
            'type' => 'product',
        ]);
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
     * @param int $count
     * @return mixed
     */
    public function withVariation(int $count = 1, array $attributes = [])
    {
        return $this->hasVariations($count, $attributes + [
            'status' => 'active',
        ]);
    }
}
