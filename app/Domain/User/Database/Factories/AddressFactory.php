<?php

namespace App\Domain\User\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Address;
use App\Domain\Location\Entities\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address_1' => $this->faker->unique()->address,
            'landmark' => $this->faker->buildingNumber,
            'postal_code' => $this->faker->postcode,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'default' => $this->faker->boolean,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'location_id' => function () {
                return Location::factory()->create()->id;
            },
        ];
    }
}
