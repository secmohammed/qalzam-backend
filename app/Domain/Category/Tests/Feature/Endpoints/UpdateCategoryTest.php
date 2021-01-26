<?php

namespace App\Domain\Category\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Category\Entities\Category;

class UpdateCategoryTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_category_with_existing_parent()
    {
        $category = $this->categoryFactory->withStatus('active')->create();
        $parentCategory = $this->categoryFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.categories.update', $category->id) . '?include=parent', [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'product',
                'parent_id' => $parentCategory->id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'parent_id' => $parentCategory->id,
            'id' => $category->id,
        ]);

    }

    /** @test */
    public function it_should_let_user_update_category_with_product()
    {
        $category = $this->categoryFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.categories.update', [
                'category' => $category->id,
            ]), [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'product',
            ]
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_update_category_with_icon()
    {
        \Storage::fake('local');
        $category = $this->categoryFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.categories.update', $category->id), [
                'name' => 'hello',
                'type' => 'product',
                'name_ar' => $name = 'الاسم بالعربي',
                'icon' => UploadedFile::fake()->image('file.png'),
            ]
        )->assertStatus(200);
        $this->assertNotNull($response->getData(true)['data']['icon']);
    }

    /** @test */
    public function it_shouldnt_let_user_update_category_if_doesnt_exist()
    {
        $this->put(
            route('api.categories.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_category_if_doesnt_have_permission()
    {
        $category = $this->categoryFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.categories.update', $category->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_update_category_with_parent_if_parent_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $category = $this->categoryFactory->withStatus('active')->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.categories.update', $category->id), [
                'name' => 'hello',
                'type' => 'product',
                'parent_id' => 100,
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_update_category_if_name_of_category_already_existing()
    {
        $category = $this->categoryFactory->withStatus('active')->create();
        $anotherCategory = $this->categoryFactory->withStatus('active')->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.categories.update', $category), [
                'name' => $anotherCategory->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_update_category_if_unauthenticated()
    {
        $category = $this->categoryFactory->withStatus('active')->create();
        $this->put(
            route('api.categories.update', $category->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->categoryFactory = Category::factory();
    }
}
