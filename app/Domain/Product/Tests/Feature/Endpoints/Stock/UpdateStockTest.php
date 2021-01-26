<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Stock;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Product\Entities\Stock;
use Database\Seeders\RolesTableSeeder;

class UpdateStockTest extends TestCase
{
    /** @test */
    public function it_should_update_stock()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $stock = $this->stockFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.stocks.update', $stock->id), $stock->toArray()
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'quantity',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_stock_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'PUT',
            route('api.stocks.update', 100000), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_stock_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $stock = $this->stockFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs($user, 'PUT',
            route('api.stocks.update', $stock->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_stock_if_unauthenticated()
    {
        $stock = $this->stockFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.stocks.update', $stock->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->stockFactory = Stock::factory();
    }
}
