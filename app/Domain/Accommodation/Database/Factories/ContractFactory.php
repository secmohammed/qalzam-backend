<?php

namespace App\Domain\Accommodation\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Template;
use App\Domain\Accommodation\Entities\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * @var array
     */
    protected $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'saturday', 'friday'];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'days' => [$this->faker->randomElement($this->days)],
            'template_id' => function () {
                return Template::factory()->withProducts()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
