<?php

namespace App\Domain\Branch\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Location\Entities\Location;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'location_id' => function () {
                return Location::factory()->create()->id;
            },
            'delivery_fee' => $this->faker->numberBetween(1, 1000),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'creator_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withAlbums(int $count = 1, array $attributes = [])
    {
        return $this->hasAlbums($count, $attributes);
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withDeliverers(int $count = 1, $attributes = [])
    {
        return $this->hasAttached(User::factory()->withRole('delivery')->count($count), $attributes, 'deliverers');
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withEmployees(int $count = 1, $attributes = [])
    {
        return $this->hasAttached(User::factory()->count($count), $attributes, 'employees');
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withOrders(int $count = 1, array $attributes = [])
    {
        return $this->hasOrders($count, $attributes + [
            'status' => 'pending',
        ]);
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withProducts(int $count = 1, $attributes = [])
    {
        return $this->hasAttached(ProductVariation::factory()->count($count), $attributes, 'products');
    }

    /**
     * @param int $count
     * @param array $attributes
     * @return mixed
     */
    public function withShift(int $count = 1, array $attributes = [])
    {
        return $this->hasShifts($count, $attributes + [
            'status' => 'active',
        ]);
    }
}
