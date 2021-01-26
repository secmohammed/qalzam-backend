<?php

namespace App\Domain\Ingredient\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Ingredient\Entities\Ingredient;

class UpdateIngredientTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_ingredient()
    {
        $ingredient = $this->ingredientFactory->withStatus('active')->create([
            'description' => 'Lorem ipsum cillum deserunt enim deserunt eiusmod eu tempor ut eu fugiat.',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'PUT',
            route('api.ingredients.update', $ingredient->id), [
                'name' => 'hello',
            ] + $ingredient->toArray()
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'status',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_update_ingredient_if_doesnt_exist()
    {
        $this->put(
            route('api.ingredients.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_ingredient_if_doesnt_have_permission()
    {
        $ingredient = $this->ingredientFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.ingredients.update', $ingredient->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_update_ingredient_with_parent_if_parent_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $ingredient = $this->ingredientFactory->withStatus('active')->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.ingredients.update', $ingredient->id), [
                'name' => 'hello',
                'type' => 'speciality',
                'parent_id' => 100,
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_update_ingredient_if_name_of_ingredient_already_existing()
    {
        $ingredient = $this->ingredientFactory->withStatus('active')->create();
        $anotherLocation = $this->ingredientFactory->withStatus('active')->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.ingredients.update', $ingredient), [
                'name' => $anotherLocation->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_update_ingredient_if_unauthenticated()
    {
        $ingredient = $this->ingredientFactory->withStatus('active')->create();
        $this->put(
            route('api.ingredients.update', $ingredient->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->ingredientFactory = Ingredient::factory();
    }
}
