<?php

namespace App\Domain\Branch\Database\Factories;

use App\Domain\Branch\Entities\Branch;
use App\Domain\Branch\Entities\BranchShift;
use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BranchShiftFactory extends Factory
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
    protected $model = BranchShift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_time' => now()->subMinutes(60)->format('H:i'),
            'end_time' => now()->addMinutes(60 * 7)->format('H:i'),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'branch_id' => function () {
                return Branch::factory()->create()->id;

            },
            'day' => $this->faker->randomElement($this->days),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * @return mixed
     */
    public function withBranch(int $count = 1)
    {
        return $this->has(Branch::factory()->count($count));
    }

    /**
     * @return mixed
     */
    public function withFullWeekShift($branch = null)
    {
        $shifts = collect();
        $branch = $branch ?? Branch::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $shifts->push($this->withStatus('active')->create([
                'day' => $this->days[$i],
                'branch_id' => $branch->id,
            ]));
        }

        return $shifts;
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
