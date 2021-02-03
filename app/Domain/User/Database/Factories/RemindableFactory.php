<?php
namespace App\Domain\User\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Remindable;
use Illuminate\Database\Eloquent\Factories\Factory;

class RemindableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = Remindable::class;

    /**
     * @return mixed
     */
    public function activated(bool $activated = true)
    {
        return $this->state(function (array $attributes) use ($activated) {
            return [
                'completed_at' => $activated ? now() : null,
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['activation', 'reminder']),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'expires_at' => now()->addHour(config('qalzam.remindable.expiration')),
            'completed_at' => $this->faker->randomElement([null, now()]),
            'token' => $this->faker->unique()->text(32),
        ];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function type($type)
    {
        return $this->state(function (array $attributes) use ($type) {
            return compact('type');
        });
    }
}
