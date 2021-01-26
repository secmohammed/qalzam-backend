<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Stock;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Product\Entities\Stock;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class StoreStockTest extends TestCase
{
    /** @test */
    public function it_should_create_stock()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $stock = $this->stockFactory->make([

        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.stocks.store'), $stock->toArray()
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'quantity',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_stock_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.stocks.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_stock_if_unauthenticated()
    {
        $this->post(
            route('api.stocks.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->stockFactory = Stock::factory();
    }
}
