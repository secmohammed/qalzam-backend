<?php

namespace App\Domain\Ingredient\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Product;
use App\Domain\Ingredient\Entities\Ingredient;

class StoreIngredientProductVariationTest extends TestCase
{
    /** @test */
    public function it_should_let_user_attach_ingredient_to_products_if_both_exists()
    {
        $ingredient = $this->ingredientFactory->create([
            'status' => 'active',
            'description' => 'Aute minim laboris ut id pariatur occaecat laborum in esse nisi.',
        ]);
        $products = $this->productFactory->withStatus('active')->count(3)->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.ingredients.products.store', compact('ingredient')), [
            'products' => $products->pluck('id')->toArray(),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'status',
                'description',
                'created_at_human',
            ],
        ]);
        foreach ($products as $product) {
            $this->assertDatabaseHas('ingredient_product', [
                'product_id' => $product->id,
                'ingredient_id' => $ingredient->id,
            ]);

        }
    }

    /** @test */
    public function it_shouldnt_let_user_attach_ingredient_to_product_if_ingredient_doesnt_exist()
    {

        $this->post(
            route('api.ingredients.products.store', [
                'ingredient' => 1,
            ])
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_attach_ingredient_to_product_if_not_authenticated()
    {
        $ingredient = $this->ingredientFactory->create([
            'status' => 'active',
        ]);
        $product = $this->productFactory->withStatus('active')->create();
        $this->post(
            route('api.ingredients.products.store', compact('ingredient'))
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_attach_ingredient_to_product_if_product_doesnt_exist()
    {
        $ingredient = $this->ingredientFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'POST',
            route('api.ingredients.products.store', [
                'ingredient' => $ingredient,
            ]),
            [1]
        )->assertStatus(422);
    }

    /** @test */
    public function it_shouldnt_let_user_create_ingredient_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.ingredients.store'), [
            ]
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->ingredientFactory = Ingredient::factory();
        $this->productFactory = Product::factory();
        $this->userFactory = User::factory();
    }
}
