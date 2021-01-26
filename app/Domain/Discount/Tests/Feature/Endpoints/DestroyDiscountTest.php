<?php

namespace App\Domain\Discount\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Discount\Entities\Discount;

class DestroyDiscountTest extends TestCase
{
    /** @test */
    public function it_should_delete_discount_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $discount = $this->discountFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.discounts.destroy', $discount->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_discount_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.discounts.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_discount_if_not_having_permission_of_deleting_discount()
    {
        $discount = $this->discountFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.discounts.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_discount_if_unauthenticated()
    {
        $this->delete(
            route('api.discounts.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->discountFactory = Discount::factory();
    }
}
