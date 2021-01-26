<?php

namespace App\Domain\Category\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Category\Entities\Category;

class StoreCategoryTest extends TestCase
{
    /** @test */
    public function it_should_create_category_with_icon()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        config(['app.locale' => 'ar']);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => 'hello',
                'type' => 'product',
                'name_ar' => $name = 'الاسم بالعربي',
                'icon' => UploadedFile::fake()->image('file.png'),
            ]
        )->assertStatus(201);
        $this->assertNotNull($response->getData(true)['data']['icon']);
    }

    /** @test */
    public function it_should_let_user_create_category_with_existing_parent()
    {
        $category = $this->categoryFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => 'hello',
                'name_ar' => 'الاسم بالعربي',
                'type' => 'product',
                'parent_id' => $category->id,
            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_should_let_user_create_category_with_product()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'product',
            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_should_store_category_if_name_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => 'hello',
                'type' => 'product',
                'name_ar' => 'الاسم بالعربي',
            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_shouldnt_let_user_create_category_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_create_category_with_parent_if_parent_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => 'hello',
                'type' => 'product',
                'parent_id' => 1,
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_store_category_if_name_of_category_already_existing()
    {
        $category = $this->categoryFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.categories.store'), [
                'name' => $category->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_category_if_unauthenticated()
    {
        $this->post(
            route('api.categories.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->categoryFactory = Category::factory();
    }
}
