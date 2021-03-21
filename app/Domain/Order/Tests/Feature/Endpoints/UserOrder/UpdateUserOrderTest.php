<?php

namespace App\Domain\Order\Tests\Feature\Endpoints\UserOrder;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\ProductVariation;

class UpdateUserOrderTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_update_order()
    {
        $user = $this->userFactory->create();
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productVariationFactory->create([
            'status' => 'active',
        ]);
        $branch = Branch::factory()->create();
        $branch->products()->attach($product);
        $order = Order::factory()->create();
        $order->products()->attach($product);
        $response = $this->jsonAs($user, 'PUT',
            route('api.user_orders.update', $order->id), ['price' => 100, 'branch_id' => $branch->id, 'address_id' => $address->id] + $product->toArray()
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
            route('api.user_orders.update', 1), []
        )->assertStatus(404);
    }

    /**
     * @test
     */
    public function it_shouldnt_let_user_update_order_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $order = Order::factory()->create();
        $this->jsonAs($user, 'PUT',
            route('api.user_orders.update', $order->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /**
     * @test
     */
    public function it_shouldnt_update_order_if_unauthenticated()
    {
        $order = Order::factory()->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.user_orders.update', $order->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productVariationFactory = ProductVariation::factory();
    }
}
