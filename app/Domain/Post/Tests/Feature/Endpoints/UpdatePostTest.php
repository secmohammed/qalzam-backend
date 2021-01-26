<?php

namespace App\Domain\Post\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class UpdatePostTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_post_with_speciality()
    {
        $post = $this->postFactory->withStatus('approved')->create();

        $user = $post->user;
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.posts.update', [
                'post' => $post->slug,
            ]), array_merge($this->post, [
                'title_ar' => 'العنوان بالعربي',
                'description_ar' => 'التفاصيل بالعربي التفاصيل بالعربي التفاصيل بالعربي',
            ])
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_let_user_update_post_if_doesnt_exist()
    {
        $this->put(
            route('api.posts.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_post_if_doesnt_have_permission()
    {
        $post = $this->postFactory->withStatus('approved')->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.posts.update', $post->slug), $this->post
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_post_if_unauthenticated()
    {
        $post = $this->postFactory->withStatus('approved')->create();
        $this->put(
            route('api.posts.update', $post->slug), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->make()->toArray();
        $this->userFactory = User::factory();
        $this->postFactory = Post::factory();
    }
}
