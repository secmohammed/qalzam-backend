<?php

namespace App\Domain\Post\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class DestroyPostTest extends TestCase
{
    /** @test */
    public function it_should_delete_post_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $post = $this->postFactory->create([
            'status' => 'approved',
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.posts.destroy', $post->slug)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_post_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.posts.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_post_if_not_having_permission_of_deleting_post()
    {
        $post = $this->postFactory->create([
            'status' => 'approved',
        ]);
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.posts.destroy', $post->slug)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_post_if_unauthenticated()
    {
        $this->delete(
            route('api.posts.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->postFactory = Post::factory();
    }
}
