<?php
namespace App\Domain\Post\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\Post\Entities\Post;

class IndexPostsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_posts_with_categories()
    {
        $this->postFactory->withCategory()->withStatus('approved')->create();
        $response = $this->get(
            route('api.posts.index') . '?include=categories'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('categories', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_posts_with_user()
    {
        $this->postFactory->withStatus('approved')->create();
        $response = $this->get(
            route('api.posts.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_posts_by_description()
    {
        $this->postFactory->count(5)->withType('normal')->create();
        $post = $this->postFactory->create([
            'status' => 'approved',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.posts.index'), 'filter[description]', $post->description)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($post->description, $response->getData(true)['data'][0]['description']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_posts_by_slug()
    {
        $this->postFactory->count(5)->withType('normal')->create();
        $post = $this->postFactory->create([
            'status' => 'approved',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.posts.index'), 'filter[slug]', $post->slug)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($post->slug, $response->getData(true)['data'][0]['slug']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_posts_by_title()
    {
        $this->postFactory->count(5)->create();
        $this->postFactory->create([
            'title' => $title = 'hello',
            'status' => 'approved',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.posts.index'), 'filter[title]', $title)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($title, $response->getData(true)['data'][0]['title']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_posts_by_type()
    {
        $this->postFactory->count(5)->withType('normal')->create();
        $this->postFactory->create([
            'type' => $type = 'featured',
            'status' => 'approved',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.posts.index'), 'filter[type]', $type)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($type, $response->getData(true)['data'][0]['type']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /**  @test */
    public function it_should_list_all_of_approved_posts_paginated_by_default()
    {
        $this->postFactory->count(5)->withStatus('approved')->create();
        $this->postFactory->withStatus('disapproved')->create();
        $response = $this->get(
            route('api.posts.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    /** @test */
    public function it_should_return_posts_with_categories_included()
    {
        $posts = $this->postFactory->withCategory(3)->withStatus('approved')->create();
        $response = $this->get(
            route('api.posts.index') . '?include=categories'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('categories', $response->getData(true)['data'][0]));
        $this->assertCount(3, $response->getData(true)['data'][0]['categories']);
    }

    /** @test */
    public function it_should_return_posts_with_user_included()
    {
        $posts = $this->postFactory->withStatus('approved')->create();
        $response = $this->get(
            route('api.posts.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->postFactory->withStatus('approved')->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->postFactory->withStatus('approved')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->postFactory->withStatus('approved')->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.posts.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_by_created_at_descending()
    {
        $this->postFactory->withStatus('approved')->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->postFactory->withStatus('approved')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->postFactory->withStatus('approved')->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.posts.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->postFactory = Post::factory();
    }
}
