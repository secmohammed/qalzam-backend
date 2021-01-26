<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Product;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class UpdateProductTest extends TestCase
{
    /** @test */
    public function it_should_update_product()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.products.update', $product), ['price' => 100] + $product->toArray()
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'price',
                'status',
                'images',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_product_if_doesnt_exist()
    {
        $this->put(
            route('api.products.update', 1), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_product_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $product = $this->productFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.products.update', $product->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_product_if_unauthenticated()
    {
        $product = $this->productFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.products.update', $product->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productFactory = Product::factory();
    }
}
