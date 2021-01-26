<?php

namespace App\Domain\Product\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Stock;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'quantity' => $this->faker->numberBetween(100, 1000),
            'product_variation_id' => function () {
                return ProductVariation::factory()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
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
