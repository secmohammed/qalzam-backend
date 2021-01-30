<?php

namespace App\Domain\Accommodation\Database\Factories;

use App\Domain\Accommodation\Entities\Accommodation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccommodationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Accommodation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}