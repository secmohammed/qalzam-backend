<?php

namespace App\Domain\Product\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Product\Entities\ProductVariationType;

class ProductVariationTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariationType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'user_id' => fn() => User::factory()->create()->id,
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
