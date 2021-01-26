<?php

namespace App\Domain\Discount\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Discount\Entities\Discount;

class StoreDiscountTest extends TestCase
{
    /** @test */
    public function it_should_store_discount_if_code_doesnt_exist()
    {
        \Event::fake();

        $user = $this->userFactory->create();
        $discount = $this->discountFactory->make([
            'expires_at' => now()->addMinutes(10)->format('Y-m-d H:i'),
            'broadcast' => true,

        ])->toArray();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->userFactory->create()->roles()->attach(Role::latest()->first());

        $this->jsonAs($user, 'POST',
            route('api.discounts.store'), $discount
        )->assertStatus(201);

    }

    /** @test */
    public function it_shouldnt_store_discount_if_code_exists()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $discount = $this->discountFactory->create();
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST',
            route('api.discounts.store'), [
                'broadcast' => true,
                'code' => $discount->code,
                'percentage' => 80,
                'number_of_usage' => 30,
                'expires_at' => now()->addDays(1)->format('Y-m-d H:i'),
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_store_discount_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.discounts.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_discount_if_unauthenticated()
    {
        $this->post(
            route('api.discounts.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->discountFactory = Discount::factory();
    }
}
