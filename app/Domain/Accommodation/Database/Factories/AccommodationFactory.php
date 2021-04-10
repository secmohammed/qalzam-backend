<?php

namespace App\Domain\Accommodation\Database\Factories;

use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Branch\Entities\Branch;
use App\Domain\User\Entities\User;
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
        $type = $this->faker->randomElement(['room', 'table', 'hall']);

        return [
            'name' => $this->faker->unique()->name,
            'code' => $this->faker->unique()->bankAccountNumber,
            'branch_id' => function () {
                return Branch::factory()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'contract_id' => function () {
                return Contract::factory()->create(["days" => ["monday"]])->id;
            },
            'capacity' => $this->faker->numberBetween(1, 100),
            'type' => $type,
        ];
    }

    /**
     * @return mixed
     */
    public function withRoomContract()
    {

        return $this->state(function (array $attributes) {
            $contract_id = Contract::factory()->create()->id;

            return ['contract_id' => $contract_id, 'type' => 'room'];
        });
    }

    /**
     * @param string $type
     * @return mixed
     */
    public function withTable(string $type)
    {
        return $this->state(function (array $attributes) use ($type) {
            return compact('type');
        });
    }
}
