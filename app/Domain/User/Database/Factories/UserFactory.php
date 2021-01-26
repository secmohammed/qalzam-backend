<?php
namespace App\Domain\User\Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    public $model = User::class;

    /**
     * @var array
     */
    protected $mobiles = [
        '01067123849',
        '01030999989',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => preg_replace('/@example\..*/', '@joovlly.com', $this->faker->unique()->safeEmail),
            'mobile' => $this->faker->regexify('^(010|011|012|015)([0-9]{8})$'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

        ];
    }

    /**
     * @return mixed
     */
    public function withRealPhoneNumber()
    {
        // if (app(User::class)->newQuery()->where(['mobile' => $mobile = $this->mobiles[rand(0, count($this->mobiles) - 1)]])->exists() === false) {
        //     return $this->state(function (array $attributes) use ($mobile) {
        //         return compact('mobile');
        //     });
        // }

        return $this->state(function (array $attributes) {
            return [
                'mobile' => $this->faker->unique()->phoneNumber,

            ];
        });
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function withRemindables($attributes = [])
    {
        return $this->hasRemindables($attributes);
    }
}
