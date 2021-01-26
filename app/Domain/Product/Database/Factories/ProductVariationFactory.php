<?php

namespace App\Domain\Product\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Product\Entities\ProductVariationType;

class ProductVariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'product_id' => fn() => Product::factory()->create()->id,
            'user_id' => fn() => User::factory()->create()->id,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'price' => $this->faker->randomElement([null, $this->faker->numberBetween(100, 2000)]),
            'product_variation_type_id' => fn() => ProductVariationType::factory()->create()->id,
        ];
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function withProduct($attributes = [])
    {
        return $this->forProduct($attributes + ['status' => 'active']);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function withProductVariationType($attributes = [])
    {
        return $this->hasType($attributes + ['status' => 'active']);
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
