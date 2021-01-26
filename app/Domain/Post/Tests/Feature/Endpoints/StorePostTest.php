<?php

namespace App\Domain\Post\Tests\Feature\Endpoints;

use Faker\Faker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Category\Entities\Category;
use Illuminate\Foundation\Testing\WithFaker;

class StorePostTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_should_store_post_if_title_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        config(['app.locale' => 'ar']);

        $this->jsonAs($user, 'POST',
            route('api.posts.store'), [
                'title' => 'hello',
                'title_ar' => 'العنوان بالعربي',
                'description' => $this->faker()->paragraph,
                'description_ar' => $description = 'التفاصيل بالعربي التفاصيل بالعربي التفاصيل بالعربي',
                'status' => 'approved',

            ]
        )->assertStatus(201);

    }

    /** @test */
    public function it_should_store_post_with_image()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'POST',
            route('api.posts.store'), [
                'title' => 'hello',
                'title_ar' => 'العنوان بالعربي',
                'description' => $this->faker()->words(40, true),
                'description_ar' => $description = 'التفاصيل بالعربي التفاصيل بالعربي التفاصيل بالعربي',
                'status' => 'approved',
                'image' => UploadedFile::fake()->image('file.png'),
            ]
        )->assertStatus(201);
        $this->assertNotNull($response->getData(true)['data']['image']);
    }

    /** @test */
    public function it_shouldnt_let_user_create_post_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.posts.store'), [
                'title' => 'hello',
                'title_ar' => 'العنوان بالعربي',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_create_post_if_trying_to_attach_a_speciality_as_a_category_to_post()
    {
        $category = $this->categoryFactory->withPostType()->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'POST',
            route('api.posts.store'), [
                'title' => 'hello',
                'description' => $this->faker()->sentence(),
                'status' => 'approved',
                'categories' => [
                    $category->name,
                ],
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_store_post_if_unauthenticated()
    {
        $this->post(
            route('api.posts.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->postFactory = Post::factory();
        $this->categoryFactory = Category::factory();
    }
}
