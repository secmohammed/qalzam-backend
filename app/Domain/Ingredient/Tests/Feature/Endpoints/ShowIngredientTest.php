<?php

namespace App\Domain\Ingredient\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Ingredient\Entities\Ingredient;

class ShowIngredientTest extends TestCase
{
    /** @test */
    public function it_should_fetch_ingredient_by_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ingredient = $this->ingredientFactory->withStatus('active')->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.show', $ingredient->id)
        )->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'status',
                'icon',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_ingredient_by_id_if_not_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ingredient = $this->ingredientFactory->withStatus('inactive')->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.show', $ingredient->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_ingredient_by_id_if_not_found()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'GET',
            route('api.ingredients.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->ingredientFactory = Ingredient::factory();
    }
}
