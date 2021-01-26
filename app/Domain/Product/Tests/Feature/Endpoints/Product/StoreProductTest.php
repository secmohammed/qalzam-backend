<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Product;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;

class StoreProductTest extends TestCase
{
    /** @test */
    public function it_should_create_product()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $product = $this->productFactory->make([
            'product-images' => [UploadedFile::fake()->image('image.jpg')],
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.products.store'), ['price' => 100] + $product->toArray()
        )->assertStatus(201)->assertJsonStructure([
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
    public function it_shouldnt_let_user_create_product_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.products.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_product_if_unauthenticated()
    {
        $this->post(
            route('api.products.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->productFactory = Product::factory();
    }
}
