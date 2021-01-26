<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\Order;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class ShowOrderTest extends TestCase
{
    /** @test */
    public function it_should_let_user_see_order()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $order = $this->orderFactory->create([
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.show', $order)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'subtotal',
                'total',
                'created_at',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_order_with_his_addresss_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = $this->orderFactory->create([
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.show', $order) . '?include=address'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'address',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_order_with_his_products_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = $this->orderFactory->withProducts()->create([
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.orders.show', $order) . '?include=products'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'products',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_order_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $order = $this->orderFactory->create([
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.orders.show', $order) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_order_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $order = $this->orderFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.orders.show', $order)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();

    }
}
