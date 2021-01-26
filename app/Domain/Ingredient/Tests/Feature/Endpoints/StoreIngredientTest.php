<?php

namespace App\Domain\Ingredient\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Ingredient\Entities\Ingredient;

class StoreIngredientTest extends TestCase
{
    /** @test */
    public function it_should_store_ingredient_if_name_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST',
            route('api.ingredients.store'), [
                'name' => 'hello',
                'description' => 'Lorem ipsum occaecat culpa velit aute qui dolor aute exercitation aliquip dolor incididunt proident aliquip sit eu.',
                'ingredient-icon' => UploadedFile::fake()->image('icon.png'),
            ]
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'icon',
                'description',
                'name',
                'created_at_human',

            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_create_ingredient_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.ingredients.store'), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_ingredient_if_name_of_ingredient_already_existing()
    {
        $ingredient = $this->ingredientFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.ingredients.store'), [
                'name' => $ingredient->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_ingredient_if_unauthenticated()
    {
        $this->post(
            route('api.ingredients.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->ingredientFactory = Ingredient::factory();
    }
}
