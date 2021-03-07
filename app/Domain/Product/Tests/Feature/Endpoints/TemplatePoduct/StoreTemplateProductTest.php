<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\TemplatePoduct;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;
use App\Domain\Product\Entities\ProductVariation;

class StoreTemplateProductTest extends TestCase
{
    /** @test */
    public function it_should_let_user_attach_products_for_template()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['quantity' => 10, 'id' => $this->productVariationFactory->create()->id, 'price' => 120],
            ],
        ])->assertStatus(200);
        $this->assertEquals(1, $this->template->fresh()->products()->count());

    }

    /** @test */
    public function it_should_remove_old_products_and_attach_new_ones_to_template()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->template->products()->attach($this->productVariationFactory->create(), [
            'price' => 100,
            'quantity' => 100,
        ]);
        $this->template->products()->attach($this->productVariationFactory->create(), [
            'price' => 100,
            'quantity' => 100,
        ]);
        $this->template->products()->attach($this->productVariationFactory->create(), [
            'price' => 100,
            'quantity' => 100,
        ]);
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['quantity' => 10, 'id' => $this->productVariationFactory->create()->id, 'price' => 120],
            ],
        ])->assertStatus(200);
        $this->assertEquals(1, $this->template->fresh()->products()->count());
    }

    /** @test */
    public function it_shouldnt_store_products_for_template_if_price_isnt_numeric()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['quantity' => 'hello', 'id' => 100, 'price' => 'hello'],
            ],
        ])->assertJsonValidationErrors(['products.0.price']);

    }

    /** @test */
    public function it_shouldnt_store_products_for_template_if_price_isnt_provided()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['quantity' => 'hello', 'id' => 100],
            ],
        ])->assertJsonValidationErrors(['products.0.price']);

    }

    /** @test */
    public function it_shouldnt_store_products_for_template_if_product_id_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['price' => 100, 'quantity' => 'hello', 'id' => 100],
            ],
        ])->assertJsonValidationErrors(['products.0.id']);

    }

    /** @test */
    public function it_shouldnt_store_products_for_template_if_product_id_isnt_provided()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['price' => 100, 'quantity' => 'hello'],
            ],
        ])->assertJsonValidationErrors(['products.0.id']);

    }

    /** @test */
    public function it_shouldnt_store_products_for_template_if_quantity_isnt_numeric()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['id' => $this->productVariationFactory->create()->id, 'price' => 100, 'quantity' => 'hello'],
            ],
        ])->assertJsonValidationErrors(['products.0.quantity']);

    }

    /** @test */
    public function it_shouldnt_store_products_for_template_if_quantity_isnt_provided()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST', route('api.templates.products.store', $this->template), [
            'products' => [
                ['id' => $this->productVariationFactory->create()->id, 'price' => 100],
            ],
        ])->assertJsonValidationErrors(['products.0.quantity']);
    }

    /** @test */
    public function it_shouldnt_store_template_if_unauthenticated()
    {
        $this->post(
            route('api.templates.products.store', $this->template->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->templateFactory = Template::factory();
        $this->template = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $this->productVariationFactory = ProductVariation::factory();
    }
}
