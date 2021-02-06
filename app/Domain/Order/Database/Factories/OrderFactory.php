<?php

namespace App\Domain\Order\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subtotal' => $this->faker->numberBetween(100, 200),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'creator_id' => function () {
                return User::factory()->create()->id;
            },
            'address_id' => function () {
                return Address::factory()->create()->id;
            },
            'branch_id' => function () {
                return Branch::factory()->create()->id;
            },
        ];
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withProducts(int $count = 1, $attributes = [])
    {
        return $this->hasAttached(Product::factory()->count($count), $attributes + [
            'quantity' => 1,
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
}
