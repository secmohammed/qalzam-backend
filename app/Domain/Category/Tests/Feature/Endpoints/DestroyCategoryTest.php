<?php

namespace App\Domain\Category\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Category\Entities\Category;

class DestroyCategoryTest extends TestCase
{
    /** @test */
    public function it_should_delete_category_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $category = $this->categoryFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.categories.destroy', $category->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_delete_children_of_categories_when_parent_is_deleted()
    {
        $user = $this->userFactory->create();
        $category = $this->categoryFactory->withParent()->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.categories.destroy', $category->parent->id)
        )->assertStatus(200);
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    /** @test */
    public function it_shouldnt_destroy_category_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.categories.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_category_if_not_having_permission_of_deleting_category()
    {
        $category = $this->categoryFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.categories.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_category_if_unauthenticated()
    {
        $this->delete(
            route('api.categories.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->categoryFactory = Category::factory();
    }
}
