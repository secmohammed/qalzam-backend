<?php

namespace App\Domain\Message\Database\Factories;

use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use App\Domain\Message\Entities\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->sentence(),
            'title' => $this->faker->unique()->words(3, true),
            'type' => $this->faker->randomElement(['push_notification', 'sms']),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
