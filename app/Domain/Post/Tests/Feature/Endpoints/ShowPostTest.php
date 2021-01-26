<?php

namespace App\Domain\Post\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Post\Entities\Post;

class ShowPostTest extends TestCase
{
    /** @test */
    public function it_should_fetch_post_by_id()
    {
        $post = $this->postFactory->withStatus('approved')->create();
        $this->get(
            route('api.posts.show', $post->slug)
        )->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'type',
                'image',
                'title',
                'description',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_post_by_id_if_not_currently_active()
    {
        $post = $this->postFactory->withStatus('disapproved')->create();
        $this->get(
            route('api.posts.show', $post->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_post_by_id_if_not_found()
    {
        $this->get(
            route('api.posts.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->postFactory = Post::factory();
    }
}
