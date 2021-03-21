<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\Order;

use Tests\TestCase;
use Illuminate\Support\Arr;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class UpdateOrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_update_order()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $address = $this->addressFactory->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
        $order = $this->orderFactory->withProducts()->create([
            'status' => 'pending',
            'address_id' => $address->id,
            'user_id' => $user->id,
        ]);
        $order->branch->products()->attach($order->products);
        $response = $this->jsonAs($user, 'PUT',
            route('api.orders.update', $order->id), Arr::except($order->toArray(), ['products', 'branch'])
        );
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'created_at',
                'subtotal',
                'total',
            ],
        ]);

    }

    /**
     * @test
     */
    public function it_shouldnt_let_user_update_order_if_doesnt_exist()
    {
        $this->put(
            route('api.orders.update', 1), []
        )->assertStatus(404);
    }

    /**
     * @test
     */
    public function it_shouldnt_let_user_update_order_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $order = $this->orderFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.orders.update', $order->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /**
     * @test
     */
    public function it_shouldnt_update_order_if_unauthenticated()
    {
        $order = $this->orderFactory->create([
            'status' => 'pending',
        ]);
        $this->put(
            route('api.orders.update', $order->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->orderFactory = Order::factory();
        $this->addressFactory = Address::factory();
    }
}
