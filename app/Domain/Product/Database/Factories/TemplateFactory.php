<?php

namespace App\Domain\Product\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Template;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function withProducts($attributes = [], $count = 1)
    {
        return $this->hasAttached(ProductVariation::factory()->count($count), $attributes + [
            'quantity' => 1,
            'price' => 100,
        ], 'products');
    }
}
