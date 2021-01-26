<?php

namespace App\Domain\Ingredient\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Ingredient\Entities\Ingredient;

class DestroyIngredientTest extends TestCase
{
    /** @test */
    public function it_should_delete_ingredient_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $ingredient = $this->ingredientFactory->count(2)->create([
            'status' => 'active',
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $ids = implode(',', $ingredient->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.ingredients.destroy', $ids)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_ingredient_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.ingredients.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_ingredient_if_not_having_permission_of_deleting_ingredient()
    {
        $ingredient = $this->ingredientFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.ingredients.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_ingredient_if_unauthenticated()
    {
        $this->delete(
            route('api.ingredients.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->ingredientFactory = Ingredient::factory();
    }
}
